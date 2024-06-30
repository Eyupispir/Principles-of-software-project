<?php

namespace App\Http\Controllers;

use App\Models\scene;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class saveController extends Controller
{
    //
    public function save(Request $request)
    {
        $userId = Auth::id();
        $id = $request['id'];
        $data = $request['data'];

        $jsonData = json_encode($data);
        DB::update('update scene set state = ? where user_id = ?', [$jsonData, $userId]);
        DB::update('update scene set adress = ? where user_id = ?', [$id, $userId]);

        DB::update('update scene set updated_at = ? where user_id = ?', [Carbon::now(), $userId]);


    }
    
    public function saveStatus(Request $req)
    {

        dd($req->all());
    }
}
