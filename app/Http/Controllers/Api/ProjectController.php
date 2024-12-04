<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
class ProjectController extends Controller
{
    public function projects(Request $request)
    {
        $searchQuery = $request->input('search', '');

        $projects = Project::when($searchQuery, function ($query) use ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'LIKE', "%{$searchQuery}%");
            });
        })
            ->get();
        return response()->json(['data'=>$projects],200);
    }
}
