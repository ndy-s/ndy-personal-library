<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubArtCourse extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function artCourse() {
        return $this->belongsTo(ArtCourse::class);
    }
}
