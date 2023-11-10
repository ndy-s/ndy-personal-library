<?php

namespace App\Http\Controllers;

use App\Models\ArtTutorialBook;
use App\Models\SubArtTutorialBook;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArtTutorialBookManagementController extends Controller
{
    public function index() {
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:title_en,original,type,author,year,lang,status,page,source,desc']
        ]);

        $query = ArtTutorialBook::query();

        if (request('search')) {
            $query
                ->where('title_en', 'LIKE', '%'.request('search').'%')
                ->orWhere('original', 'LIKE', '%'.request('search').'%')
                ->orWhere('type', 'LIKE', '%'.request('search').'%')
                ->orWhere('author', 'LIKE', '%'.request('search').'%')
                ->orWhere('year', 'LIKE', '%'.request('search').'%')
                ->orWhere('lang', 'LIKE', '%'.request('search').'%')
                ->orWhere('page', 'LIKE', '%'.request('search').'%')
                ->orWhere('status', 'LIKE', '%'.request('search').'%')
                ->orWhere('source', 'LIKE', '%'.request('search').'%')
                ->orWhere('desc', 'LIKE', '%'.request('search').'%');
        }

        if (request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }

        return Inertia::render('Art/ArtTutorialBookManagement', [
            'AllArtLibrary' => $query->get(),
            'ArtLibrary' => $query->orderBy('created_at', 'desc')->paginate('10')->withQueryString(),
            'SubArtLibrary' => SubArtTutorialBook::all(),
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
                'original',
                'author',
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
                $image->move('./img/book', $image_name);
                return $attributes;
            } else if ($request->image_path) {
                return array_merge($attributes, ['image_path' => $request->input('image_path')]);
            }
            return $attributes;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function tutorialBookCreate(Request $request) {
        try {
            $attributes = $this->dataProcess($request);

            $artTutorialBook = ArtTutorialBook::create($attributes);
            $subArtTutorialBook = new SubArtTutorialBook([
                'title' => $request->input('title_en') ?? 'N/A',
                'sub_desc' => $request->input('desc') ?? 'N/A',
                'link' => $request->input('link') ?? '#'
            ]);

            $artTutorialBook->subArtTutorialBooks()->save($subArtTutorialBook);
            return back()->withInput();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function tutorialBookUpdate(Request $request) {
        $attributes = $this->dataProcess($request);
        $artTutorialBook = ArtTutorialBook::findOrFail($attributes['id']);
        $image_path = public_path("img/book/{$artTutorialBook->image_path}");

        if (!str_contains($image_path ,'default.webp') && $attributes["image_path"] != $artTutorialBook->image_path) {
            unlink($image_path);
        }
        $artTutorialBook->update($attributes);

        $subArtTutorialBook = $artTutorialBook->subArtTutorialBooks()->first();
        $subArtTutorialBook->update([
            'title' => $request->input('title_en') ?? 'N/A',
            'sub_desc' => $request->input('desc') ?? 'N/A',
            'link' => $request->input('link') ?? '#'
        ]);

        return back()->withInput();
    }

    public function tutorialBookDelete(Request $request) {
        $artTutorialBook = ArtTutorialBook::findOrFail($request->id);
        $image_path = public_path("img/book/{$artTutorialBook->image_path}");
        if (!str_contains($image_path ,'default.webp')) {
            unlink($image_path);
        }
        SubArtTutorialBook::whereIn('id', SubArtTutorialBook::where('art_tutorial_book_id', $request->id)->pluck('id')->toArray())->delete();
        ArtTutorialBook::destroy($artTutorialBook->id);
        return back();
    }

    public function tutorialBookSubCreate(Request $request) {
        $artTutorialBook = ArtTutorialBook::findOrFail($request->data0['id']);
        SubArtTutorialBook::whereIn('id', SubArtTutorialBook::where('art_tutorial_book_id', $request->data0['id'])->pluck('id')->toArray())->delete();

        foreach ($request->all() as $key) {
            $subArtLibrary = new SubArtTutorialBook([
                'title' => $key['title'] ?? 'N/A',
                'sub_desc' => $key['sub_desc'] ?? 'N/A',
                'link' => $key['link'] ?? '#',
            ]);

            $artTutorialBook->subArtTutorialBooks()->save($subArtLibrary);
        }
    }
}
