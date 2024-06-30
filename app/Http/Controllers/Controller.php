<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function testPage(){
        return view('layout.app');


    }
}
