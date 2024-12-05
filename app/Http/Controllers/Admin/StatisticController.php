<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Statistic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StatisticController extends Controller
{
    public function dashboard()
    {
        return view('admin.statistics.index');
    }


    public function statisticCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'number' => 'required',
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
            $statistic = Statistic::create($data);
            return response()->json(['data' => $statistic], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function statisticUpdate(Request $request, string $id): JsonResponse
    {
        try {
            $statistic = Statistic::find($id);
            if (!$statistic) {
                return response()->json(['error' => 'Statistic not found'], 404);
            }
            $statistic->title = $request->input('title', $statistic->title);
            $statistic->number = $request->input('number', $statistic->number);
            if ($request->hasFile('image')) {
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $imagePath = $request->file('image')->move(public_path('images'), $imageName);
                $statistic->image = '/images/' . $imageName;
            }
            $statistic->save();
            return response()->json(['data' => $statistic], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function statisticDelete(string $id)
    {
        try {
            $statistic = Statistic::findOrFail($id);
//            if ($statistic->image && file_exists(public_path($statistic->image))) {
//                unlink(public_path($statistic->image));
//            }
            $statistic->delete();
            return response()->json(['data'=>'Statistic deleted successfully!'],200);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
