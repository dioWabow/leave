<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as FakePaginator;

class SheetSearchController extends Controller
{
    /**
     * 首頁
     *
     */
    public static function getIndex(Request $request)
    {
        $fake_model = Collect(range(1,100));
        $perPage = 10;
        $fake_pagination = new FakePaginator($fake_model, count($fake_model) , $perPage);
        return view('sheet_search', ['fake_pagination'=> $fake_pagination]);
    }

}
