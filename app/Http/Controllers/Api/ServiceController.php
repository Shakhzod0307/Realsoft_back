<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function services(Request $request)
    {
        $searchQuery = $request->input('search', '');

        $services = Service::when($searchQuery, function ($query) use ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('text', 'LIKE', "%{$searchQuery}%");
            });
        })
            ->paginate(20);
        return response()->json(['data'=>$services],200);
    }
}
