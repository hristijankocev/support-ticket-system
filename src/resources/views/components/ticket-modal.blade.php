@props(['agents', 'ticket'])
<div class="flex justify-end">
    <!-- Button to open the modal -->
    <button data-modal-target="defaultModal" data-modal-toggle="defaultModal"
            class="pb-1"
            type="button">
        <i class="fa-solid fa-pen-to-square fa-lg dark:text-white"></i>
    </button>

    <!-- Main modal -->
    <div id="defaultModal" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Edit ticket
                    </h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="defaultModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form action="{{ route('tickets.update', $ticket) }}" method="POST" class="text-base leading-relaxed
                     text-gray-500 dark:text-gray-400" id="ticket-modal">
                        @csrf
                        @method('PUT')

                        <!-- Ticket status -->
                        <div class="mb-4">
                            <label for="status"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <select name="status" id="status" class="form-select w-full dark:bg-gray-800" required>
                                <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                                <option value="in-progress" {{ $ticket->status === 'in-progress' ? 'selected' : '' }}>In
                                    progress
                                </option>
                                <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Resolved
                                <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed
                                </option>
                            </select>
                        </div>

                        @admin
                        <!-- Ticket severity -->
                        <div class="mb-4">
                            <label for="severity"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-300">Severity</label>
                            <select name="severity" id="severity" class="form-select w-full dark:bg-gray-800" required>
                                <option value="low" {{ $ticket->severity === 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ $ticket->severity === 'medium' ? 'selected' : '' }}>Medium
                                </option>
                                <option value="major" {{ $ticket->severity === 'major' ? 'selected' : '' }}>Major
                                </option>
                                <option value="critical" {{ $ticket->severity === 'critical' ? 'selected' : '' }}>Critical
                                </option>
                            </select>
                        </div>

                        <!-- Ticket agent -->
                        <div class="mb-4">
                            <label for="agent" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Assign
                                to
                                Agent</label>
                            <select name="agent_id" id="agent" class="form-select w-full dark:bg-gray-800">
                                <option value="" {{ $ticket->agent_id === null ? 'selected' : '' }}>No Agent Assigned
                                </option>
                                @foreach ($agents as $agent)
                                    <option
                                        value="{{ $agent->id }}" {{ $ticket->agent_id === $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endadmin
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="defaultModal" type="submit" form="ticket-modal"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
