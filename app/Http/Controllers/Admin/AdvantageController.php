<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advantage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdvantageController extends Controller
{
    public function dashboard()
    {
        return view('admin.advantages.index');
    }

    public function advantageCreate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
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
            $advantage = Advantage::create($data);
            return response()->json(['data' => $advantage], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function advantageUpdate(Request $request, string $id): JsonResponse
    {
        try {
            $advantage = Advantage::find($id);
            if (!$advantage) {
                return response()->json(['error' => 'Advantage not found'], 404);
            }
            $advantage->text = $request->input('text', $advantage->text);
            if ($request->hasFile('image')) {
                if ($advantage->image && file_exists(public_path($advantage->image))) {
                    unlink(public_path($advantage->image));
                }
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $imagePath = $request->file('image')->move(public_path('images'), $imageName);
                $advantage->image = '/images/' . $imageName;
            }
            $advantage->save();
            return response()->json(['data' => $advantage], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function advantageDelete(string $id): JsonResponse
    {
        try {
            $advantage = Advantage::findOrFail($id);
//            if ($sector->icon && file_exists(public_path($sector->icon))) {
//                unlink(public_path($sector->icon));
//            }
            $advantage->delete();
            return response()->json(['data'=>'Advantage deleted successfully!'],200);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
