<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Text;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TextController extends Controller
{

    public function dashboard()
    {
        return view('admin.texts.index');
    }

    public function textCreate(Request $request): JsonResponse
    {
        try {
            $text = Text::create($request->all());
            return response()->json(['data'=>$text],200);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function textUpdate(Request $request, string $id): JsonResponse
    {
        try {
            $text = Text::find($id);
            if (!$text) {
                return response()->json(['error' => 'Text not found'], 404);
            }
            $text->title = $request->input('title', $text->title);
            $text->heading = $request->input('heading', $text->heading);
            $text->text = $request->input('text', $text->text);
            $text->type = $request->input('type', $text->type);
            $text->save();
            return response()->json(['data' => $text], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function textDelete(string $id): JsonResponse
    {
        try {
            Text::destroy($id);
            return response()->json(['data'=>'Contact deleted successfully!'],200);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
