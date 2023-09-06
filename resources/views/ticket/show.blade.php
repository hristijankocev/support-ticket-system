@php use Illuminate\Support\Facades\Auth; @endphp
@props(['ticket'])

<x-layouts.app>
    <div class="container mx-auto mt-8 px-4 dark:bg-gray-900">
        <div class="container bg-white dark:bg-gray-800 shadow p-4 rounded-lg">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-semibold dark:text-gray-100">{{ $ticket->title }}</h1>
                <div>
                    <span class="bg-blue-500 text-white px-2 py-1 rounded-lg text-sm inline-block">
                        category: {{ $ticket->category->name }}
                    </span>
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
                </div>
            </div>

            <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                Author:
                @if(Auth::id() === $ticket->author->id)
                    You
                @else
                    {{ $ticket->author->name }}
                @endif
            </div>

            <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                Agent: {{ $ticket->agent->name ?? 'not assigned' }}
            </div>

            <div class="text-gray-700 dark:text-gray-300 dark:bg-gray-700 rounded p-2">
                {!! nl2br(e($ticket->body)) !!}
            </div>

            {{-- Ticket Comments Section --}}
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Comments</h3>

                @if ($ticket->comments->count() > 0)
                    <ul>
                        @foreach ($ticket->comments as $comment)
                            <li class="text-gray-600 dark:text-gray-400">
                                <strong>{{ $comment->user->name }}:</strong>
                                {{ $comment->body }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 dark:text-gray-300">No comments yet.</p>
                @endif
            </div>

            <div class="mt-6">
                <a href="{{ route('tickets.index') }}" class="px-4 py-1 bg-blue-500 text-white rounded
                        hover:bg-blue-600 dark:bg-gray-400 dark:text-gray-900 dark:hover:bg-gray-300
                        transition-colors duration-300 ease-in-out">
                    Back to Tickets
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
