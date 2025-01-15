<x-filament::page>
    <div class="space-y-6">
        <!-- Notifications Header -->
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Notifications</h2>
            <div class="flex space-x-4">
                <button
                    wire:click="markAllAsRead"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Mark All as Read
                </button>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <table class="table-auto w-full border-collapse border border-gray-300 dark:border-gray-600">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <th class="border border-gray-300 dark:border-gray-600 p-3 text-left">Message</th>
                        <th class="border border-gray-300 dark:border-gray-600 p-3 text-left">Created At</th>
                        <th class="border border-gray-300 dark:border-gray-600 p-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($notifications as $notification)
                        <tr class="{{ $notification->read_at ? 'bg-gray-100 dark:bg-gray-700' : 'bg-green-50 dark:bg-green-900' }}">
                            <td class="border border-gray-300 dark:border-gray-600 p-3">
                                {{ $notification->data['message'] ?? 'No message provided' }}
                            </td>
                            <td class="border border-gray-300 dark:border-gray-600 p-3">
                                {{ $notification->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="border border-gray-300 dark:border-gray-600 p-3">
                                <div class="flex space-x-2">
                                    @if (is_null($notification->read_at))
                                        <button
                                            wire:click="markAsRead('{{ $notification->id }}')"
                                            class="px-3 py-2 bg-green-500 text-white rounded-md hover:bg-green-600"
                                        >
                                            Mark as Read
                                        </button>
                                    @endif
                                    <button
                                        wire:click="deleteNotification('{{ $notification->id }}')"
                                        class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-gray-500 dark:text-gray-400 p-3">
                                No notifications available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</x-filament::page>
