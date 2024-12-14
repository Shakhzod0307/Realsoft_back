<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function blogs(Request $request)
    {
        $searchQuery = $request->input('search', '');
        $lang = $request->lang;
        $validLanguages = ['en', 'uz', 'ru'];
        if (!in_array($lang, $validLanguages)) {
            return response()->json(['error' => 'Invalid language'], 400);
        }

        $blogs = Blog::when($searchQuery, function ($query) use ($searchQuery, $lang) {
            $query->where(function ($query) use ($searchQuery, $lang) {
                $query->where("title->{$lang}", 'LIKE', "%{$searchQuery}%")
                    ->orWhere("text->{$lang}", 'LIKE', "%{$searchQuery}%");
            });
        })
            ->paginate(20);
        $blogs->getCollection()->transform(function ($blog) use ($lang) {
            $blog->title = json_decode($blog->title, true) ?? [];
            $blog->text = json_decode($blog->text, true) ?? [];
            $blog->images = json_decode($blog->images, true) ?? [];
            $blog->title = $blog->title[$lang] ?? '';
            $blog->text = $blog->text[$lang] ?? '';

            return $blog;
        });
        return response()->json(['data' => $blogs], 200);
    }

    public function showBlog($id)
    {
        $blog = Blog::find($id);
        $blog->title = json_decode($blog->title, true) ?? [];
        $blog->text = json_decode($blog->text, true) ?? [];
        $blog->images = json_decode($blog->images, true) ?? [];
        return response()->json(['data' => $blog], 200);
    }




}
