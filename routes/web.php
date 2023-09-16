<?php

use App\Http\Controllers\LibraryController;
use App\Http\Controllers\SettingsController;
use App\Models\ArtLibrary;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', fn () => Inertia::render('Home'));

Route::get('/art', function () {
    return Inertia::render('Art/Art');
});

Route::get('/art/library', [LibraryController::class, 'index']);
Route::post('/art/library', [LibraryController::class, 'index']);

Route::get('/art/library/librarydetail-{artLibrary}', [LibraryController::class, 'detail']);

//Route::get('/settings', function () {
//    return Inertia::render('Settings');
//});

Route::get('art/libraryconfiguration', [SettingsController::class, 'index']);
Route::post('art/libraryconfiguration-library-create', [SettingsController::class, 'libraryCreate']);
Route::post('art/libraryconfiguration-library-update', [SettingsController::class, 'libraryUpdate']);
Route::delete('art/libraryconfiguration-library-destroy', [SettingsController::class, 'libraryDelete']);

Route::post('art/libraryconfiguration-library-subcreate', [SettingsController::class, 'librarySubCreate']);
Route::post('art/libraryconfiguration-library-relatedcreate', [SettingsController::class, 'libraryRelatedCreate']);


