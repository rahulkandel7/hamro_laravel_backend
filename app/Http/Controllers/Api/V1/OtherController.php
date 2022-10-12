<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OtherController extends Controller
{
    public function getUser()
    {
        return response()->json([
            'user' => auth()->user()
        ]);
    }
}
