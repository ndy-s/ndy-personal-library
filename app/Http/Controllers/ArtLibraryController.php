<?php
namespace App\Http\Controllers;
use App\Models\ArtLibrary;
use App\Models\SubArtLibrary;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ArtLibraryController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $page = $request->query('page', 1);
        if ($request->isMethod('get') && $page != 1) {
            return redirect('art-library?page=1');
        }

        $query = ArtLibrary::query()
            ->when(Request::input('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title_en', 'LIKE', "%{$search}%")
                        ->orWhere('title_jp', 'LIKE', "%{$search}%")
                        ->orWhere('original', 'LIKE', "%{$search}%")
                        ->orWhere('series', 'LIKE', "%{$search}%")
                        ->orWhere('author', 'LIKE', "%{$search}%")
                        ->orWhere('studio', 'LIKE', "%{$search}%")
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

        $artLibraries = $query->paginate(40);

        return Inertia::render('Art/ArtLibrary', [
            'libraryTotal' => $query->count(),
            'ArtLibrary' => $artLibraries,
            'types' => ArtLibrary::select('type')->distinct()->orderBy('type')->get(),
            'filters' => Request::only(['search']),
            'recent' => ArtLibrary::orderBy('updated_at', 'desc')->limit(10)->get(),
        ]);
    }

    public function detail(ArtLibrary $artLibrary)
    {
        $availableArtLibraries = ArtLibrary::whereNotIn('id', [$artLibrary->id])->get();
        $randomArtLibraries = $availableArtLibraries->count() >= 12
            ? $availableArtLibraries->random(12)
            : $availableArtLibraries;

        return Inertia::render('Art/ArtLibraryDetail', [
            'AllArtLibrary' => $randomArtLibraries,
            'ArtLibrary' => $artLibrary,
            'SubArtLibrary' => SubArtLibrary::where('art_library_id', $artLibrary->id)->get(),
            'recent' => ArtLibrary::orderBy('updated_at', 'desc')->limit(10)->get(),
        ]);
    }
}
