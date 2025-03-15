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
        $departmentId = $request->get('department_id');

        $query = Ticket::query();

        if ($serviceId) {
            $query->where('service_id', $serviceId);
        }

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        // Fetch resolved tickets grouped by service
        $resolvedTicketsByService = (clone $query)->where('status_id', 3) // Assuming 3 is the status_id for resolved
            ->select('service_id', \DB::raw('count(*) as count'))
            ->groupBy('service_id')
            ->with('service:id,name') // Assuming you have a relationship defined in the Ticket model
            ->get()
            ->map(function ($ticket) {
                return [
                    'name' => $ticket->service->name,
                    'count' => $ticket->count,
                ];
            });

        // Fetch open tickets count
        $openTickets = (clone $query)->where('status_id', 1) // Assuming 1 is the status_id for open
            ->count();

        return response()->json([
            'resolvedByService' => $resolvedTicketsByService,
            'open' => $openTickets,
        ]);
    }
    public function getPriorityStats(Request $request)
    {
        $priorityStats = Ticket::select('priority_id', \DB::raw('count(*) as count'))
            ->groupBy('priority_id')
            ->with('priority:id,name') // Assuming you have a relationship defined in the Ticket model
            ->get()
            ->map(function ($ticket) {
                return [
                    'priority' => $ticket->priority ? $ticket->priority->name : 'Unknown',
                    'count' => $ticket->count,
                ];
            });

        return response()->json($priorityStats);
    }
}