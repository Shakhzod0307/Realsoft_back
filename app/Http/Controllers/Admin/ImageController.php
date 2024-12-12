<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    public function dashboard()
    {
        return view('admin.images.index');
    }

    public function imageCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        try {
            $data = $request->all();
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = $file->getClientOriginalName();
                $file->move(public_path('images'), $imageName);
                $data['image'] = '/images/' . $imageName;
            }
            $image = Image::create($data);
            return response()->json(['data' => $image], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function imageUpdate(Request $request, string $id): JsonResponse
    {
        try {
            $image = Image::find($id);
            if (!$image) {
                return response()->json(['error' => 'Image not found'], 404);
            }
            $image->type = $request->input('type', $image->type);
            if ($request->hasFile('image')) {
                $imageName = $request->file('image')->getClientOriginalName();
                $imagePath = $request->file('image')->move(public_path('images'), $imageName);
                $image->image = '/images/' . $imageName;
            }
            $image->save();
            return response()->json(['data' => $image], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function imageDelete(string $id)
    {
        try {
            $image = Image::findOrFail($id);
            $image->delete();
            return response()->json(['data'=>'Image deleted successfully!'],200);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
