<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SheetSearchController extends Controller
{
    /**
     * 首頁
     *
     */
    public static function getIndex(Request $request)
    {
        $model = (object)[];
        return view('sheet_search', compact('model'));
    }

}
