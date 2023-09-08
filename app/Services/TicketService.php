<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TicketService
{
    public function getTickets()
    {
        if (Gate::allows('admin')) {
            return Ticket::with(['category', 'author'])
                ->latest()
                ->filter(request(['search', 'category', 'author']))
                ->paginate(10)
                ->withQueryString();
        }

        if (Gate::allows('agent')) {
            return Ticket::with(['category', 'author'])
                ->where('agent_id', '=', Auth::id())
                ->latest()
                ->filter(request(['search', 'category', 'author']))
                ->paginate(10)
                ->withQueryString();
        }

        if (Gate::allows('client')) {
            return Ticket::with(['category', 'author'])
                ->where('user_id', '=', Auth::id())
                ->latest()
                ->filter(request(['search', 'category', 'author']))
                ->paginate(10)
                ->withQueryString();
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

    public function storeTicket(Request $request){
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:4000',],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'severity' => ['required', 'severity']
        ]);

        # Set the logged-in user as the writer of the ticket
        $validated['user_id'] = Auth::id();

        return Ticket::create($validated);
    }
}