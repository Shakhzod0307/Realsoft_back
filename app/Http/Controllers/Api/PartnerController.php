<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function partner()
    {
        $partners = Partner::all();
        return response()->json(['data'=>$partners]);
    }
}
