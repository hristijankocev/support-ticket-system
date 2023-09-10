@php use Database\Factories\CategoryFactory;use Database\Factories\TicketFactory; @endphp
<div>
    <div class="container px-4 my-2 dark:bg-gray-700 rounded">
        <p class="block text-sm font-medium text-gray-700 dark:text-gray-300 py-2">Search & Filters</p>

        <label for="title">
            <input wire:model.live.debounce.250ms="search" wire:model.live.throttle.150ms type="text" class="form-input w-full
        mt-2 dark:bg-gray-800 dark:text-gray-100 rounded" placeholder="Search by title..." id="title">
        </label>
        <div class="mt-2">
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Filter by
                Status</label>
            <select wire:model.live.debounce.150ms="status" wire:model.live.throttle.150ms name="status" id="status"
                    class="form-select w-full dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded">
                <option value="">All</option>
                @foreach(TicketFactory::$statuses as $status)
                    <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <div class="mt-2">
            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Filter by
                category</label>
            <select wire:model.live.debounce.150ms="category" wire:model.live.throttle.150ms name="category"
                    id="category"
                    class="form-select w-full dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded">
                <option value="">All</option>
                @foreach(CategoryFactory::$categories as $key => $category)
                    <option value="{{ $key + 1 }}">{{ ucfirst($category) }}</option>
                @endforeach
            </select>
        </div>
        <div class="mt-2 pb-2">
            <label for="severity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Filter by
                severity</label>
            <select wire:model.live.debounce.150ms="severity" wire:model.live.throttle.150ms name="severity"
                    id="severity"
                    class="form-select w-full dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded">
                <option value="">All</option>
                @foreach(TicketFactory::$severities as $severity)
                    <option value="{{ $severity }}">{{ ucfirst($severity) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if ($tickets->count() > 0)
        <div>
            @foreach ($tickets as $ticket)
                <div class="bg-white dark:bg-gray-800 shadow p-4 rounded-lg mb-4">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ $ticket->title }}</h2>
                    <span class="@switch($ticket->severity)
                            @case('critical')
                                bg-red-500
                                @break
                            @case('major')
                                bg-orange-500
                                @break
                            @case('medium')
                                bg-yellow-500
                                @break
                            @case('low')
                                bg-green-500
                                @break
                        @endswitch text-white px-2 py-1 rounded-lg text-sm inline-block">
                        severity: {{ $ticket->severity }}
                    </span>
                    <span class="@switch($ticket->status)
                            @case('open')
                                bg-blue-500
                                @break
                            @case('in-progress')
                                bg-yellow-500
                                @break
                            @case('resolved')
                                bg-green-500
                                @break
                            @case('closed')
                                bg-gray-500
                                @break
                        @endswitch text-white px-2 py-1 rounded-lg text-sm inline-block">
                        status: {{ $ticket->status }}
                    </span>
                    <p class="text-gray-700 dark:text-gray-300 mb-4 mt-2">{{ Str::limit(strip_tags($ticket->body), 150)."..." }}</p>
                    <a href="{{ route('tickets.show', $ticket) }}" class="px-4 py-1 bg-blue-500 text-white rounded
                        hover:bg-blue-600 dark:bg-gray-400 dark:text-gray-900 dark:hover:bg-gray-300
                        transition-colors duration-300 ease-in-out">
                        View Details
                    </a>
                </div>
            @endforeach
        </div>
        {{ $tickets->links() }}
    @else
        <p class="text-gray-500 dark:text-gray-300">No tickets found.</p>
    @endif
</div>
