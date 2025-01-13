<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Domain;


class Nilai extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.nilai';

    protected static ?string $navigationGroup = 'Dashboard'; // Group under "Dashboard"
    protected static ?string $navigationLabel = 'Nilai'; // Set the navigation label

    // Correctly override the getTitle method
    public function getTitle(): string
    {
        return 'Dashboard Nilai EPSS';
    }


    public array $domains = [];
    
    public function mount()
    {
        $this->domains = Domain::all()
            ->groupBy('domain')
            ->map(function ($groupedIndicators, $domain) {
                return [
                    'domain' => $domain,
                    'indicators' => $groupedIndicators->map(function ($indicator) {
                        return [
                            'name' => $indicator->indikator,
                            'value' => $indicator->disetujui == 1 && $indicator->tingkat_tpb !== null ? $indicator->tingkat_tpb : 1,
                        ];
                    })->toArray(),
                ];
            })
            ->values()
            ->toArray();
    }
    
    
    

    public function getViewData(): array
    {
        return [
            'domains' => $this->domains,
        ];
    }
}
