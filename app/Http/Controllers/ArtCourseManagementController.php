<?php

namespace App\Http\Controllers;

use App\Models\ArtCourse;
use App\Models\SubArtCourse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArtCourseManagementController extends Controller
{
    public function index() {
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:title_en,original,publisher,author,year,lang,status,source']
        ]);

        $query = ArtCourse::query();

        if (request('search')) {
            $query
                ->where('title_en', 'LIKE', '%'.request('search').'%')
                ->orWhere('original', 'LIKE', '%'.request('search').'%')
                ->orWhere('publisher', 'LIKE', '%'.request('search').'%')
                ->orWhere('author', 'LIKE', '%'.request('search').'%')
                ->orWhere('year', 'LIKE', '%'.request('search').'%')
                ->orWhere('lang', 'LIKE', '%'.request('search').'%')
                ->orWhere('status', 'LIKE', '%'.request('search').'%')
                ->orWhere('source', 'LIKE', '%'.request('search').'%');
        }

        if (request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }

        return Inertia::render('Art/ArtCourseManagement', [
            'AllArtLibrary' => $query->get(),
            'ArtLibrary' => $query
                ->orderBy('updated_at', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate('10')
                ->withQueryString(),
            'SubArtLibrary' => SubArtCourse::all(),
            'filters' => request()->all(['search', 'field', 'direction']),
        ]);
    }

    public function dataProcess($request) {
        try {
            $attributes = $request->validate([
                'title_en' => 'required',
                'status' => 'required',
            ]);

            $nullableFields = [
                'id',
                'original',
                'publisher',
                'author',
                'year',
                'video',
                'lang',
                'source',
                'desc',
                'link',
                'path',
            ];

            foreach($nullableFields as $field) {
                if (!is_null($request->input($field))) {
                    $attributes = array_merge($attributes, [$field => $request->input($field)]);
                } else if (is_null($request->input($field)) && $field == 'video') {
                    $attributes = array_merge($attributes, [$field => 0]);
                } else if (is_null($request->input($field)) && $request->has('id')) {
                    $attributes = array_merge($attributes, [$field => 'N/A']);
                }
            }

            $pathInput = $request->input('path');
            if (is_null($pathInput) || $pathInput === 'N/A') {
                $publisher = $request->input('publisher', 'N/A');
                $title_en = $request->input('title_en');
                $defaultPath = "D:\\Art & Animation\\Art & Animation Tutorial Courses\\$publisher\\$title_en";
                $attributes['path'] = $defaultPath;
            } else {
                $attributes['path'] = $pathInput;
            }

            if ($request->file('image_path')) {
                $request->validate([
                    'image_path' => 'image|max:2048',
                ]);

                $image = $request->file('image_path');
                $extension = strtolower($image->getClientOriginalExtension());
                $image_name = md5(uniqid($image->getClientOriginalName(), true) . time()) . '.' . $extension;
                $attributes['image_path'] = $image_name;
                $image->move('./img/course', $image_name);
                return $attributes;
            } else if ($request->image_path) {
                return array_merge($attributes, ['image_path' => $request->input('image_path')]);
            }
            return $attributes;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function courseCreate(Request $request) {
        try {
            $attributes = $this->dataProcess($request);
            ArtCourse::create($attributes);

            return back()->withInput();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function courseUpdate(Request $request) {
        $attributes = $this->dataProcess($request);
        $artCourse = ArtCourse::findOrFail($attributes['id']);
        $image_path = public_path("img/course/{$artCourse->image_path}");

        if (!str_contains($image_path ,'default.webp') && $attributes["image_path"] != $artCourse->image_path) {
            unlink($image_path);
        }
        $artCourse->update($attributes);

        return back()->withInput();
    }

    public function courseDelete(Request $request) {
        $artCourse = ArtCourse::findOrFail($request->id);
        $image_path = public_path("img/course/{$artCourse->image_path}");
        if (!str_contains($image_path ,'default.webp')) {
            unlink($image_path);
        }
        SubArtCourse::whereIn('id', SubArtCourse::where('art_course_id', $request->id)->pluck('id')->toArray())->delete();
        ArtCourse::destroy($artCourse->id);
        return back();
    }

    public function courseSubCreate(Request $request) {
        $artCourse = ArtCourse::findOrFail($request->masterId);
        SubArtCourse::whereIn('id', SubArtCourse::where('art_course_id', $request->masterId)->pluck('id')->toArray())->delete();

        foreach ($request->all() as $key) {
            if (is_array($key)) {
                $subArtCourse = new SubArtCourse([
                    'title' => $key['title'] ?? 'N/A',
                    'sub_desc' => $key['sub_desc'] ?? 'N/A',
                    'link' => $key['link'] ?? '#',
                ]);

                $artCourse->subArtCourses()->save($subArtCourse);
            }
        }
    }
}
