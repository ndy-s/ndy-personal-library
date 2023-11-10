<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtTutorialBook extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function subArtTutorialBooks() {
        return $this->hasMany(SubArtTutorialBook::class);
    }
}
