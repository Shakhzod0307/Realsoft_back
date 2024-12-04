<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sector;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    public function sectors(Request $request): JsonResponse
    {
        $searchQuery = $request->input('search', '');
        $sectors = Sector::when($searchQuery, function ($query) use ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('text', 'LIKE', "%{$searchQuery}%");
            });
        })
            ->paginate(20);
        return response()->json(['data'=>$sectors],200);
    }
}
