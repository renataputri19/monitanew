<div class="p-6 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 rounded-md shadow">
    <h1 class="text-2xl font-bold mb-4">Manage Files for {{ $selectedCategory }}</h1>

    <!-- Form to Update Tingkat -->
    <form wire:submit.prevent="saveTingkat" class="mb-8">
        <label for="tingkat" class="block text-sm font-medium mb-2">Tingkat:</label>
        <select id="tingkat" wire:model="tingkat" class="block w-full p-2 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 rounded-md">
            <option value="" disabled>Select Tingkat</option>
            <option value="1">Tingkat 1</option>
            <option value="2">Tingkat 2</option>
            <option value="3">Tingkat 3</option>
            <option value="4">Tingkat 4</option>
            <option value="5">Tingkat 5</option>
        </select>
        <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md">
            Update Tingkat
        </button>
    </form>

    <!-- Form to Upload Files -->
    <form wire:submit.prevent="saveFiles" class="mb-8">
        <label for="files" class="block text-sm font-medium mb-2">Upload Files:</label>
        <input type="file" id="files" wire:model="uploadedFiles" multiple class="block w-full p-2 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 rounded-md">
        <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md">
            Upload Files
        </button>
    </form>

    <!-- Domain Details -->
    <h2 class="text-xl font-bold mb-4">Domain Details</h2>
    @foreach ($criteria as $domain)
        <div class="p-4 mb-4 bg-gray-100 dark:bg-gray-700 rounded-md shadow">
            <p><strong>Domain:</strong> {{ $domain->domain }}</p>
            <p><strong>Tingkat:</strong> {{ $domain->tingkat ?? 'N/A' }}</p>
            <p><strong>Status:</strong> {{ $domain->disetujui ? 'Approved' : 'Pending' }}</p>
            <p><strong>Reason:</strong> {{ $domain->reasons ?? 'N/A' }}</p>
            
            @if ($isAdmin)
                <button onclick="openReasonModal('domain', {{ $domain->id }}, '{{ $domain->reasons }}', {{ $domain->disetujui }})" class="px-4 py-2 bg-yellow-500 text-white rounded-md">
                    Provide Reason
                </button>
            @endif
        </div>
    @endforeach

    <!-- Existing Files Table -->
    <h2 class="text-xl font-bold mb-4">Existing Files</h2>
    <table class="table-auto w-full border-collapse border border-gray-300 dark:border-gray-700">
        <thead class="bg-gray-200 dark:bg-gray-800">
            <tr>
                <th class="border border-gray-300 dark:border-gray-700 px-4 py-2">File</th>
                <th class="border border-gray-300 dark:border-gray-700 px-4 py-2">Status</th>
                <th class="border border-gray-300 dark:border-gray-700 px-4 py-2">Reason</th>
                <th class="border border-gray-300 dark:border-gray-700 px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($criteria as $domain)
                @php
                    $files = \App\Models\File::where('domain_id', $domain->id)->get();
                @endphp
                @foreach ($files as $file)
                    <tr class="bg-white dark:bg-gray-900">
                        <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                            <a href="{{ asset('storage/' . $file->file_path) }}" class="text-blue-500">
                                {{ basename($file->file_path) }}
                            </a>
                        </td>
                        <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                            {{ $file->hasil ? 'Approved' : 'Pending' }}
                        </td>
                        <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                            {{ $file->reasons ?? 'N/A' }}
                        </td>
                        <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 space-x-2">
                            <!-- Update File -->
                            <label for="update-file-{{ $file->id }}" class="px-2 py-1 bg-yellow-500 text-white rounded-md cursor-pointer">
                                Update
                            </label>
                            <input type="file" id="update-file-{{ $file->id }}" wire:model="updatedFiles.{{ $file->id }}" class="hidden">
                            @if (isset($updatedFiles[$file->id]))
                                <button wire:click="updateFile({{ $file->id }})" class="px-2 py-1 bg-green-500 text-white rounded-md">
                                    Save
                                </button>
                            @endif

                            <!-- Delete File -->
                            <button wire:click="deleteFile({{ $file->id }})" class="px-2 py-1 bg-red-500 text-white rounded-md">
                                Delete
                            </button>

                            <!-- Provide Reason -->
                            @if ($isAdmin)
                                <button onclick="openReasonModal('file', {{ $file->id }}, '{{ $file->reasons }}', {{ $file->hasil }})" class="px-2 py-1 bg-blue-500 text-white rounded-md">
                                    Provide Reason
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>


<!-- Modal -->
<div id="reasonModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
    <div class="bg-white dark:bg-gray-900 p-6 rounded-md shadow-lg w-1/3">
        <h3 id="modalTitle" class="text-lg font-bold mb-4">Provide Reason</h3>
        <textarea id="reasonTextarea" class="w-full p-2 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 rounded-md mb-4"></textarea>
        <div class="flex justify-end space-x-4">
            <button onclick="closeReasonModal()" class="px-4 py-2 bg-gray-500 text-white rounded-md">Cancel</button>
            <button onclick="saveReasonAndStatus(1)" class="px-4 py-2 bg-green-500 text-white rounded-md">Approve</button>
            <button onclick="saveReasonAndStatus(0)" class="px-4 py-2 bg-red-500 text-white rounded-md">Disapprove</button>
        </div>
    </div>
</div>

<script>
    let modalType = null;
    let modalId = null;

    function openReasonModal(type, id, reason = '', status = null) {
        modalType = type;
        modalId = id;
        document.getElementById('reasonTextarea').value = reason || ''; // Set the reason value
        document.getElementById('modalTitle').textContent = `Provide Reason for ${type === 'domain' ? 'Domain' : 'File'}`;
        document.getElementById('reasonModal').classList.remove('hidden');
    }

    function closeReasonModal() {
        modalType = null;
        modalId = null;
        document.getElementById('reasonTextarea').value = ''; // Clear the textarea explicitly
        document.getElementById('reasonModal').classList.add('hidden');
    }

    function saveReasonAndStatus(status) {
        const reason = document.getElementById('reasonTextarea').value;
        if (modalType === 'domain') {
            @this.call('saveDomainReasonAndStatus', modalId, reason, status);
        } else if (modalType === 'file') {
            @this.call('saveFileReasonAndStatus', modalId, reason, status);
        }
        closeReasonModal(); // Ensure the modal is closed and cleared
    }

</script>
