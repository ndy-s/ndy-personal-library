<?php

namespace App\Http\Controllers;

use App\Models\ArtCourse;
use App\Models\SubArtCourse;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ArtCourseController extends Controller
{
    public function index(\Illuminate\Http\Request $request) {
        $page = $request->query('page', 1);
        if ($request->isMethod('get') && $page != 1) {
            return redirect('art-course?page=1');
        }

        $query = ArtCourse::query()
            ->when(Request::input('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title_en', 'LIKE', "%{$search}%")
                        ->orWhere('original', 'LIKE', "%{$search}%")
                        ->orWhere('author', 'LIKE', "%{$search}%")
                        ->orWhere('year', 'LIKE', "%{$search}%")
                        ->orWhere('lang', 'LIKE', "%{$search}%")
                        ->orWhere('status', 'LIKE', "%{$search}%")
                        ->orWhere('source', 'LIKE', "%{$search}%")
                        ->orWhere('desc', 'LIKE', "%{$search}%");
                });
            })
            ->when(Request::input('type'), function ($query, $search) {
                $query->where('publisher', $search);
            })
            ->orderBy('title_en');

        $artCourses = $query->paginate(40);

        return Inertia::render('Art/ArtCourse', [
            'courseTotal' => $query->count(),
            'ArtLibrary' => $artCourses,
            'types' => ArtCourse::select('publisher')->distinct()->orderBy('publisher')->get(),
            'filters' => Request::only(['search']),
            'recent' => ArtCourse::orderBy('updated_at', 'desc')->limit(10)->get(),
        ]);
    }

    public function detail(ArtCourse $artCourse) {
        $availableArtCourses = ArtCourse::whereNotIn('id', [$artCourse->id])->get();
        $randomArtCourses = $availableArtCourses->count() >= 12
            ? $availableArtCourses->random(12)
            : $availableArtCourses;

        return Inertia::render('Art/ArtCourseDetail', [
            'AllArtLibrary' => $randomArtCourses,
            'ArtLibrary' => $artCourse,
            'SubArtLibrary' => SubArtCourse::where('art_course_id', $artCourse->id)->get(),
            'recent' => ArtCourse::orderBy('updated_at', 'desc')->limit(10)->get(),
        ]);
    }
}
