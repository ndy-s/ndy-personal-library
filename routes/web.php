<?php

use App\Http\Controllers\ArtLibraryController;
use App\Http\Controllers\ArtLibraryManagementController;
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

Route::get('art-library', [ArtLibraryController::class, 'index']);
Route::post('art-library', [ArtLibraryController::class, 'index']);
Route::get('art-library/detail-{artLibrary}', [ArtLibraryController::class, 'detail']);

Route::get('art-library-management', [ArtLibraryManagementController::class, 'index']);
Route::post('art-library-management-create', [ArtLibraryManagementController::class, 'libraryCreate']);
Route::post('art-library-management-update', [ArtLibraryManagementController::class, 'libraryUpdate']);
Route::delete('art-library-management-destroy', [ArtLibraryManagementController::class, 'libraryDelete']);
Route::post('art-library-management-subcreate', [ArtLibraryManagementController::class, 'librarySubCreate']);


