<?php

use App\Http\Controllers\ajaxController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\gameController;
use App\Http\Controllers\mainPageController;
use App\Http\Controllers\saveController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/test', function () {
//     return view('test');
// });


Route::get('/main' , [mainPageController::class , 'showPage'])->name('mainpage');
Route::get('/mainpage' , [mainPageController::class , 'newGame'])->name('asd');
Route::get('/newGame',[mainPageController::class , 'newGame'])->name('new');



//////////////LOAD GAME///////////Start
Route::get('/game/{id}', [gameController::class , 'showPage'])->name('gamepage');
Route::get('/deletescene/{id}',[gameController::class, 'deleteScene'])->name('deleteNode');




//////////////LOAD GAME///////////End



//////////////Save GAME///////////Start

Route::get('/savedata/{id}', [ saveController::class , 'save']) ->name('savedata');
Route::get('/saveStatus', [saveController::class , 'saveStatus'])->name('saveStat');



//////////////Save GAME///////////End
//////////////Ajax///////////Start

Route::get('/test',[ajaxController::class , 'dataCheck'])->name('ajax');
Route::get('/get-json-data', [AjaxController::class, 'getJsonData'])->name('json.data');

//////////////ajax///////////End




Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('new');
    })->name('dashboard');
});

require_once __DIR__.'/jetstream.php';
