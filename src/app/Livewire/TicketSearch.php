<?php

namespace App\Livewire;

use App\Services\TicketService;
use Livewire\Component;
use Livewire\WithPagination;

class TicketSearch extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public string $category = '';
    public string $severity = '';

    public function render(TicketService $ticketService)
    {
        // Get all the tickets that the current user can view
        $allTickets = $ticketService->getAllTickets();

        $query = $allTickets->where('title', 'like', '%' . $this->search . '%');

        if (!empty($this->status)) {
            $query->where('status', $this->status);
        }

        if (!empty($this->category)) {
            $query->where('category_id', $this->category);
        }

        if (!empty($this->severity)) {
            $query->where('severity', $this->severity);
        }

        $tickets = $query->paginate(10);

        // Reset to the first page. More on https://livewire.laravel.com/docs/pagination#resetting-the-page
        $this->resetPage();

        return view('components.livewire.ticket-search', ['tickets' => $tickets]);
    }

}
