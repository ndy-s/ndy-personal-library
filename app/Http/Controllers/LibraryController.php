<?php

namespace App\Http\Controllers;
use App\Models\ArtLibrary;
use App\Models\SubArtLibrary;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class LibraryController extends Controller {
    public function index() {
        if (request()->query('page') && Request::method() === "GET") {
            return redirect()->to(url('/art/library'));
        }

        return Inertia::render('Art/Library', [
            'ArtLibrary' => ArtLibrary::query()
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where(function($q) use ($search) {
                        $q->where('title_en', 'like', "%{$search}%")
                            ->orWhere('title_jp', 'LIKE', "%{$search}%")
                            ->orWhere('original', 'LIKE', "%{$search}%")
                            ->orWhere('series', 'LIKE', "%{$search}%")
                            ->orWhere('author', 'LIKE', "%{$search}%")
                            ->orWhere('studio', 'LIKE', "%{$search}%")
                            ->orWhere('year', 'LIKE', "%{$search}%")
                            ->orWhere('lang', 'LIKE', "%{$search}%")
                            ->orWhere('page', 'LIKE', "%{$search}%")
                            ->orWhere('status', 'LIKE', "%{$search}%")
                            ->orWhere('desc', 'LIKE', "%{$search}%");
                    });
                })
                ->when(Request::input('type'), function ($query, $search) {
                    $query->where('type', $search);
                })
                ->orderBy('title_en')
                ->paginate(40),
            'types' => ArtLibrary::query()
                ->select('type')
                ->distinct()
                ->orderBy('type')
                ->get(),
            'filters' => Request::only(['search']),
            'recent' => ArtLibrary::query()
                ->orderBy('updated_at', 'desc')
                ->limit(10)
                ->get(),
        ]);
    }

    public function detail(ArtLibrary $artLibrary) {
        $availableArtLibraries = ArtLibrary::whereNotIn('id', [$artLibrary->id])->get();

        if ($availableArtLibraries->count() >= 12) {
            $randomArtLibraries = $availableArtLibraries->random(12);
        } else {
            $randomArtLibraries = $availableArtLibraries;
        }
        return Inertia::render('Art/LibraryDetail', [
            'AllArtLibrary' => $randomArtLibraries,
            'ArtLibrary' => $artLibrary,
            'SubArtLibrary' => SubArtLibrary::query()
                ->where('art_library_id', $artLibrary->id)
                ->get(),
        ]);
    }
}
