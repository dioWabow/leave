<?php

namespace App\Http\Controllers\Sheet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SheetProjectController extends Controller
{
    /**
     * 列表
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {

        return  view('sheet_project');
    }

    /**
     * 檢視
     *
     * @return \Illuminate\Http\Response
     */
    public function getEdit(Request $request)
    {
       
        return  view('sheet_project_form');
    }

    /**
     * 刪除
     *
     * @return \Illuminate\Http\Response
     */
    public function postDelete(Request $request, $id)
    {

    }

    /**
     * 新增
     *
     * @param Request $request
     * @return Redirect
     */
    public function postInsert(Request $request)
    {

    }

    /**
     * 更新
     *
     * @param Request $request
     * @return Redirect
     */
    public function postUpdate(Request $request)
    {

    }
}
