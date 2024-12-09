<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    public function socialMediaCreate(Request $request)
    {
        try {
            $item = SocialMedia::create($request->all());
            return response()->json(['data'=>$item],200);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function socialMediaUpdate(Request $request, string $id): JsonResponse
    {
        try {
            $item = SocialMedia::find($id);
            if (!$item) {
                return response()->json(['error' => 'Item not found'], 404);
            }
            $item->name = $request->input('name', $item->name);
            $item->class = $request->input('class', $item->class);
            $item->url = $request->input('url', $item->url);
            $item->save();
            return response()->json(['data' => $item], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function socialMediaDelete(string $id)
    {
        try {
            SocialMedia::destroy($id);
            return response()->json(['data'=>'Item deleted successfully!'],200);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
