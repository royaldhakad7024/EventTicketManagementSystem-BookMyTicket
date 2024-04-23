<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function UserPurchaseOrder(Request $request) 
    {
        $user_id = Auth::id();
        $orders = Order::where('user_id', $user_id)->with('event')->orderByDesc('created_at')->paginate(5);
        $sortBy = $request->query('sort_by');
        switch ($sortBy) {
            // case 'name':
            //     $orders = Order::where('user_id', $user_id)
            //         ->with(['event' => function ($query) {
            //             $query->orderBy('name', 'asc');
            //         }])
            //         ->paginate(5);
            //     break;
            // case 'venue':
            //     $orders = Order::where('user_id', $user_id)
            //         ->with(['event' => function ($query) {
            //             $query->orderBy('venue', 'asc');
            //         }])
            //         ->paginate(5);
            //     break;
            // case 'time':
            //     $orders = Order::where('user_id', $user_id)
            //         ->with(['event' => function ($query) {
            //             $query->orderBy('time', 'asc');
            //         }])
            //         ->paginate(5);
            //     break;
            // case 'date':
            //     $orders = Order::where('user_id', $user_id)
            //         ->with(['event' => function ($query) {
            //             $query->orderBy('date', 'asc');
            //         }])
            //         ->paginate(5);
            //     break;
            case 'price':
                $orders = Order::where('user_id', $user_id)->orderBy('price', 'asc')
                    ->paginate(5);
                break;
            case 'quantity':
                $orders = Order::where('user_id', $user_id)->orderBy('quantity', 'asc')
                    ->paginate(5);
                break;
            default:
                $orders = Order::where('user_id', $user_id)->orderByDesc('created_at')->paginate(5);
        }
        return view('tickets.UserTicketOrder', compact('orders'));
    }

    public function OrganizerOrderDetails(Request $request)
    {
        $user_id = Auth::id();
        $orders = Order::where('organizer_id', $user_id)->with('event', 'user')->orderByDesc('created_at')->paginate(5);
        $sortBy = $request->query('sort_by');
        switch ($sortBy) {
            // case 'event_name':
            //     $orders = Order::where('organizer_id', $user_id)
            //         ->with(['event' => function ($query) {
            //             $query->orderBy('name', 'asc');
            //         }])
            //         ->with('user')
            //         // ->orderByDesc('created_at')
            //         ->paginate(5);
            //     break;
            // case 'customer_name':
            //     $orders = Order::where('organizer_id', $user_id)
            //         ->with(['user' => function ($query) {
            //             $query->orderBy('name', 'asc');
            //         }])
            //         ->with('event')
            //         // ->orderByDesc('created_at')
            //         ->paginate(5);
            //     break;
            case 'quantity':
                $orders = Order::where('organizer_id', $user_id)->orderBy('quantity', 'asc')->paginate(5);
                break;
            case 'price':
                $orders = Order::where('organizer_id', $user_id)->orderBy('price', 'asc')->paginate(5);
                break;
            default:
                $orders = Order::where('organizer_id', $user_id)->orderByDesc('created_at')->paginate(5);
        }
        $Totalsale = Order::where('organizer_id', $user_id)->sum('quantity');
        $Todaysale = Order::where('organizer_id', $user_id)->whereDate('created_at', Carbon::today())->sum('quantity');
        $Totalprice = Order::where('organizer_id', $user_id)->sum('total_price');
        $Todayprice = Order::where('organizer_id', $user_id)->whereDate('created_at', Carbon::today())->sum('total_price');
        return view('events.EventStatistic', compact('orders', 'Totalsale', 'Totalprice', 'Todaysale', 'Todayprice'));
    }

    public function TodaySales()                                          // Show today's sales page for organizer
    {
        $user_id = Auth::id();                                           // get current user's info

        $orders = Order::where('organizer_id', $user_id)->whereDate('created_at', Carbon::today())->with('event', 'user')->orderByDesc('created_at')->paginate(10);
        $Totalsale = Order::where('organizer_id', $user_id)->sum('quantity');
        $Todaysale = Order::where('organizer_id', $user_id)->whereDate('created_at', Carbon::today())->sum('quantity');
        $Totalprice = Order::where('organizer_id', $user_id)->sum('total_price');
        $Todayprice = Order::where('organizer_id', $user_id)->whereDate('created_at', Carbon::today())->sum('total_price');
        return view('events.Todaysale', compact('orders', 'Totalsale', 'Totalprice', 'Todaysale', 'Todayprice'));
    }

    public function PurchasedTicket($id)                                // Show purchased ticket of user
    {
        $user_id = Auth::id();                                          // get current user's info
        $orders = Order::where('id', $id)->first();
        // if the ticket is purchased by authorized user then it will show ticket
        $check = $orders->user_id == $user_id;
        if ($check) {
            $ticket = Order::where('id', $id)->with('event')->first();
            return view('tickets.PurchasedTicket', compact('ticket'));
        } else {
            abort(403, 'Unauthorized');
        }
    }
}
