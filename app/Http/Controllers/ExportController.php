<?php

namespace App\Http\Controllers;

use Excel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExportController extends Controller
{
    public function ExportReport()
    {
    	Excel::create('export_report', function($excel){

    		$excel->sheet('export_report', function($sheet){
    			$sheet->loadView('report');
    		});

    	})->export('xlsx');
    }
}
