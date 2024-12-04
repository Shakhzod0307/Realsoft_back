<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServicesController extends Controller
{


    public function service(Request $request)
    {
        try {
            $service = Service::create($request->all());
            return response()->json(['data'=>$service],200);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function serviceUpdate(Request $request, string $id): JsonResponse
    {
        try {
            $service = Service::find($id);
            if (!$service) {
                return response()->json(['error' => 'Service not found'], 404);
            }
            $service->title = $request->input('title', $service->title);
            $service->text = $request->input('text', $service->text);
            $service->save();
            return response()->json(['data' => $service], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function serviceDelete(string $id)
    {
        try {
            Service::destroy($id);
            return response()->json(['data'=>'Service deleted successfully!'],200);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}


