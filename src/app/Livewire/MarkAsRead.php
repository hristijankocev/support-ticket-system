<?php

namespace App\Livewire;

use Livewire\Component;

class MarkAsRead extends Component
{
    public $notification;

    public function markAsRead()
    {
        if ($this->notification) {
            $this->notification->markAsRead();

            // Emit an event to notify that the notification has been marked as read
            $this->dispatch('notificationMarkedAsRead', $this->notification->id);
        }
    }

    public function render()
    {
        return view('components.livewire.mark-as-read');
    }
}
