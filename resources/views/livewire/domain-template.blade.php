<div class="p-6 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 rounded-md shadow">
    <h1 class="text-2xl font-bold mb-4">Manage Files for {{ $selectedCategory }}</h1>

    <!-- Form to Update Tingkat -->
    <form wire:submit.prevent="saveTingkat" class="mb-8">
        <label for="tingkat" class="block text-sm font-medium mb-2">Tingkat:</label>
        <select id="tingkat" wire:model="tingkat"
            class="block w-full p-2 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 rounded-md">
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
        <input type="file" id="files" wire:model="uploadedFiles" multiple
            class="block w-full p-2 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 rounded-md">
        <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md">
            Upload Files
        </button>
    </form>

    <!-- Domain Details -->
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Domain Details</h2>
    <div class="space-y-6">
        @foreach ($criteria as $domain)
            <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg transition hover:shadow-2xl mb-6">
                <!-- Header with Domain Name and Status -->
                <div class="flex items-center justify-between border-b border-gray-300 dark:border-gray-700 pb-4 mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $domain->domain }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $domain->disetujui ? 'Approved' : 'Pending' }}
                            <span class="{{ $domain->disetujui ? 'text-green-500' : 'text-yellow-500' }} font-medium">
                                • {{ $domain->disetujui ? '✔ Approved' : '⚠ Pending' }}
                            </span>
                        </p>
                    </div>
                </div>

                <!-- Domain Details -->
                <div class="mb-2">
                    <div>
                        <span class="fs-6 text-gray-600 dark:text-gray-400 font-medium">Tingkat (User):</span>
                        <span
                            class="fs-6 text-gray-800 dark:text-gray-100 font-medium">{{ $domain->tingkat ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="fs-6 text-gray-600 dark:text-gray-400 font-medium">Tingkat TPB (Admin):</span>
                        <span
                            class="fs-6 text-gray-800 dark:text-gray-100 font-medium">{{ $domain->tingkat_tpb ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="fs-6 text-gray-600 dark:text-gray-400 font-medium">Reason:</span>
                        <span class="fs-6 text-gray-800 dark:text-gray-100 whitespace-normal font-medium">
                            {{ $domain->reasons ?? 'N/A' }}
                        </span>
                    </div>
                </div>


                @if ($isAdmin)
                    <!-- Admin Actions -->
                    <div class="mt-2 flex flex-wrap items-center gap-4">
                        <!-- Update Tingkat TPB -->
                        <div class="flex items-center gap-2">
                            <label for="tingkat-tpb-{{ $domain->id }}"
                                class="block text-sm font-medium text-gray-800 dark:text-gray-200 mb-0">
                                Tingkat TPB:
                            </label>
                            <div class="flex items-center gap-2">
                                @foreach (range(1, 5) as $tingkat)
                                    <button wire:click="updateTingkatTpb({{ $domain->id }}, {{ $tingkat }})"
                                        class="px-3 py-1 rounded-full text-sm transition
                                    {{ $domain->tingkat_tpb == $tingkat ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600' }}">
                                        {{ $tingkat }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Provide Reason -->
                        <button
                            onclick="openReasonModal('domain', {{ $domain->id }}, '{{ $domain->reasons }}', {{ $domain->disetujui }})"
                            class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 focus:ring-2 focus:ring-yellow-300 ml-auto">
                            Provide Reason
                        </button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>





    <!-- Existing Files Table -->
    <!-- Enhanced Files Table -->
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Existing Files</h2>
    <div class="overflow-x-auto">
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
                @foreach ($criteria as $domain)
                    @php
                        $files = \App\Models\File::where('domain_id', $domain->id)->get();
                    @endphp
                    @foreach ($files as $file)
                        <tr class="bg-white dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <!-- File Column -->
                            <td
                                class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-800 dark:text-gray-300">
                                <a href="{{ asset('storage/' . $file->file_path) }}" class="text-blue-500">
                                    {{ $file->original_name }}
                                </a>

                            </td>

                            <!-- Status Column -->
                            <td
                                class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-800 dark:text-gray-300">
                                <span class="{{ $file->hasil ? 'text-green-500' : 'text-yellow-500' }}">
                                    {{ $file->hasil ? 'Approved' : 'Pending' }}
                                </span>
                            </td>

                            <!-- Reason Column -->
                            <td
                                class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-800 dark:text-gray-300">
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
                @endforeach
            </tbody>
        </table>
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
        let modalType = null;
        let modalId = null;

        function openReasonModal(type, id, reason = '', status = null) {
            modalType = type;
            modalId = id;
            document.getElementById('reasonTextarea').value = reason || ''; // Set the reason value
            document.getElementById('modalTitle').textContent =
                `Provide Reason for ${type === 'domain' ? 'Domain' : 'File'}`;
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

        let deleteFileId = null;

        function confirmDelete(fileId) {
            deleteFileId = fileId;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            deleteFileId = null;
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function confirmDeleteAction() {
            if (deleteFileId) {
                @this.call('deleteFile', deleteFileId);
            }
            closeDeleteModal();
        }
    </script>
</div>
