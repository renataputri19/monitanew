<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain_id',
        'file_path',
        'hasil',
        'reasons',
    ];

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
}
