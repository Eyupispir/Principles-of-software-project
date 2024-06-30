<?php

namespace App\Http\Controllers;

use App\Models\scene;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class mainPageController extends Controller
{
    //function of showing page
    //takes input from db and shows the scenes in js
    public function showPage()
    {

        $scenes = DB::table('scene')->get()->all();

        return view('interface.mainPage', compact('scenes'));
    }
    public function newGame()
    {

        $scene  = new scene();
        $scene->user_id = Auth::id();
        $scene->adress = 1;
        $scene->save();

        return redirect(route(name:'mainpage'));
    }
}
