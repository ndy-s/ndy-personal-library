<?php

namespace Database\Seeders;

use App\Models\ArtLibrary;
use Database\Factories\ArtLibraryFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArtLibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fact = new ArtLibraryFactory();
        $fact->count(1000)->create();
    }
}
