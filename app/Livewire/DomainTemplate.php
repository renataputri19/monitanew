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
    public $uploadedFiles = [];
    public $tingkat;

    public $criteria;
    public $selectedCategory;

    public function mount($selectedCategory)
    {
        $this->selectedCategory = $selectedCategory;
        $this->criteria = Domain::where('aspek', $this->selectedCategory)->get();
    }

    public function save()
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
    
                // Save each file into the `files` table
                File::create([
                    'domain_id' => $domain->id,
                    'file_path' => $filePath,
                    'hasil' => false, // Default approval status
                    'reasons' => null, // No reasons initially
                ]);
            }
        }
    
        $this->uploadedFiles = [];
        $this->tingkat = null;
    
        $this->criteria = Domain::where('aspek', $this->selectedCategory)->get();
    
        session()->flash('message', 'Files uploaded successfully!');
    }
    
    
    

    public function render()
    {
        return view('livewire.domain-template', ['criteria' => $this->criteria]);
    }

    public function deleteFile($fileId)
    {
        $file = File::find($fileId);

        if ($file) {
            // Delete the physical file
            Storage::disk('public')->delete($file->file_path);

            // Delete the database record
            $file->delete();

            session()->flash('message', 'File deleted successfully!');
        } else {
            session()->flash('message', 'File not found!');
        }

        // Refresh the criteria
        $this->criteria = Domain::where('aspek', $this->selectedCategory)->get();
    }

}

