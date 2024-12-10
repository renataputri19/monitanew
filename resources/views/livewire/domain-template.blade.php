<div class="p-6 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-200 rounded-md shadow">


    <!-- Slider for Indicator Navigation -->
    {{-- part 1 --}}
    
    @if (count($indicators) > 1)
        <div class="p-6 border rounded-lg bg-gray-100 dark:bg-gray-800 mb-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100 text-center">Pilih Indikator dari Aspek {{ $selectedCategory }}</h1>
            <div class="mt-6 mb-6 flex overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 dark:scrollbar-thumb-gray-700 dark:scrollbar-track-gray-800 gap-4 border border-gray-300 dark:border-gray-600 rounded-md p-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                @foreach ($indicators as $index => $indicator)
                    <button wire:click="selectIndicator({{ $index }})"
                        class="flex-shrink-0 px-4 py-2 rounded-md text-sm transition text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600
                        {{ $currentIndicator['id'] === $indicator['id'] ? 'bg-gray-200  dark:bg-gray-800' : 'bg-blue-500' }}">
                        {{ $indicator['indikator'] }}
                    </button>
                @endforeach
            </div>
        </div>
    @endif
    

    

    <!-- Current Indicator Title -->
    {{-- part 2 --}}

    <!-- Tingkat Section -->
    <div class="p-6 border rounded-lg bg-gray-100 dark:bg-gray-800 mb-6 mt-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">
            Indikator: {{ $currentIndicator['indikator'] ?? 'Select an Indicator' }}
        </h1>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6 mb-6">
            <!-- Update Tingkat Section -->
            <div class="p-6 bg-white dark:bg-gray-700 rounded-xl shadow-lg transition hover:shadow-2xl">
                <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">Pilih Tingkat</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                    Click on the desired level to update the "Tingkat" automatically.
                </p>
                <div class="flex items-center gap-2 flex-wrap mb-4">
                    @foreach (range(1, 5) as $level)
                        <button
                            wire:click="saveTingkat({{ $level }})"
                            class="px-4 py-2 rounded-md text-sm transition w-12 text-center text-gray-800 dark:text-gray-200
                            {{ $tingkat == $level ? 'bg-gray-400 dark:bg-gray-900 hover:bg-gray-400 dark:hover:bg-gray-700' : 'bg-gray-100 dark:bg-gray-600 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                            {{ $level }}
                        </button>
                    @endforeach
                </div>
                @if (session()->has('message'))
                    <p class="mt-6 text-sm text-green-500">{{ session('message') }}</p>
                @endif
            </div>
            
        
            <!-- Upload Files Section -->
            <div class="p-6 bg-white dark:bg-gray-700 rounded-xl shadow-lg transition hover:shadow-2xl">
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
                            class="block w-full p-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
            
                    <!-- Upload Button Column -->
                    <div class="flex items-end">
                        <button type="button" wire:click="saveFiles"
                            class="w-full px-6 py-2 bg-green-500 text-gray-800 dark:text-gray-200 rounded-md hover:bg-green-600 focus:ring-2 focus:ring-green-300 bg-gray-300  dark:bg-gray-900  hover:bg-gray-300 dark:hover:bg-gray-600">
                            Upload Files
                        </button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    
    

    <!-- Domain Details -->
    {{-- part 3 --}}
    <div class="p-6 border rounded-lg bg-gray-100 dark:bg-gray-800 mb-6 mt-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Penilaian</h1>

        @if ($currentIndicator)
            <div class="p-6 bg-white dark:bg-gray-700 rounded-xl shadow-lg transition hover:shadow-2xl mt-6 mb-6">
                <!-- Header with Domain Name and Status -->
                <div class="flex items-center justify-between border-b border-gray-300 dark:border-gray-600 pb-4 mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $currentIndicator['indikator'] }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $currentIndicator['disetujui'] ? 'Approved' : 'Pending' }}
                            <span class="{{ $currentIndicator['disetujui'] ? 'text-green-500' : 'text-yellow-500' }} font-medium">
                                • {{ $currentIndicator['disetujui'] ? '✔ Approved' : '⚠ Pending' }}
                            </span>
                        </p>
                    </div>
                    <button class="px-3 py-1 bg-gray-200 dark:bg-gray-600 text-sm rounded-full">
                        ID: {{ $currentIndicator['id'] }}
                    </button>
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
                                        class="px-3 py-1 rounded-md text-sm transition w-12 text-center text-gray-800 dark:text-gray-200
                                        {{ $currentIndicator['tingkat_tpb'] == $tingkat ? 'bg-gray-400 dark:bg-gray-900 hover:bg-gray-400 dark:hover:bg-gray-700' : 'bg-gray-100 dark:bg-gray-600 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                                        {{ $tingkat }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Provide Reason -->
                        <div class="flex items-end">
                            <button
                                onclick="openReasonModal('domain', {{ $currentIndicator['id'] }}, '{{ $currentIndicator['reasons'] }}', {{ $currentIndicator['disetujui'] }})"
                                class="px-3 py-1 bg-green-500 text-gray-800 dark:text-gray-200 rounded-md hover:bg-green-600 focus:ring-2 focus:ring-green-300 bg-gray-300  dark:bg-gray-900  hover:bg-gray-300 dark:hover:bg-gray-600">
                                Provide Reason
                            </button>
                        </div>
                        
                    </div>
                @endif
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400">No indicator selected.</p>
        @endif
    </div>






    <!-- Enhanced Files Table -->
    {{-- part 4 --}}
    <div class="p-6 border rounded-lg bg-gray-100 dark:bg-gray-800 mb-6 mt-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Files</h1>
        <div class="overflow-x-auto">
            @if ($currentIndicator)
                <table class="table-auto w-full border-collapse border border-gray-300 dark:border-gray-700 mt-6 mb-6">
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
                                            class="block px-3 py-2 bg-yellow-500 text-gray-800 dark:text-gray-300 rounded-md cursor-pointer text-center bg-gray-300  dark:bg-gray-700  hover:bg-gray-300 dark:hover:bg-gray-800">
                                            Update
                                        </label>
                                        <input type="file" id="update-file-{{ $file->id }}"
                                            wire:model="updatedFiles.{{ $file->id }}" class="hidden">
                                        @if (isset($updatedFiles[$file->id]))
                                            <button wire:click="updateFile({{ $file->id }})"
                                                class="block w-full px-3 py-2 bg-green-500 text-gray-800 dark:text-gray-300 rounded-md bg-gray-300  dark:bg-gray-700  hover:bg-gray-300 dark:hover:bg-gray-800">
                                                Save
                                            </button>
                                        @endif

                                        <!-- Delete File Button -->
                                        <button onclick="confirmDelete({{ $file->id }})"
                                            class="block w-full px-3 py-2 bg-red-500 text-gray-800 dark:text-gray-300 rounded-md bg-gray-300  dark:bg-gray-700  hover:bg-gray-300 dark:hover:bg-gray-800">
                                            Delete
                                        </button>

                                        <!-- Provide Reason Button -->
                                        @if ($isAdmin)
                                            <button
                                                onclick="openReasonModal('file', {{ $file->id }}, '{{ $file->reasons }}', {{ $file->hasil }})"
                                                class="block w-full px-3 py-2 bg-blue-500 text-gray-800 dark:text-gray-300 rounded-md bg-gray-300  dark:bg-gray-700  hover:bg-gray-300 dark:hover:bg-gray-800">
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
    </div>


    <div class="p-6 border rounded-lg bg-gray-100 dark:bg-gray-800 mb-6 mt-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Files</h1>
        <div class="overflow-x-auto">
            @if ($currentIndicator)
                <table class="table-auto w-full border-collapse border border-gray-300 dark:border-gray-700 mt-6 mb-6">
                    <thead class="bg-gray-200 dark:bg-gray-800">
                        <tr>
                            <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-900 dark:text-gray-100">
                                File
                            </th>
                            <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-900 dark:text-gray-100">
                                Status
                            </th>
                            <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-900 dark:text-gray-100">
                                Reason
                            </th>
                            <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-900 dark:text-gray-100">
                                Actions
                            </th>
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
                                    <a href="{{ asset('storage/' . $file->file_path) }}" class="text-blue-500 hover:underline">
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
                                    <div class="relative">
                                        <button class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-300 px-3 py-2 rounded-md hover:bg-gray-400 dark:hover:bg-gray-600 focus:outline-none"
                                            onclick="toggleDropdown({{ $file->id }})">
                                            Actions
                                        </button>
                                        <div id="dropdown-{{ $file->id }}" class="hidden absolute bg-white dark:bg-gray-800 rounded-lg shadow-lg mt-2 right-0 z-50">
                                            <ul class="text-sm text-gray-800 dark:text-gray-300">
                                                <!-- Update File Option -->
                                                <li class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    <label for="update-file-{{ $file->id }}" class="cursor-pointer">Update File</label>
                                                    <input type="file" id="update-file-{{ $file->id }}" 
                                                           wire:model="updatedFiles.{{ $file->id }}" 
                                                           class="hidden">
                                                </li>
                                                
                                                
                                                {{-- <li class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    <button onclick="confirmDelete({{ $file->id }})" class="text-red-500 dark:text-red-400">
                                                        Delete
                                                    </button>
                                                </li> --}}

    
                                                <!-- Delete File Option -->
                                                <li class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    <button onclick="confirmDelete({{ $file->id }})" class="text-red-500 dark:text-red-400">
                                                        Delete
                                                    </button>
                                                </li>
    
                                                <!-- Provide Reason Option -->
                                                @if ($isAdmin)
                                                    <li class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                        <button onclick="openReasonModal('file', {{ $file->id }}, '{{ $file->reasons }}', {{ $file->hasil }})"
                                                            class="text-blue-500 dark:text-blue-400">
                                                            Reason
                                                        </button>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
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
    </div>
    
    <script>
        function toggleDropdown(id) {
            const dropdown = document.getElementById(`dropdown-${id}`);
            dropdown.classList.toggle('hidden');
        }
    </script>
    




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
