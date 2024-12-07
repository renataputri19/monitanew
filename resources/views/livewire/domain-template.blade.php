<div class="p-6 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 rounded-md shadow">
    <h1 class="text-2xl font-bold mb-4">Manage Files for {{ $selectedCategory }}</h1>


    <!-- Indicator Navigation -->
    <div class="mb-4 flex items-center gap-4">
        @foreach ($indicators as $index => $indicator)
            <button wire:click="selectIndicator({{ $index }})"
                class="px-4 py-2 rounded-md text-sm transition
                {{ $currentIndicator['id'] === $indicator['id'] ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600' }}">
                {{ $indicator['indikator'] }}
            </button>
        @endforeach
    </div>

    <!-- Tabs for Indicator Navigation -->
    <div class="mb-4 flex border-b border-gray-300 dark:border-gray-700">
        @foreach ($indicators as $index => $indicator)
            <button wire:click="selectIndicator({{ $index }})"
                class="px-4 py-2 transition border-b-4
                {{ $currentIndicator['id'] === $indicator['id'] ? 'border-blue-500 text-blue-500 font-bold' : 'border-transparent text-gray-800 dark:text-gray-100 hover:text-blue-500 hover:border-blue-500' }}">
                {{ $indicator['indikator'] }}
            </button>
        @endforeach
    </div>

    <!-- Slider for Indicator Navigation -->
    <div class="mb-4 flex overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 dark:scrollbar-thumb-gray-700 dark:scrollbar-track-gray-800 gap-4">
        @foreach ($indicators as $index => $indicator)
            <button wire:click="selectIndicator({{ $index }})"
                class="flex-shrink-0 px-4 py-2 rounded-md text-sm transition
                {{ $currentIndicator['id'] === $indicator['id'] ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600' }}">
                {{ $indicator['indikator'] }}
            </button>
        @endforeach
    </div>

<!-- Dropdown for Indicator Navigation -->
<div class="mb-4">
    <label for="indicatorDropdown" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        Select Indicator
    </label>
    <select id="indicatorDropdown" wire:model="currentIndicatorIndex"
        class="block w-full px-3 py-2 mt-2 border border-gray-300 rounded-md bg-white dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
        @foreach ($indicators as $index => $indicator)
            <option value="{{ $index }}">
                {{ $indicator['indikator'] }}
            </option>
        @endforeach
    </select>
</div>

<!-- Pagination for Indicator Navigation -->
<div class="mb-4 flex items-center justify-center gap-2">
    @foreach ($indicators as $index => $indicator)
        <button wire:click="selectIndicator({{ $index }})"
            class="px-3 py-2 rounded-md text-sm transition
            {{ $currentIndicator['id'] === $indicator['id'] ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600' }}">
            {{ $index + 1 }}
        </button>
    @endforeach
</div>

<!-- Vertical Navigation for Indicator Navigation -->
<div class="mb-4 flex flex-col items-start gap-2">
    @foreach ($indicators as $index => $indicator)
        <button wire:click="selectIndicator({{ $index }})"
            class="px-4 py-2 rounded-md text-sm transition w-full text-left
            {{ $currentIndicator['id'] === $indicator['id'] ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600' }}">
            {{ $indicator['indikator'] }}
        </button>
    @endforeach
</div>

<!-- Accordion Navigation -->
<div class="mb-4 space-y-2">
    @foreach ($indicators as $index => $indicator)
        <div>
            <button wire:click="selectIndicator({{ $index }})"
                class="w-full text-left px-4 py-2 rounded-md transition
                {{ $currentIndicator['id'] === $indicator['id'] ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600' }}">
                {{ $indicator['indikator'] }}
            </button>
            @if ($currentIndicator['id'] === $indicator['id'])
                <div class="mt-2 p-4 border-l-2 border-blue-500 bg-gray-100 dark:bg-gray-800">
                    <!-- Add content related to the selected indicator here -->
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        Details about {{ $indicator['indikator'] }}.
                    </p>
                </div>
            @endif
        </div>
    @endforeach
</div>


<!-- Card Navigation -->
<div class="mb-4 grid grid-cols-2 md:grid-cols-4 gap-4">
    @foreach ($indicators as $index => $indicator)
        <button wire:click="selectIndicator({{ $index }})"
            class="p-4 rounded-md shadow-md transition text-center
            {{ $currentIndicator['id'] === $indicator['id'] ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600' }}">
            {{ $indicator['indikator'] }}
        </button>
    @endforeach
</div>







    

    <!-- Current Indicator Title -->
    <h2 class="text-xl font-bold mb-6">
        {{ $currentIndicator['indikator'] ?? 'Select an Indicator' }}
    </h2>





    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Update Tingkat Section -->
        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg transition hover:shadow-2xl">
            <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">Update Tingkat</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                Click on the desired level to update the "Tingkat" automatically.
            </p>
            <div class="flex items-center gap-2 flex-wrap mb-4">
                @foreach (range(1, 5) as $level)
                    <button
                        wire:click="saveTingkat({{ $level }})"
                        class="px-4 py-2 rounded-md text-sm transition w-12 text-center
                        {{ $tingkat == $level ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600' }}">
                        {{ $level }}
                    </button>
                @endforeach
            </div>
            @if (session()->has('message'))
                <p class="mt-6 text-sm text-green-500">{{ session('message') }}</p>
            @endif
        </div>
        
    
        <!-- Upload Files Section -->
        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg transition hover:shadow-2xl">
            <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">Upload Files</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                Select files to upload. You can upload multiple files at once.
            </p>
            <div class="grid grid-cols-3 gap-4">
                <!-- Select Files Column -->
                <div class="col-span-2">
                    <label for="files" class="block text-sm font-medium mb-2 text-gray-800 dark:text-gray-200">
                        Select Files:
                    </label>
                    <input type="file" id="files" wire:model="uploadedFiles" multiple
                        class="block w-full p-2 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
        
                <!-- Upload Button Column -->
                <div class="flex items-end">
                    <button type="button" wire:click="saveFiles"
                        class="w-full px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:ring-2 focus:ring-green-300">
                        Upload Files
                    </button>
                </div>
            </div>
        </div>
        
    </div>
    
    

    <!-- Domain Details -->
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Domain Details</h2>

    @if ($currentIndicator)
        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg transition hover:shadow-2xl mb-6">
            <!-- Header with Domain Name and Status -->
            <div class="flex items-center justify-between border-b border-gray-300 dark:border-gray-700 pb-4 mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $currentIndicator['domain'] }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $currentIndicator['disetujui'] ? 'Approved' : 'Pending' }}
                        <span class="{{ $currentIndicator['disetujui'] ? 'text-green-500' : 'text-yellow-500' }} font-medium">
                            • {{ $currentIndicator['disetujui'] ? '✔ Approved' : '⚠ Pending' }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Domain Details -->
            <div class="mb-2">
                <div>
                    <span class="fs-6 text-gray-600 dark:text-gray-400 font-medium">Tingkat (User):</span>
                    <span class="fs-6 text-gray-800 dark:text-gray-100 font-medium">
                        {{ $currentIndicator['tingkat'] ?? 'N/A' }}
                    </span>
                </div>
                <div>
                    <span class="fs-6 text-gray-600 dark:text-gray-400 font-medium">Tingkat TPB (Admin):</span>
                    <span class="fs-6 text-gray-800 dark:text-gray-100 font-medium">
                        {{ $currentIndicator['tingkat_tpb'] ?? 'N/A' }}
                    </span>
                </div>
                <div>
                    <span class="fs-6 text-gray-600 dark:text-gray-400 font-medium">Reason:</span>
                    <span class="fs-6 text-gray-800 dark:text-gray-100 whitespace-normal font-medium">
                        {{ $currentIndicator['reasons'] ?? 'N/A' }}
                    </span>
                </div>
            </div>

            @if ($isAdmin)
                <!-- Admin Actions -->
                <div class="mt-2 flex flex-wrap items-center gap-4">
                    <!-- Update Tingkat TPB -->
                    <div class="flex items-center gap-2">
                        <label for="tingkat-tpb-{{ $currentIndicator['id'] }}"
                            class="block text-sm font-medium text-gray-800 dark:text-gray-200 mb-0">
                            Tingkat TPB:
                        </label>
                        <div class="flex items-center gap-2">
                            @foreach (range(1, 5) as $tingkat)
                                <button wire:click="updateTingkatTpb({{ $currentIndicator['id'] }}, {{ $tingkat }})"
                                    class="px-3 py-1 rounded-full text-sm transition
                                    {{ $currentIndicator['tingkat_tpb'] == $tingkat ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600' }}">
                                    {{ $tingkat }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Provide Reason -->
                    <button
                        onclick="openReasonModal('domain', {{ $currentIndicator['id'] }}, '{{ $currentIndicator['reasons'] }}', {{ $currentIndicator['disetujui'] }})"
                        class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 focus:ring-2 focus:ring-yellow-300 ml-auto">
                        Provide Reason
                    </button>
                </div>
            @endif
        </div>
    @else
        <p class="text-gray-500 dark:text-gray-400">No indicator selected.</p>
    @endif







    <!-- Enhanced Files Table -->
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Existing Files</h2>
    <div class="overflow-x-auto">
        @if ($currentIndicator)
            <table class="table-auto w-full border-collapse border border-gray-300 dark:border-gray-700">
                <thead class="bg-gray-200 dark:bg-gray-800">
                    <tr>
                        <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-900 dark:text-gray-100">
                            File</th>
                        <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-900 dark:text-gray-100">
                            Status</th>
                        <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-900 dark:text-gray-100">
                            Reason</th>
                        <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-900 dark:text-gray-100">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $files = \App\Models\File::where('domain_id', $currentIndicator['id'])->get();
                    @endphp
                    @foreach ($files as $file)
                        <tr class="bg-white dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <!-- File Column -->
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-800 dark:text-gray-300">
                                <a href="{{ asset('storage/' . $file->file_path) }}" class="text-blue-500">
                                    {{ $file->original_name }}
                                </a>
                            </td>

                            <!-- Status Column -->
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-800 dark:text-gray-300">
                                <span class="{{ $file->hasil ? 'text-green-500' : 'text-yellow-500' }}">
                                    {{ $file->hasil ? 'Approved' : 'Pending' }}
                                </span>
                            </td>

                            <!-- Reason Column -->
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-800 dark:text-gray-300">
                                {{ $file->reasons ?? 'N/A' }}
                            </td>

                            <!-- Actions Column -->
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                                <div class="space-y-2">
                                    <!-- Update File Button -->
                                    <label for="update-file-{{ $file->id }}"
                                        class="block px-3 py-2 bg-yellow-500 text-white rounded-md cursor-pointer text-center hover:bg-yellow-600">
                                        Update
                                    </label>
                                    <input type="file" id="update-file-{{ $file->id }}"
                                        wire:model="updatedFiles.{{ $file->id }}" class="hidden">
                                    @if (isset($updatedFiles[$file->id]))
                                        <button wire:click="updateFile({{ $file->id }})"
                                            class="block w-full px-3 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                                            Save
                                        </button>
                                    @endif

                                    <!-- Delete File Button -->
                                    <button onclick="confirmDelete({{ $file->id }})"
                                        class="block w-full px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                                        Delete
                                    </button>

                                    <!-- Provide Reason Button -->
                                    @if ($isAdmin)
                                        <button
                                            onclick="openReasonModal('file', {{ $file->id }}, '{{ $file->reasons }}', {{ $file->hasil }})"
                                            class="block w-full px-3 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                            Provide Reason
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500 dark:text-gray-400">No indicator selected or no files available.</p>
        @endif
    </div>




    <!-- Modal -->
    <div id="reasonModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
        <div class="bg-white dark:bg-gray-900 p-6 rounded-md shadow-lg w-1/3">
            <h3 id="modalTitle" class="text-lg font-bold mb-4">Provide Reason</h3>
            <textarea id="reasonTextarea"
                class="w-full p-2 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 rounded-md mb-4"></textarea>
            <div class="flex justify-end space-x-4">
                <button onclick="closeReasonModal()" class="px-4 py-2 bg-gray-500 text-white rounded-md">Cancel</button>
                <button onclick="saveReasonAndStatus(1)"
                    class="px-4 py-2 bg-green-500 text-white rounded-md">Approve</button>
                <button onclick="saveReasonAndStatus(0)"
                    class="px-4 py-2 bg-red-500 text-white rounded-md">Disapprove</button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
        <div class="bg-white dark:bg-gray-900 p-6 rounded-md shadow-lg w-1/3">
            <h3 class="text-lg font-bold mb-4 text-center">Are you sure you want to delete this file?</h3>
            <div class="flex justify-center space-x-4">
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-500 text-white rounded-md">
                    Cancel
                </button>
                <button onclick="confirmDeleteAction()" class="px-4 py-2 bg-red-500 text-white rounded-md">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <script>
        let modalType = null; // Either 'domain' or 'file'
        let modalId = null; // The ID of the domain or file
        let currentIndicatorTitle = "{{ $currentIndicator['indikator'] ?? 'N/A' }}";
    
        function openReasonModal(type, id, reason = '', status = null) {
            modalType = type;
            modalId = id;
    
            // Update modal title based on the type
            const titlePrefix = type === 'domain' ? 'Domain' : 'File';
            document.getElementById('modalTitle').textContent = `Provide Reason for ${titlePrefix}: ${currentIndicatorTitle}`;
    
            // Populate reason textarea
            document.getElementById('reasonTextarea').value = reason || '';
    
            // Show modal
            document.getElementById('reasonModal').classList.remove('hidden');
        }
    
        function closeReasonModal() {
            // Clear modal data
            modalType = null;
            modalId = null;
            document.getElementById('reasonTextarea').value = ''; // Clear reason
            document.getElementById('reasonModal').classList.add('hidden'); // Hide modal
        }
    
        function saveReasonAndStatus(status) {
            const reason = document.getElementById('reasonTextarea').value;
    
            // Call Livewire method based on modal type
            if (modalType === 'domain') {
                @this.call('saveDomainReasonAndStatus', modalId, reason, status);
            } else if (modalType === 'file') {
                @this.call('saveFileReasonAndStatus', modalId, reason, status);
            }
    
            // Close modal after action
            closeReasonModal();
        }
    
        let deleteFileId = null; // ID of the file to delete
    
        function confirmDelete(fileId) {
            deleteFileId = fileId;
            document.getElementById('deleteModal').classList.remove('hidden'); // Show delete confirmation modal
        }
    
        function closeDeleteModal() {
            deleteFileId = null;
            document.getElementById('deleteModal').classList.add('hidden'); // Hide delete confirmation modal
        }
    
        function confirmDeleteAction() {
            if (deleteFileId) {
                @this.call('deleteFile', deleteFileId);
            }
            closeDeleteModal(); // Close modal after delete
        }
    </script>
    
</div>
