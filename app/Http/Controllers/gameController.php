<?php

namespace App\Http\Controllers;

use App\Models\scene;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class gameController extends Controller
{
    //when someone load the game in main page this function will execute
    public function showPage(Request $request)
    {

        $id = $request['id'];
        $scene = DB::table('scene')->where('id', $id)->first();
         $node = $scene->adress;
        // $state = $scene->state;
        // $state = json_decode($scene->state, true);  // JSON decode işlemi



        if (is_null($node)) {
            $node = 1;
            return view('interface.gamePage', compact('node'));
        } else {

            return view('interface.gamePage', compact('node'));
        }
    }
    public function deleteScene(Request $request)
    {

        $id = $request['id'];
        $scene = scene::find($id);
        $scene->delete();
        return redirect()->route('mainpage');
    }
}
