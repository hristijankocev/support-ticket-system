@props(['categories'])

<x-layouts.app>
    <div class="container mx-auto px-6 pt-6">
        <h1 class="text-2xl font-semibold mb-4 dark:text-gray-400">Create a Ticket</h1>

        <form action="{{ route('tickets.store') }}" method="POST">
            @csrf

            {{-- Title --}}
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                <input type="text" name="title" id="title"
                       class="form-input mt-1 block w-full dark:bg-gray-800 dark:text-gray-200"
                       required>
            </div>

            {{-- Body --}}
            <div class="mb-4">
                <label for="body" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Body</label>
                <textarea name="body" id="body"
                          class="form-textarea mt-1 block w-full dark:bg-gray-800 dark:text-gray-200" rows="4"
                          required></textarea>
            </div>

            {{-- Category --}}
            <div class="mb-4">
                <label for="category"
                       class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                <select name="category_id" id="category"
                        class="form-select mt-1 block w-full dark:bg-gray-800 dark:text-gray-400">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Severity --}}
            <div class="mb-4">
                <label for="severity"
                       class="block text-sm font-medium text-gray-700 dark:text-gray-300">Severity</label>
                <select name="severity" id="severity"
                        class="form-select mt-1 block w-full dark:bg-gray-800 dark:text-gray-400">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="major">Major</option>
                    <option value="critical">Critical</option>
                </select>
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="px-4 py-1 bg-blue-500 text-white rounded
                        hover:bg-blue-600 dark:bg-gray-400 dark:text-gray-900 dark:hover:bg-gray-300
                        transition-colors duration-300 ease-in-out">
                    Create Ticket
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
