<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Text;
use Illuminate\Http\Request;

class TextController extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = $request->input('search', '');

        $texts = Text::when($searchQuery, function ($query) use ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('heading', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('text', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('type', 'LIKE', "%{$searchQuery}%");
            });
        })->get();
        return response()->json(['data'=>$texts]);
    }
}
