<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;
use Livewire\WithPagination;

class TicketSearch extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $tickets = Ticket::query()
            ->where('title', 'like', '%' . $this->search . '%')
            ->paginate(10);

        // Reset to the first page. More on https://livewire.laravel.com/docs/pagination#resetting-the-page
        $this->resetPage();

        return view('components.livewire.ticket-search', ['tickets' => $tickets,
            'search' => $this->search]);
    }

}
