<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function ShowAllTickets(Request $request)        // Show all the Ticket to user
    {
        // Sort Ticket based on the option
        $sortBy = $request->query('sort_by');
        $sortBy = $sortBy ?: 'date_asc';
        $tickets = Events::query();
        switch ($sortBy) {
            case 'date_asc':
                $tickets->orderBy('updated_at', 'desc');
                break;
            case 'date_desc':
                $tickets->orderBy('updated_at', 'asc');
                break;
            case 'price_asc':
                $tickets->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $tickets->orderBy('price', 'desc');
                break;
            default:
                // Default sorting
                $tickets->orderBy('updated_at', 'asc');
        }
        // Search ticket 
        $searchTerm = $request->query('search');
        if ($searchTerm) {
            $tickets->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('venue', 'like', '%' . $searchTerm . '%')
                ->orWhere('price', 'like', '%' . $searchTerm . '%');
        }
        // Show all data based on user filtration
        $tickets = $tickets->where('quantity', '>', 0)->whereDate('date', '>', Carbon::today())->paginate(10);
        return view('dashboard', ['tickets' => $tickets]);
    }


    // *** Currently pending
    public function TicketInfo($id)     // Show  specific ticket info
    {
        $ticket = Events::where('id', $id)->first();
        return view('tickets.TicketInfo', compact('ticket'));
    }

    public function UserTicketOrder()       // Show list user's purchased order. 
    {
        return view('tickets.UserTicketOrder');
    }
}
