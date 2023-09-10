@php use App\Notifications\NotificationType; @endphp
<div class="bg-indigo-700 border border-indigo-400 dark:text-gray-200 px-4 py-3 rounded relative my-2"
     role="alert" data-id="{{ $notification->id }}">
    <span class="block">
        {{ '[' . $notification->created_at . ']' }}
        @if($notification->data['type'] === NotificationType::NewUser->name)
            User {{ $notification->data['name'] }} ({{ $notification->data['email'] }}) has registered.
        @endif
        @admin
        @if($notification->data['type'] === NotificationType::NewTicket->name)
            User {{ $notification->data['name'] }} ({{ $notification->data['email'] }}) create a new
            <a href="{{route('tickets.show', $notification->data['ticket_id'])}}" class="underline hover:text-gray-100">ticket.</a>
        @endif
        @endadmin
        @if($notification->data['type'] === NotificationType::NewComment->name)
            User {{ $notification->data['name'] }} ({{ $notification->data['email'] }}) made a
            <a href="{{route('tickets.show', $notification->data['ticket_id'])}}" class="underline hover:text-gray-100">new comment.</a>
        @endif
        @if($notification->data['type'] === NotificationType::TicketStatusUpdated->name)
            User {{ $notification->data['name'] }} ({{ $notification->data['email'] }}) updated
            <a href="{{route('tickets.show', $notification->data['ticket_id'])}}" class="underline hover:text-gray-100">ticket</a>
            status from '{{ $notification->data['old_status'] }}' to '{{ $notification->data['new_status'] }}'.
        @endif
    </span>
    <button wire:click="markAsRead"
            class="dark:text-gray-300 hover:text-gray-400 md:absolute relative top-0 right-0 mr-4 mt-3">
        Mark as read
    </button>
    <script>
        document.addEventListener('livewire:initialized', () => {
        @this.on('notificationMarkedAsRead', (notificationId) => {
            let notification = document.querySelector(`[data-id="${notificationId}"]`);
            notification.remove();
        });
        });
    </script>
</div>

