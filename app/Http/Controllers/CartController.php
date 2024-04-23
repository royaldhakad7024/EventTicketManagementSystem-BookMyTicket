<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Events;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{

    public function ShowCart()                                          // Show cart page to user
    {
        // get the current user info
        $user = Auth::user();

        // Check if the item in the cart it deleted by the organizer then it will automaticly delete from cart table
        Cart::where('user_id', $user->id)
            ->whereDoesntHave('event', function ($query) {
                $query->whereNull('deleted_at');
            })->delete();

        // Fetch the cart data of the user
        $cartItems = Cart::where('user_id', $user->id)
            ->with('event')->orderByDesc('updated_at')
            ->get();
        // calculate total item , ticket , price of the whole cart 
        $SubTotal = Cart::where('user_id', $user->id)->sum('total_price');
        $ticket = Cart::where('user_id', $user->id)->sum('quantity');
        $Totalitem = Cart::where('user_id', $user->id)->count();
        return view('userProfile.Cart', compact('cartItems', 'SubTotal', 'ticket', 'Totalitem'));
    }


    public function AddtoCart($id)                                       // Add to cart table
    {
        // get the current data of the user  who is trying to add into the cart.
        $user = Auth::user();
        $user_id = $user->id;

        // Fetch all the data related to that event
        $event = Events::findOrFail($id);
        $price = $event->price;
        $organizer_id = $event->organizer_id;

        // Check if event has sufficient quantity of ticket if not then show message accordingly
        if ($event->quantity <= 1) {
            return redirect()->back()->with('error', 'Insufficient quantity for Ticket : ' . $event->name);
        }

        // Check if the ticket related that event is already in cart or not
        $cartItem = Cart::where('user_id', $user_id)
            ->where('event_id', $id)
            ->first();

        // if the ticket is already in the cart then it will only increase the quantity of the ticket
        if ($cartItem) {
            $cartItem->increment('quantity');
            $cartItem->update([
                'total_price' => $cartItem->quantity * $price,
            ]);
            // if the ticket is new then it will create new entry for the ticket into cart
        } else {
            Cart::create([
                'user_id' => $user_id,
                'event_id' => $id,
                'organizer_id' => $organizer_id,
                'quantity' => 1,
                'price' => $price,
                'total_price' => $price,
            ]);
        }
        return redirect('dashboard')->with('success', 'Added to Cart!');
    }



    public function paymentGateway()                                     // Redirect to payment gate for order
    {
        // Set your Stripe API key.
        \Stripe\Stripe::setApiKey(config('stripe.sk'));
        // Get the current user's data
        $user = Auth::user();
        $email = $user->email;
        // get total price , tickets and other info related to ticket
        $SubTotal = Cart::where('user_id', $user->id)->sum('total_price');
        $ticket = Cart::where('user_id', $user->id)->sum('quantity');
        $eventNames = Cart::where('user_id', $user->id)->with('event')->get();
        $description = 'Purchase total  ' . $ticket . ' tickets for ';
        // Show description about all ticket.
        foreach ($eventNames as $eventName) {
            $description .= $eventName->event->name . ' ' . $eventName->quantity . ' Tickets, ';
        }

        // Create a Payment Intent id for payment transition id 
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $SubTotal * 100,                                  // Convert Amount in cents
            'currency' => 'INR',                                          //  Currency code
            'description' => 'Payment for BookMyTicket.com',
            'metadata' => [
                'user_id' => $user->id,
                'email' => $email,
            ],
        ]);

        // create payment gateway session for payent
        $paymentGateway = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],                          // mode of the payment
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'INR',
                        'product_data' => [
                            'name' => 'BookMyTicket.com',
                            'description' => $description,
                        ],
                        'unit_amount' => $SubTotal * 100,                // Convert to cents
                    ],
                    'quantity' => 1,
                ],
            ],
            'customer_email' => $email,                                  // add customer's email id
            'billing_address_collection' => 'required',                  // Request customer's blilling address
            'mode' => 'payment',
            'success_url' => route('CheckOutOrder') . '?payment_intent=' . $paymentIntent->id,
            'cancel_url' => route('cart'),                               // On cancel order it will redirect back to cart 
        ]);
        // it will redirect to stripe payment gateway url with payment intent id
        return redirect()->away($paymentGateway->url);
    }


    public function CheckOutOrder(Request $request)                      // Place order after successfull payment
    {

        $user = Auth::user();                                            //Get current user's data from authintication.
        $cartItems = Cart::where('user_id', $user->id)->get();
        $paymentIntentId = $request->input('payment_intent');            // Retrieve the payment intent id from the request
        // Create orders for each cart item
        foreach ($cartItems as $item) {
            Events::where('id', $item->event_id)->decrement('quantity', $item->quantity);
            Order::create([
                'user_id' => $item->user_id,
                'event_id' => $item->event_id,
                'organizer_id' => $item->organizer_id,
                'quantity' => $item->quantity,
                'price' => $item->event->price,
                'total_price' => $item->total_price,
                'transaction_id' => $paymentIntentId,
            ]);
        }

        // After checkout it will empty the cart table
        Cart::where('user_id', $user->id)->delete();

        return redirect('/cart')->with('success', 'Your Order is Placed !!');
    }


    public function increaseQuantity($id)                                // Increase Quantity of the ticket.
    {
        $user = Auth::user();                                            // Get the current user's info 
        $cart = Cart::where('id', $id)->first();

        // Check if the event has sufficient quantity of ticket
        $event = Events::findOrFail($cart->event_id);
        // if has then it will increase the quantity and price accordingly
        if ($event->quantity > $cart->quantity) {
            $cart->increment('quantity');
            $cart->update(['total_price' => $cart->quantity * $cart->price]);

            $SubTotal = Cart::where('user_id', $user->id)->sum('total_price');
            $ticket = Cart::where('user_id', $user->id)->sum('quantity');
            // it will sent json data to through ajax request to web page
            return response()->json([
                'quantity' => $cart->quantity,
                'SubTotal' => '₹' . number_format($SubTotal),
                'ticket' => number_format($ticket),
            ]);
            // if Ticket has insufficient  quantity then show an error message.
        } else {
            return response()->json(['error' => 'Insufficient quantity for Ticket : ' . $event->name]);
        }
    }
    public function decreaseQuantity($id)                               // Decrease the quanityt of the ticket
    {
        $user = Auth::user();                                           // get current user's info
        $cart = Cart::where('id', $id)->first();

        // If the quantity is less than 1 the it will delete the item from the cart
        if ($cart->quantity <= 1) {
            return response()->json(['delete' => true]);
        } else {
            $cart->decrement('quantity');
            $cart->update(['total_price' => $cart->quantity * $cart->price]);
            $SubTotal = Cart::where('user_id', $user->id)->sum('total_price');
            $ticket = Cart::where('user_id', $user->id)->sum('quantity');
            return response()->json([
                'quantity' => $cart->quantity,
                'SubTotal' => '₹' . number_format($SubTotal),
                'ticket' => number_format($ticket),
            ]);
        }
    }

    public function DeleteFromCart($id)                                 // Delete item form Cart
    {
        Cart::where("id", $id)->delete();
        return redirect()->back()->with("error", "Deleted from Cart!");
    }
}
