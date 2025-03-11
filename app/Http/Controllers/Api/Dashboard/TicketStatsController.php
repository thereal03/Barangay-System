<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketStatsController extends Controller
{
    public function getStats(Request $request)
    {
        $serviceId = $request->get('service_id');
        $departmentsId = $request->get('departments_id');

        $query = Ticket::query();

        if ($serviceId) {
            $query->where('service_id', $serviceId);
        }

        if ($departmentsId) {
            $query->where('departments_id', $departmentsId);
        }

        $resolvedTickets = $query->whereHas('status', function ($query) {
            $query->where('name', 'resolved');
        })->count();

        $openTickets = $query->whereHas('status', function ($query) {
            $query->where('name', 'open');
        })->count();

        return response()->json([
            'resolved' => $resolvedTickets,
            'open' => $openTickets,
        ]);
    }
}