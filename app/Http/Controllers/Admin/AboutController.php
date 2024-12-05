<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AboutController extends Controller
{

    public function dashboard()
    {
        return view('admin.about.index');
    }

    public function aboutCreate(Request $request)
    {
        try {
            $about = Contact::create($request->all());
            return response()->json(['data'=>$about],200);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function aboutUpdate(Request $request, string $id): JsonResponse
    {
        try {
            $about = Contact::find($id);
            if (!$about) {
                return response()->json(['error' => 'Contact not found'], 404);
            }
            $about->phone = $request->input('phone', $about->phone);
            $about->email = $request->input('email', $about->email);
            $about->address = $request->input('address', $about->address);
            $about->save();
            return response()->json(['data' => $about], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function aboutDelete(string $id)
    {
        try {
            Contact::destroy($id);
            return response()->json(['data'=>'Contact deleted successfully!'],200);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
