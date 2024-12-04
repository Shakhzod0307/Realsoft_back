<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advantage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdvantageController extends Controller
{
    public function advantages(Request $request): JsonResponse
    {
        $searchQuery = $request->input('search', '');
        $advantage = Advantage::when($searchQuery, function ($query) use ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('text', 'LIKE', "%{$searchQuery}%");
            });
        })
            ->paginate(20);
        return response()->json(['data'=>$advantage],200);
    }
}
