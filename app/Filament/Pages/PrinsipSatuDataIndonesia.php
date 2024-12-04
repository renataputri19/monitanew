<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class PrinsipSatuDataIndonesia extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Pembinaan Statistik Sektoral';
    protected static ?string $navigationLabel = 'Prinsip Satu Data Indonesia';
    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.prinsip-satu-data-indonesia';
}
