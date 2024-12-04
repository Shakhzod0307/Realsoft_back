<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    public function dashboard()
    {
        return view('admin.teams.index');
    }

    public function teamCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'position' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,svg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $data = [];
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images'), $imageName);
                $data['image'] = '/images/' . $imageName;
            }

            $name = $request->input('name');
            $position = $request->input('position');

            if (!is_null($name) || !is_null($position)) {
                $data['name'] = $name;
                $data['position'] = $position;
                $data['type'] = 'full';
            } else {
                $data['type'] = 'only-image';
            }
            $team = Team::create($data);
            return response()->json(['data' => $team], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function teamUpdate(Request $request, string $id): JsonResponse
    {
        try {
            $team = Team::find($id);
            if (!$team) {
                return response()->json(['error' => 'Team Member not found'], 404);
            }
            $team->name = $request->input('name', $team->name);
            $team->position = $request->input('position', $team->position);
            if ($request->hasFile('image')) {
                if ($team->image && file_exists(public_path($team->image))) {
                    unlink(public_path($team->image));
                }
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $imagePath = $request->file('image')->move(public_path('images'), $imageName);
                $team->image = '/images/' . $imageName;
            }
            $team->save();
            return response()->json(['data' => $team], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function teamDelete(string $id)
    {
        try {
            $team = Team::findOrFail($id);
//            if ($team->image && file_exists(public_path($team->image))) {
//                unlink(public_path($team->image));
//            }
            $team->delete();
            return response()->json(['data'=>'Team deleted successfully!'],200);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
