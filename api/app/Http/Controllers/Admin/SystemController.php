<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SystemResource;
use App\Models\System;

class SystemController extends Controller
{
    public function index()
    {
        return SystemResource::collection(
            System::paginate(10)
        );
    }
}
