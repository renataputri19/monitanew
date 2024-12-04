<div>
    <h1 class="text-2xl font-bold">Manage Files for {{ $selectedCategory }}</h1>

    <form wire:submit.prevent="save" class="mt-4">
        <label for="files" class="block text-sm font-medium mt-4">Upload Files:</label>
        <input type="file" id="files" wire:model="uploadedFiles" multiple class="block w-full p-2 border border-gray-300 rounded-md">

        <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md">Upload</button>
    </form>

    @if (session()->has('message'))
        <div class="mt-4 text-green-500">{{ session('message') }}</div>
    @endif

    <h2 class="text-xl font-bold mt-8">Existing Files in {{ $selectedCategory }}</h2>
    <table class="table-auto border-collapse border border-gray-400 w-full mt-4">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2">File Path</th>
                <th class="border border-gray-300 px-4 py-2">Hasil</th>
                <th class="border border-gray-300 px-4 py-2">Reasons</th>
                <th class="border border-gray-300 px-4 py-2">Action</th>
                <th class="border border-gray-300 px-4 py-2">Last Updated</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($criteria as $domain)
                @php
                    $files = \App\Models\File::where('domain_id', $domain->id)->get(); // Fetch files for the domain
                @endphp
        
                @forelse ($files as $file)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">
                            <a href="{{ asset('storage/' . $file->file_path) }}" class="text-blue-500">
                                {{ basename($file->file_path) }}
                            </a>
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $file->hasil ? 'Approved' : 'Pending' }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">{{ $file->reasons ?? 'N/A' }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <button wire:click="deleteFile({{ $file->id }})" class="px-2 py-1 bg-red-500 text-white rounded-md">Delete</button>
                        </td>
                        <td class="border border-gray-300 px-4 py-2">{{ $file->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                            No files found for {{ $domain->domain }}
                        </td>
                    </tr>
                @endforelse
            @empty
                <tr>
                    <td colspan="5" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                        No domains found for the selected category.
                    </td>
                </tr>
            @endforelse
        </tbody>
        
        
    </table>
</div>
