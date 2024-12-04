<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PartnerController extends Controller
{
    public function dashboard()
    {
        return view('admin.partners.index');
    }

    public function partnerCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        try {
            $data = [];
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $imageName);
            $data['image'] = '/images/' . $imageName;
            $partner = Partner::create($data);
            return response()->json(['data' => $partner], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function partnerUpdate(Request $request, string $id): JsonResponse
    {
        try {
            $partner = Partner::find($id);
            if (!$partner) {
                return response()->json(['error' => 'Team Member not found'], 404);
            }
            if ($request->hasFile('image')) {
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $imagePath = $request->file('image')->move(public_path('images'), $imageName);
                $partner->image = '/images/' . $imageName;
            }
            $partner->save();
            return response()->json(['data' => $partner], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function partnerDelete(string $id)
    {
        try {
            $partner = Partner::findOrFail($id);
//            if ($team->image && file_exists(public_path($team->image))) {
//                unlink(public_path($team->image));
//            }
            $partner->delete();
            return response()->json(['data'=>'Team deleted successfully!'],200);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
