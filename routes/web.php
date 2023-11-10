<?php

use App\Http\Controllers\ArtLibraryController;
use App\Http\Controllers\ArtLibraryManagementController;
use App\Http\Controllers\ArtCourseController;
use App\Http\Controllers\ArtCourseManagementController;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// Art Library
Route::get('art-library', [ArtLibraryController::class, 'index']);
Route::post('art-library', [ArtLibraryController::class, 'index']);
Route::get('art-library/detail-{artLibrary}', [ArtLibraryController::class, 'detail']);

Route::get('art-library-management', [ArtLibraryManagementController::class, 'index']);
Route::post('art-library-management-create', [ArtLibraryManagementController::class, 'libraryCreate']);
Route::post('art-library-management-update', [ArtLibraryManagementController::class, 'libraryUpdate']);
Route::delete('art-library-management-destroy', [ArtLibraryManagementController::class, 'libraryDelete']);
Route::post('art-library-management-subcreate', [ArtLibraryManagementController::class, 'librarySubCreate']);

// Art Course
Route::get('art-course', [ArtCourseController::class, 'index']);
Route::post('art-course', [ArtCourseController::class, 'index']);
Route::get('art-course/detail-{artCourse}', [ArtCourseController::class, 'detail']);

Route::get('art-course-management', [ArtCourseManagementController::class, 'index']);
Route::post('art-course-management-create', [ArtCourseManagementController::class, 'courseCreate']);
Route::post('art-course-management-update', [ArtCourseManagementController::class, 'courseUpdate']);
Route::delete('art-course-management-destroy', [ArtCourseManagementController::class, 'courseDelete']);
Route::post('art-course-management-subcreate', [ArtCourseManagementController::class, 'courseSubCreate']);

// Art Tutorial Book
Route::get('art-tutorial-book', [ArtTutorialBookController::class, 'index']);
Route::post('art-tutorial-book', [ArtTutorialBookController::class, 'index']);
Route::get('art-tutorial-book/detail-{artTutorialBook}', [ArtTutorialBookController::class, 'detail']);

Route::get('art-tutorial-book-management', [ArtTutorialBookManagementController::class, 'index']);
Route::post('art-tutorial-book-management-create', [ArtTutorialBookManagementController::class, 'tutorialBookCreate']);
Route::post('art-tutorial-book-management-update', [ArtTutorialBookManagementController::class, 'tutorialBookUpdate']);
Route::delete('art-tutorial-book-management-destroy', [ArtTutorialBookManagementController::class, 'tutorialBookDelete']);
Route::post('art-tutorial-book-management-subcreate', [ArtTutorialBookManagementController::class, 'tutorialBookSubCreate']);

