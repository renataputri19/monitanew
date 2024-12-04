<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Kelembagaan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Pembinaan Statistik Sektoral';
    protected static ?string $navigationLabel = 'Kelembagaan';
    protected static ?int $navigationSort = 4;

    protected static string $view = 'filament.pages.kelembagaan';
}
