<?php

namespace App\Http\Controllers;

use App\Models\ArtCourse;
use App\Models\SubArtLibrary;
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
                        ->orWhere('year', 'LIKE', "%{$search}%")
                        ->orWhere('lang', 'LIKE', "%{$search}%")
                        ->orWhere('status', 'LIKE', "%{$search}%")
                        ->orWhere('source', 'LIKE', "%{$search}%")
                        ->orWhere('desc', 'LIKE', "%{$search}%");
                });
            })
            ->when(Request::input('author'), function ($query, $search) {
                $query->where('author', $search);
            })
            ->orderBy('title_en');

        $artCourses = $query->paginate(40);

        return Inertia::render('Art/ArtCourse', [
            'ArtLibrary' => $artCourses,
            'types' => ArtCourse::select('author')->distinct()->orderBy('author')->get(),
            'filters' => Request::only(['search']),
            'recent' => ArtCourse::orderBy('updated_at', 'desc')->limit(10)->get(),
        ]);
    }
}
