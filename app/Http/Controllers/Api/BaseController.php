<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as Controller;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    public function success($data) {
        return response()->json(["success" => true, "data" => $data]);
    }

    public function error($data) {
        return response()->json(["success" => false, "msg" => $data], 500);
    }
}
