<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Events;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function ShowAllEvents(Request $request)
    {
        $id = Auth::id();
        $sortBy = $request->query('sort_by');
        
        // Default sorting if no option is selected
        $sortBy = $sortBy ?: 'name';
        $sortBy = $sortBy ?: 'venue';
        $sortBy = $sortBy ?: 'time';
        $sortBy = $sortBy ?: 'date';
        $sortBy = $sortBy ?: 'price';
        $sortBy = $sortBy ?: 'action';
        // $sortBy = $sortBy ?: 'date_asc';
        // $sortBy = $sortBy ?: 'alpha_asc';
        
        $events = Events::query();
        
        
        switch ($sortBy) {
            case 'name':
                $events->orderBy('name', 'asc');
                break;
            case 'venue':
                $events->orderBy('venue', 'asc');
                break;
            case 'time':
                $events->orderBy('time', 'asc');
                break;
            case 'date':
                $events->orderBy('date', 'asc');
                break;
            case 'price':
                $events->orderBy('price', 'asc');
                break;
            default:
                // Default sorting
                $events->orderBy('updated_at', 'desc');
        } 
        $events = $events->where('organizer_id',$id)->paginate(10);
        // $events = Events::where('organizer_id', $id)->orderByDesc('updated_at')->paginate(5);
        return view('events.MyEvent', compact('events'));
    }

    public function ShowCreateEventPage()                   //Show Create Event From
    {
        return view('events.CreateEvent');
    }

    public function createEvent(Request $request)        //Store Event Data to the Database
    {

        $request->validate([                              // Validate input field from the form
            'name' => 'required|min:3',
            'venue' => 'required|min:3',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',           // validate if the the event date is aftre the today or not 
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'about' => '',
            'image' => 'mimes:jpeg,png,jpg,gif,avif|max:10240',
        ]);
        // if the event has the image than it will store the image to the local folder in public/storage/event 
        if ($request->hasFile('image')) {
            $imagepath = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('event', $imagepath, 'public');
            $imagepath = 'event/' . $imagepath;
        } else {
            $imagepath = null;
        }

        $user = Auth::user();                                // get current user's data.

        // change the date formate acoording to the database folder
        $date = Carbon::createFromFormat('m/d/Y', $request['date'], 'UTC')->format('Y-m-d');
        $organizer_id = $user->id;

        Events::create([                                     // Store the data to database
            "name" => $request['name'],
            "venue" => $request['venue'],
            "date" => $date,
            "time" => $request['time'],
            "price" => $request['price'],
            "quantity" => $request['quantity'],
            "about" => $request['about'],
            "image" => $imagepath,
            'organizer_id' => $organizer_id,
        ]);
        return redirect()->route("event")->with('success', 'Event created successfully!');
    }


    public function ShowUpdateEventPage($id)        // Show Edit Event form
    {
        // find event data by event_id and get all data
        $event = Events::findOrFail($id);
        $date = $event->date;
        $time = $event->time;
        // Change the formate of the date and time for the display inthe input box 
        $newTime = Carbon::createFromFormat('H:i:s', $time)->format('H:i');
        $newDate = Carbon::createFromFormat('Y-m-d', $date)->format('m/d/Y');
        // show all info related event to the edit form
        return view('events.UpdateEvent', compact('event', 'newTime', 'newDate'));
    }


    public function UpdateEvent($id, Request $request)      // Update Event data
    {

        $request->validate([                                 // Validate the data from input field if the form
            'name' => 'required|min:3',
            'venue' => 'required|min:3',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'about' => '',
            'imageUpadte' => 'mimes:jpeg,png,jpg,gif,avif|max:10240',
        ]);
        // if we change the event image then it will update into database otherwise it will keep it as old image
        if ($request->hasFile('imageUpadte')) {
            $imagepath = $request->file('imageUpadte')->getClientOriginalName();
            $request->file('imageUpadte')->storeAs('event', $imagepath, 'public');
            $imagepath = 'event/' . $imagepath;
            Events::where('id', $id)->update([
                'image' => $imagepath,
            ]);
        }
        // Change the formate of the date from the input box according to the database formate.
        $date = Carbon::createFromFormat('m/d/Y', $request['date'])->format('Y-m-d');
        // Update the event data to database
        Events::where('id', $id)->update([
            "name" => $request['name'],
            "venue" => $request['venue'],
            "time" => $request['time'],
            "date" => $date,
            "price" => $request['price'],
            "quantity" => $request['quantity'],
            "about" => $request['about'],
        ]);
        return redirect()->route("event")->with('success', 'Event Updated successfully!');
    }


    public function deleteEvent($id)                            // Delete the event 
    {
        $Order = Order::where('event_id', $id)->first();
        // If the event is not sold out yet than we can delete that event otherwise we can not delete that event 
        if ($Order) {
            return redirect('event')->with('error', 'Someone Has Purchesed Your Ticket You Can not Deleted it now!!');
        } else {
            Events::where('id', $id)->delete();
            return redirect('event')->with('error', 'Event Deleted successfully!');
        }
    }
}
