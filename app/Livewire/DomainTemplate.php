<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Domain;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DomainTemplate extends Component
{
    use WithFileUploads;

    public $domainId;
    public $tingkat;
    public $uploadedFiles = [];
    public $updatedFiles = [];
    public $selectedCategory;
    public $criteria;
    public $isAdmin;
    public $reason = [];
    public $domainReasons = [];
    public $hasil;
    public $modalType; // To track whether the modal is for domain or file
    public $modalId;   // To track the specific domain or file being updated
    public $tingkat_tpb = [];

    public $indicators = []; // To store all indicators for the current aspek
    public $currentIndicator = null; // To store the currently selected indicator
    public $currentIndicatorIndex = 0; // To track the index of the selected indicator




    public function saveDomainReasonAndStatus($domainId, $reason, $status)
    {
        $domain = Domain::find($domainId);
    
        if (!$domain) {
            session()->flash('message', 'Domain not found!');
            return;
        }
    
        $domain->reasons = $reason;
        $domain->disetujui = $status;
        $domain->save();
    
        // Reset modal properties
        $this->modalType = null;
        $this->modalId = null;
    
        session()->flash('message', $status ? 'Domain approved successfully!' : 'Domain disapproved successfully!');
    }
    
    
    
    public function saveFileReasonAndStatus($fileId, $reason, $status)
    {
        $file = File::find($fileId);
    
        if (!$file) {
            session()->flash('message', 'File not found!');
            return;
        }
    
        $file->reasons = $reason;
        $file->hasil = $status;
        $file->save();
    
        // Reset modal-related properties
        $this->modalType = null;
        $this->modalId = null;
    
        session()->flash('message', $status ? 'File approved successfully!' : 'File disapproved successfully!');
    }
    
    
    
    
    
    public function mount($selectedCategory)
    {
        $this->selectedCategory = $selectedCategory;
    
        // Fetch all domains in the selected category
        $this->criteria = Domain::where('aspek', $this->selectedCategory)->get();
    
        // Initialize domainId and tingkat only if there are domains
        if ($this->criteria->isNotEmpty()) {
            $this->domainId = $this->criteria->first()->id; // Initialize with the first domain
            $this->tingkat = $this->criteria->first()->tingkat; // Initialize tingkat
        }
    
        // Fetch all indicators for the selected aspek and explicitly convert to array
        $this->indicators = Domain::where('aspek', $this->selectedCategory)->get()->toArray();
    
        // Set the first indicator as the default
        if (!empty($this->indicators)) {
            $this->currentIndicator = $this->indicators[0];
        }
    
        // Check if the logged-in user is an admin
        $this->isAdmin = auth()->user()->admin ?? false;
    }
    
    

    public function selectIndicator($index)
    {
        if (isset($this->indicators[$index])) {
            $this->currentIndicatorIndex = $index;
            $this->currentIndicator = $this->indicators[$index];
        }
    }
    
    
    
    

    // Save "tingkat" independently
    public function saveTingkat($level)
    {
        // Ensure domainId is set
        if (!$this->domainId) {
            session()->flash('message', 'No domain selected!');
            return;
        }
    
        // Fetch the domain by ID
        $domain = Domain::find($this->domainId);
    
        if (!$domain) {
            session()->flash('message', 'Domain not found!');
            return;
        }
    
        // Update tingkat
        $domain->tingkat = $level;
        $domain->save();
    
        // Update the tingkat state to reflect the change in the UI
        $this->tingkat = $level;
    
        session()->flash('message', 'Tingkat updated successfully!');
    }
    

    public function updateTingkatTpb($domainId, $selectedTingkat)
    {
        $domain = Domain::find($domainId);
    
        if (!$domain) {
            session()->flash('message', 'Domain not found!');
            return;
        }
    
        // Update the tingkat_tpb value
        $domain->tingkat_tpb = $selectedTingkat;
        $domain->save();
    
        // Provide feedback to the admin
        session()->flash('message', 'Tingkat TPB updated to ' . $selectedTingkat . ' successfully!');
    }
    
    
    

    // Save uploaded files
    public function saveFiles()
    {
        $domains = Domain::where('aspek', $this->selectedCategory)->get();
    
        if ($domains->isEmpty()) {
            session()->flash('message', 'No domains found for the selected category!');
            return;
        }
    
        foreach ($domains as $domain) {
            // Sanitize folder paths by replacing spaces with underscores
            $folderPath = "uploads/" . 
                preg_replace('/\s+/', '_', $domain->domain) . "/" . 
                preg_replace('/\s+/', '_', $domain->aspek) . "/" . 
                preg_replace('/\s+/', '_', $domain->indikator);
    
            foreach ($this->uploadedFiles as $file) {
                $originalName = $file->getClientOriginalName();
                $randomName = uniqid() . '.' . $file->getClientOriginalExtension(); // Generate a random filename
    
                // Store the file with a random name
                $filePath = $file->storeAs($folderPath, $randomName, 'public');
    
                // Save file information in the database
                File::create([
                    'domain_id' => $domain->id,
                    'file_path' => $filePath,       // Path to the stored file
                    'original_name' => $originalName, // Store the original filename
                    'hasil' => false,              // Default approval status
                    'reasons' => null,             // No reasons initially
                ]);
            }
        }
    
        $this->uploadedFiles = [];
        session()->flash('message', 'Files uploaded successfully!');
    }
    

    // Update file details
    // Automatically trigger file update when a new file is selected
    public function updated($propertyName)
    {
        if (str_starts_with($propertyName, 'updatedFiles.')) {
            $fileId = explode('.', $propertyName)[1];
            $this->updateFile($fileId);
        }
    }

    public function updateFile($fileId)
    {
        $file = File::find($fileId);

        if (!$file) {
            session()->flash('message', 'File not found!');
            return;
        }

        if (!isset($this->updatedFiles[$fileId])) {
            session()->flash('message', 'No file selected for update!');
            return;
        }

        // Fetch the associated domain for folder structure
        $domain = Domain::find($file->domain_id);

        if (!$domain) {
            session()->flash('message', 'Domain not found!');
            return;
        }

        // Delete the old file from storage
        Storage::disk('public')->delete($file->file_path);

        // Sanitize folder path
        $folderPath = "uploads/" .
            preg_replace('/\s+/', '_', $domain->domain) . "/" .
            preg_replace('/\s+/', '_', $domain->aspek) . "/" .
            preg_replace('/\s+/', '_', $domain->indikator);

        // Generate a new random file name for storage
        $randomName = uniqid() . '.' . $this->updatedFiles[$fileId]->getClientOriginalExtension();

        // Store the new file in the correct folder
        $newFilePath = $this->updatedFiles[$fileId]->storeAs($folderPath, $randomName, 'public');

        // Update the file path and original name in the database
        $file->file_path = $newFilePath;
        $file->original_name = $this->updatedFiles[$fileId]->getClientOriginalName(); // Store the original name
        $file->save();

        // Clear the temporary file input
        unset($this->updatedFiles[$fileId]);

        session()->flash('message', 'File updated successfully!');
    }
    
    

    // Approve or disapprove a file
    public function updateHasil($fileId, $status)
    {
        $file = File::find($fileId);

        if (!$file) {
            session()->flash('message', 'File not found!');
            return;
        }

        $file->hasil = $status;
        $file->save();

        session()->flash('message', $status ? 'File approved successfully!' : 'File disapproved successfully!');
    }

    // Save reasons for files
    public function saveReason($fileId, $reason)
    {
        $file = File::find($fileId);
    
        if (!$file) {
            session()->flash('message', 'File not found!');
            return;
        }
    
        if (trim($reason) === '') {
            session()->flash('message', 'Reason cannot be empty!');
            return;
        }
    
        $file->reasons = $reason;
        $file->save();
    
        session()->flash('message', 'Reason updated successfully for the file!');
    }
    
    
    

    // Delete a file
    public function deleteFile($fileId)
    {
        $file = File::find($fileId);

        if (!$file) {
            session()->flash('message', 'File not found!');
            return;
        }

        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        session()->flash('message', 'File deleted successfully!');
    }

    // Approve or disapprove a domain
    public function updateDomainApproval($domainId, $status)
    {
        $domain = Domain::find($domainId);

        if (!$domain) {
            session()->flash('message', 'Domain not found!');
            return;
        }

        $domain->disetujui = $status;
        $domain->save();

        session()->flash('message', $status ? 'Domain approved successfully!' : 'Domain disapproved successfully!');
    }

    // Save reasons for domains
    public function saveDomainReason($domainId, $reason)
    {
        $domain = Domain::find($domainId);
    
        if (!$domain) {
            session()->flash('message', 'Domain not found!');
            return;
        }
    
        $domain->reasons = $reason;
        $domain->save();
    
        session()->flash('message', 'Reason updated successfully!');
    }

    // Delete a domain
    public function deleteDomain($domainId)
    {
        $domain = Domain::find($domainId);

        if (!$domain) {
            session()->flash('message', 'Domain not found!');
            return;
        }

        $domain->delete();
        session()->flash('message', 'Domain deleted successfully!');
    }

    public function render()
    {
        return view('livewire.domain-template', ['criteria' => $this->criteria]);
    }
}