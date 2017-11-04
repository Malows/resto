<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request) {
        return $request->user();
    }

    public function me(Request $request) {
        return $request->user();
    }
}
