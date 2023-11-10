<?php

namespace App\Http\Controllers;

use App\Models\ArtLibrary;
use App\Models\SubArtLibrary;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArtLibraryManagementController extends Controller {
    public function index() {
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:title_en,original,series,author,studio,year,lang,page,status,source,type,desc']
        ]);

        $query = ArtLibrary::query();

        if (request('search')) {
            $query
                ->where('title_en', 'LIKE', '%'.request('search').'%')
                ->orWhere('title_jp', 'LIKE', '%'.request('search').'%')
                ->orWhere('original', 'LIKE', '%'.request('search').'%')
                ->orWhere('series', 'LIKE', '%'.request('search').'%')
                ->orWhere('author', 'LIKE', '%'.request('search').'%')
                ->orWhere('studio', 'LIKE', '%'.request('search').'%')
                ->orWhere('year', 'LIKE', '%'.request('search').'%')
                ->orWhere('lang', 'LIKE', '%'.request('search').'%')
                ->orWhere('page', 'LIKE', '%'.request('search').'%')
                ->orWhere('status', 'LIKE', '%'.request('search').'%')
                ->orWhere('source', 'LIKE', '%'.request('search').'%')
                ->orWhere('type', 'LIKE', '%'.request('search').'%')
                ->orWhere('desc', 'LIKE', '%'.request('search').'%');
        }

        if (request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }

        return Inertia::render('Art/ArtLibraryManagement', [
            'AllArtLibrary' => $query->get(),
            'ArtLibrary' => $query->orderBy('created_at', 'desc')->paginate('10')->withQueryString(),
            'SubArtLibrary' => SubArtLibrary::all(),
            'filters' => request()->all(['search', 'field', 'direction']),
        ]);
    }

    public function dataProcess($request) {
        try {
            $attributes = $request->validate([
                'title_en' => 'required',
                'status' => 'required',
                'type' => 'required',
            ]);

            $nullableFields = [
                'id',
                'title_jp',
                'original',
                'series',
                'author',
                'studio',
                'year',
                'page',
                'lang',
                'source',
                'desc',
                'link',
                'path',
            ];

            foreach($nullableFields as $field) {
                if (!is_null($request->input($field))) {
                    $attributes = array_merge($attributes, [$field => $request->input($field)]);
                } else if (is_null($request->input($field)) && $field == 'page') {
                    $attributes = array_merge($attributes, [$field => 0]);
                } else if (is_null($request->input($field)) && $request->has('id')) {
                    $attributes = array_merge($attributes, [$field => 'N/A']);
                }
            }

            if ($request->file('image_path')) {
                $request->validate([
                    'image_path' => 'image|max:2048',
                ]);

                $image = $request->file('image_path');
                $extension = strtolower($image->getClientOriginalExtension());
                $image_name = md5(uniqid($image->getClientOriginalName(), true) . time()) . '.' . $extension;
                $attributes['image_path'] = $image_name;
                $image->move('./img/library', $image_name);
                return $attributes;
            } else if ($request->image_path) {
                return array_merge($attributes, ['image_path' => $request->input('image_path')]);
            }
            return $attributes;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function libraryCreate(Request $request) {
        try {
            $attributes = $this->dataProcess($request);

            $artLibrary = ArtLibrary::create($attributes);
            $subArtLibrary = new SubArtLibrary([
                'title' => $request->input('title_en') ?? 'N/A',
                'sub_desc' => $request->input('desc') ?? 'N/A',
                'link' => $request->input('link') ?? '#'
            ]);

            $artLibrary->subArtLibraries()->save($subArtLibrary);
            return back()->withInput();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function libraryUpdate(Request $request) {
        $attributes = $this->dataProcess($request);
        $artLibrary = ArtLibrary::findOrFail($attributes['id']);
        $image_path = public_path("img/library/{$artLibrary->image_path}");

        if (!str_contains($image_path ,'default.webp') && $attributes["image_path"] != $artLibrary->image_path) {
            unlink($image_path);
        }
        $artLibrary->update($attributes);

        $subArtLibrary = $artLibrary->subArtLibraries()->first();
        $subArtLibrary->update([
            'title' => $request->input('title_en') ?? 'N/A',
            'sub_desc' => $request->input('desc') ?? 'N/A',
            'link' => $request->input('link') ?? '#'
        ]);

        return back()->withInput();
    }

    public function libraryDelete(Request $request) {
        $artLibrary = ArtLibrary::findOrFail($request->id);
        $image_path = public_path("img/library/{$artLibrary->image_path}");
        if (!str_contains($image_path ,'default.webp')) {
            unlink($image_path);
        }
        SubArtLibrary::whereIn('id', SubArtLibrary::where('art_library_id', $request->id)->pluck('id')->toArray())->delete();
        ArtLibrary::destroy($artLibrary->id);
        return back();
    }

    public function librarySubCreate(Request $request) {
        $artLibrary = ArtLibrary::findOrFail($request->data0['id']);
        SubArtLibrary::whereIn('id', SubArtLibrary::where('art_library_id', $request->data0['id'])->pluck('id')->toArray())->delete();

        foreach ($request->all() as $key) {
            $subArtLibrary = new SubArtLibrary([
                'title' => $key['title'] ?? 'N/A',
                'sub_desc' => $key['sub_desc'] ?? 'N/A',
                'link' => $key['link'] ?? '#',
            ]);

            $artLibrary->subArtLibraries()->save($subArtLibrary);
        }
    }
}
