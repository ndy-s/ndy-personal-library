<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtCourse extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function subArtCourses() {
        return $this->hasMany(SubArtCourse::class);
    }
}
