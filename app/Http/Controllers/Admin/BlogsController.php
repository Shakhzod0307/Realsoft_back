<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogsController extends Controller
{
    public function dashboard()
    {
        return view('admin.blogs.index');
    }


    public function blogCreate(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required',
            'images.*' => 'required',
        ]);
        $files = [];
        if ($request->has('images')) {
            foreach ($request->input('images') as $key => $imageData) {
                if ($request->hasFile("images.$key.file")) {
                    $file = $request->file("images.$key.file");
                    $name = $file->getClientOriginalName();
                    $file->move(public_path('blogs'), $name);
                    $files[] = [
                        'url' => '/blogs/'.$name,
                        'index' => (int) $request->input("images.$key.index"),
                    ];
                } else {
                    Log::error("File not found in images.$key.file");
                }
            }
        }
        $blog = Blog::create([
            'title' => $data['title'],
            'text' => $data['text'],
            'images' => json_encode($files),
        ]);

        return response()->json(['blog' => $blog], 201);
    }


    public function blogUpdate(Request $request, string $id): JsonResponse
    {
        try {
            $blog = Blog::find($id);
            if (!$blog) {
                return response()->json(['error' => 'Blog not found'], 404);
            }
            $data = $request->validate([
                'title' => 'nullable|string|max:255',
                'text' => 'nullable|string',
                'images.*' => 'nullable',
            ]);

            $blog->title = $data['title'] ?? $blog->title;
            $blog->text = $data['text'] ?? $blog->text;
//            $existingFiles = json_decode($blog->images, true) ?? [];
            $newFiles = [];
            $updatedFiles = [];

            if ($request->has('images')) {
                foreach ($request->input('images') as $key => $imageData) {
                    if ($request->hasFile("images.$key.file")) {
                        $file = $request->file("images.$key.file");
                        $name = $file->getClientOriginalName();
                        $file->move(public_path('blogs'), $name);
                        $newFiles[] = [
                            'url' => '/blogs/' . $name,
                            'index' => (int)$imageData['index'] ,
                        ];
                        Log::info((int)$imageData['index']);
                    }

                    // Handle existing images with 'url' and 'index'
                    elseif (isset($imageData['url'], $imageData['index'])) {
                        $newFiles[] = [
                            'url' => $imageData['url'],
                            'index' => (int)$imageData['index'],
                        ];
                    }
                    else {
                        Log::error("Invalid image data at key $key");
                    }
                }
            }

//            $allFiles = array_merge($existingFiles, $newFiles);

//            usort($allFiles, fn($a, $b) => $b['index'] <=> $a['index']);

            $blog->images = json_encode($newFiles);
            $blog->save();

            return response()->json(['data' => $blog], 200);

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function blogDelete(string $id): JsonResponse
    {
        try {
            $blog = Blog::findOrFail($id);
            $files = json_decode($blog->images, true);
            if ($files && is_array($files)) {
                foreach ($files as $file) {
                    if (isset($file['url']) && file_exists(public_path($file['url']))) {
                        unlink(public_path($file['url']));
                    }
                }
            }

            $blog->delete();

            return response()->json(['data' => 'Blog deleted successfully!'], 200);

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}



