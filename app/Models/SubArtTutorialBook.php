<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubArtTutorialBook extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function artTutorialBook() {
        return $this->belongsTo(ArtTutorialBook::class);
    }
}
