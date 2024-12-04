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

        $blogs = Blog::when($searchQuery, function ($query) use ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('text', 'LIKE', "%{$searchQuery}%");
            });
        })
            ->paginate(20);
        return response()->json(['data'=>$blogs],200);
    }
}
