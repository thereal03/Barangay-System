<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketStatsController extends Controller
{
    public function getStats()
    {
        // Assuming the status is stored in a related table called 'ticket_statuses'
        $resolvedTickets = Ticket::whereHas('status', function ($query) {
            $query->where('name', 'resolved');
        })->count();

        $openTickets = Ticket::whereHas('status', function ($query) {
            $query->where('name', 'open');
        })->count();

        return response()->json([
            'resolved' => $resolvedTickets,
            'open' => $openTickets,
        ]);
    }
}