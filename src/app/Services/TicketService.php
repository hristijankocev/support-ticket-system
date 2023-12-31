<?php

namespace App\Services;

use App\Events\NewTicket;
use App\Events\TicketAssigned;
use App\Events\TicketStatus;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TicketService
{
    public function getAllTickets()
    {
        if (Gate::allows('admin')) {
            return Ticket::with(['category', 'author'])
                ->latest();
        }

        if (Gate::allows('agent')) {
            return Ticket::with(['category', 'author'])
                ->where('agent_id', '=', Auth::id())
                ->latest();
        }

        if (Gate::allows('client')) {
            return Ticket::with(['category', 'author'])
                ->where('user_id', '=', Auth::id())
                ->latest();
        }
        return [];
    }

    public function getTicket(Ticket $ticket)
    {
        if (!Gate::allows('view-ticket', $ticket)) {
            abort(403);
        }

        return $ticket;
    }

    public function storeTicket(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:4000',],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'severity' => ['required', 'severity']
        ]);

        # Set the logged-in user as the writer of the ticket
        $validated['user_id'] = Auth::id();

        $newTicket = Ticket::create($validated);

        // TODO: Emmit event
        event(new NewTicket(Auth::user(), $newTicket));

        return $newTicket;
    }

    public function updateTicket(Request $request, Ticket $ticket): void
    {
        if (Gate::allows('client') || Gate::allows('agent')) {
            $validated = $request->validate([
                'status' => ['required', 'status']
            ]);

            $oldStatus = $ticket->status;

            $ticket->update($validated);

            $this->notifyStatusUpdate($ticket, $request, $oldStatus);
            return;
        }

        if (Gate::allows('admin')) {
            $validated = $request->validate([
                'severity' => ['required', 'severity'],
                'status' => ['required', 'status']
            ]);

            if ($request->filled('agent_id')) {
                $validated['agent_id'] = $request->validate([
                    'agent_id' => ['integer', 'exists:users,id', 'agent']])['agent_id'];
            } else {
                $validated['agent_id'] = null;
            }

            $oldStatus = $ticket->status;

            $ticket->update($validated);

            $this->notifyStatusUpdate($ticket, $request, $oldStatus);

            if ((int)$validated['agent_id'] !== (int)$ticket->agent->id) {
                $this->notifyAgent($ticket, $request);
            }
        }
    }

    private function notifyStatusUpdate(Ticket $ticket, Request $request, string $oldStatus): void
    {
        $statusFromRequest = $request->input('status');
        if ($oldStatus !== $statusFromRequest) {
            event(new TicketStatus($ticket, Auth::user(), $oldStatus));
        }
    }

    private function notifyAgent(Ticket $ticket, Request $request): void
    {
        if ($request->filled('agent_id')) {
            event(new TicketAssigned($ticket, Auth::user()));
        }
    }
}
