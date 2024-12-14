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
            'title.en' => 'required|string|max:255',
            'title.uz' => 'required|string|max:255',
            'title.ru' => 'required|string|max:255',
            'text.en' => 'required|string',
            'text.uz' => 'required|string',
            'text.ru' => 'required|string',
            'images.*.file' => 'required',
            'images.*.index' => 'required',
        ]);
        $files = [];
        if ($request->has('images')) {
            foreach ($request->input('images') as $key => $imageData) {
                if ($request->hasFile("images.$key.file")) {
                    $file = $request->file("images.$key.file");
                    $name = time() . '_' .$file->getClientOriginalName();
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
            'title' => json_encode($data['title']),
            'text' => json_encode($data['text']),
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
            $validator = Validator::make($request->all(), [
                'title.en' => 'required|string|max:255',
                'title.uz' => 'required|string|max:255',
                'title.ru' => 'required|string|max:255',
                'text.en' => 'required|string',
                'text.uz' => 'required|string',
                'text.ru' => 'required|string',
                'images.*.file' => 'nullable|file|mimes:jpeg,png,jpg,svg',
                'images.*.url' => 'nullable|string',
                'images.*.index' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $data = $validator->validated();
            $blog->title = json_encode($data['title']);
            $blog->text = json_encode($data['text']);
            $newFiles = [];
            if ($request->has('images')) {
                foreach ($request->input('images') as $key => $imageData) {
                    if ($request->hasFile("images.$key.file")) {
                        $file = $request->file("images.$key.file");
                        $name = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('blogs'), $name);
                        $newFiles[] = [
                            'url' => '/blogs/' . $name,
                            'index' => (int) $imageData['index'],
                        ];
                    } else {
                        if (isset($imageData['url'])) {
                            $newFiles[] = [
                                'url' => $imageData['url'],
                                'index' => (int) $imageData['index'],
                            ];
                        }
                    }
                }
            }
            $blog->images = json_encode($newFiles);
            $blog->save();
            return response()->json(['data' => $blog], 200);
        } catch (\Exception $exception) {
            Log::error("Error updating blog: " . $exception->getMessage());
            return response()->json(['error' => 'An error occurred while updating the blog.'], 500);
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



