<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ReportController extends Controller
{
    public function getIndex()
    {
        return view('report');
    }
}
