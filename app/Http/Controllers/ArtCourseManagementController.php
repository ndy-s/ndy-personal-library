<?php

namespace App\Http\Controllers;

use App\Models\ArtCourse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArtCourseManagementController extends Controller
{
    public function index() {
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:title_en,original,author,year,lang,status,source']
        ]);

        $query = ArtCourse::query();

        if (request('search')) {
            $query
                ->where('title_en', 'LIKE', '%'.request('search').'%')
                ->orWhere('original', 'LIKE', '%'.request('search').'%')
                ->orWhere('year', 'LIKE', '%'.request('search').'%')
                ->orWhere('lang', 'LIKE', '%'.request('search').'%')
                ->orWhere('status', 'LIKE', '%'.request('search').'%')
                ->orWhere('source', 'LIKE', '%'.request('search').'%')
                ->orWhere('author', 'LIKE', '%'.request('search').'%');
        }

        if (request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }

        return Inertia::render('Art/ArtCourseManagement', [
            'AllArtLibrary' => $query->get(),
            'ArtLibrary' => $query->orderBy('created_at', 'desc')->paginate('10')->withQueryString(),
            // 'SubArtLibrary' => SubArtLibrary::all(),
            'filters' => request()->all(['search', 'field', 'direction']),
        ]);
    }
}
