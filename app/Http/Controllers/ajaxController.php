<?php

namespace App\Http\Controllers;

use App\Models\scene;
use Illuminate\Http\Request;

use function Laravel\Prompts\alert;

class ajaxController extends Controller
{
    public function getJsonData()
{
    $jsonData = scene::select('state')->first(); // JSON olarak tutulan sütunu seçin

    if ($jsonData) {
        return response()->json($jsonData->json_column);
    } else {
        return response()->json(['error' => 'Veri bulunamadı'], 404);
    }
}


   public function dataCheck(Request $request){
    dd($request->all());

    return alert('hello');
   }
}
