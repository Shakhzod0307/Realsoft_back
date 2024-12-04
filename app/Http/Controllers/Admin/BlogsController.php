<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogsController extends Controller
{
    public function dashboard()
    {
        return view('admin.blogs.index');
    }


    public function blogCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        try {
            $data = $request->all();
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images'), $imageName);
                $data['image'] = '/images/' . $imageName;
            }
            $blog = Blog::create($data);
            return response()->json(['data' => $blog], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function blogUpdate(Request $request, string $id): JsonResponse
    {
        try {
            $blog = Blog::find($id);
            if (!$blog) {
                return response()->json(['error' => 'Blog not found'], 404);
            }
            $blog->title = $request->input('title', $blog->title);
            $blog->text = $request->input('text', $blog->text);
            if ($request->hasFile('image')) {
                if ($blog->image && file_exists(public_path($blog->image))) {
                    unlink(public_path($blog->image));
                }
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $imagePath = $request->file('image')->move(public_path('images'), $imageName);
                $blog->image = '/images/' . $imageName;
            }
            $blog->save();
            return response()->json(['data' => $blog], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function blogDelete(string $id)
    {
        try {
            $blog = Blog::findOrFail($id);
            if ($blog->image && file_exists(public_path($blog->image))) {
                unlink(public_path($blog->image));
            }
            $blog->delete();
            return response()->json(['data'=>'Blog deleted successfully!'],200);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}



