<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain',
        'aspek',
        'indikator',
        'files',
        'tingkat',
        'disetujui',
    ];

    protected $casts = [
        'files' => 'array', // Cast 'files' as an array
        'disetujui' => 'boolean', // Cast 'disetujui' as boolean
    ];

    public function files()
    {
        return $this->hasMany(File::class);
    }
}