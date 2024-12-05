<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class KualitasData extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Pembinaan Statistik Sektoral';
    protected static ?string $navigationLabel = ' Kualitas Data';
    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.kualitas-data';
}