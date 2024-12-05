<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Domain;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

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
    
        // Fetch the first domain in the selected category as a default
        $domain = Domain::where('aspek', $this->selectedCategory)->first();
    
        if ($domain) {
            $this->domainId = $domain->id;
            $this->tingkat = $domain->tingkat; // Set the current tingkat value
        }
    
        $this->criteria = Domain::where('aspek', $this->selectedCategory)->get();
        $this->isAdmin = auth()->user()->admin ?? false;
    }
    

    // Save "tingkat" independently
    public function saveTingkat()
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
        $domain->tingkat = $this->tingkat;
        $domain->save();
    
        session()->flash('message', 'Tingkat updated successfully!');
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
            $folderPath = "uploads/{$domain->domain}/{$domain->aspek}/{$domain->indikator}";

            foreach ($this->uploadedFiles as $file) {
                $fileName = $file->getClientOriginalName();
                $filePath = $file->storeAs($folderPath, $fileName, 'public');

                File::create([
                    'domain_id' => $domain->id,
                    'file_path' => $filePath,
                    'hasil' => false,
                    'reasons' => null,
                ]);
            }
        }

        $this->uploadedFiles = [];
        session()->flash('message', 'Files uploaded successfully!');
    }

    // Update file details
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
    
        // Generate the folder path based on domain structure
        $folderPath = "uploads/{$domain->domain}/{$domain->aspek}/{$domain->indikator}";
    
        // Store the new file in the correct folder
        $newFilePath = $this->updatedFiles[$fileId]->storeAs(
            $folderPath,
            $this->updatedFiles[$fileId]->getClientOriginalName(),
            'public'
        );
    
        // Update the file path in the database
        $file->file_path = $newFilePath;
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