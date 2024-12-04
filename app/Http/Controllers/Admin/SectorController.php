<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sector;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SectorController extends Controller
{
    public function dashboard()
    {
        return view('admin.sectors.index');
    }

    public function sectorCreate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'text' => 'required|string',
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
            $sector = Sector::create($data);
            return response()->json(['data' => $sector], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function sectorUpdate(Request $request, string $id): JsonResponse
    {
        try {
            $sector = Sector::find($id);
            if (!$sector) {
                return response()->json(['error' => 'Sector not found'], 404);
            }
            $sector->title = $request->input('title', $sector->title);
            $sector->text = $request->input('text', $sector->text);
            if ($request->hasFile('image')) {
                if ($sector->image && file_exists(public_path($sector->image))) {
                    unlink(public_path($sector->image));
                }
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $imagePath = $request->file('image')->move(public_path('images'), $imageName);
                $sector->image = '/images/' . $imageName;
            }
            $sector->save();
            return response()->json(['data' => $sector], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function sectorDelete(string $id): JsonResponse
    {
        try {
            $sector = Sector::findOrFail($id);
//            if ($sector->icon && file_exists(public_path($sector->icon))) {
//                unlink(public_path($sector->icon));
//            }
            $sector->delete();
            return response()->json(['data'=>'Sector deleted successfully!'],200);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
