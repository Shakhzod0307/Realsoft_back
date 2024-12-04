<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function getImages()
    {
        $images = Image::all();
        return response()->json(['data'=>$images]);
    }
}
