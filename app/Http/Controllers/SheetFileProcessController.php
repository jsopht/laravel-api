<?php

namespace App\Http\Controllers;

use App\SheetFileProcess;
use App\Http\Resources\SheetFileProcess as SheetFileProcessResource;

class SheetFileProcessController extends Controller
{
    /**
    * Display the sheet file process status.
    *
    * @return \Illuminate\Http\Response
    */
    public function status()
    {
        return new SheetFileProcessResource(SheetFileProcess::first());
    }
}
