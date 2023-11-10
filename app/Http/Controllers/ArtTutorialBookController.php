<?php

namespace App\Http\Controllers;

use App\Models\ArtTutorialBook;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ArtTutorialBookController extends Controller
{
    public function index(\Illuminate\Http\Request $request) {
        $page = $request->query('page', 1);
        if ($request->isMethod('get') && $page != 1) {
            return redirect('art-course?page=1');
        }

        $query = ArtTutorialBook::query()
            ->when(Request::input('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title_en', 'LIKE', "%{$search}%")
                        ->orWhere('original', 'LIKE', "%{$search}%")
                        ->orWhere('author', 'LIKE', "%{$search}%")
                        ->orWhere('year', 'LIKE', "%{$search}%")
                        ->orWhere('lang', 'LIKE', "%{$search}%")
                        ->orWhere('page', 'LIKE', "%{$search}%")
                        ->orWhere('status', 'LIKE', "%{$search}%")
                        ->orWhere('source', 'LIKE', "%{$search}%")
                        ->orWhere('desc', 'LIKE', "%{$search}%");
                });
            })
            ->when(Request::input('type'), function ($query, $search) {
                $query->where('type', $search);
            })
            ->orderBy('title_en');

        $artCourses = $query->paginate(40);

        return Inertia::render('Art/ArtTutorialBook', [
            'ArtLibrary' => $artCourses,
            'types' => ArtTutorialBook::select('type')->distinct()->orderBy('type')->get(),
            'filters' => Request::only(['search']),
            'recent' => ArtTutorialBook::orderBy('updated_at', 'desc')->limit(10)->get(),
        ]);
    }
}
