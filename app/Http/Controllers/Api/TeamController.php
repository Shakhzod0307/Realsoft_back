<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function teams(Request $request)
    {
        $searchQuery = $request->input('search', '');

        $teams = Team::when($searchQuery, function ($query) use ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('name', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('position', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('type', 'LIKE', "%{$searchQuery}%");
            });
        })->get();
        return response()->json(['data'=>$teams]);
    }
}
