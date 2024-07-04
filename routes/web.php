<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Middleware\Admin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// wordt niet gebruikt
Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('user.index');

// wordt niet gebruikt
Route::get('admin', [HomeController::class, 'admin'])->middleware('admin');

// wordt niet gebruikt
Route::get('home', [HomeController::class, 'home'])->middleware('user');





//start pagina
Route::get('start/{node?}', [GameController::class, 'index'])->name('Start')->where('page', '[0-9]+');

// toont gerelateerd yes node
Route::get('start/{node?}/no/{relation?}', [GameController::class, 'no'])->name('No');

// toont gerelateerde no node
Route::get('start/{node?}/yes/{relation?}', [GameController::class, 'yes'])->name('Yes');

// voert smart guess uit
Route::get('start/smartguess/{node}/{totalClicks}', [GameController::class, 'SmartGuess'])
    ->name('SmartGuess')
    ->where(['node' => '[0-9]+', 'totalClicks' => '[0-9]+']);


// reset naar smart guess input node
Route::get('start/smartguessfailed/{node}', [GameController::class, 'ResetTo_SmartGuessInputNode'])
    ->name('SmartGuessFailed')
    ->where(['node' => '[0-9]+']);



// controleert als gebruiker in de path van net opgeslagen failed node speelt
Route::get('start/smartguessfailedandchekpathfromfailednode/{node}', [GameController::class, 'LOOP_ChekIfCurrentNode_LiesInFailedNodePath_AndAddNewCharacter'])
    ->name('LOOP_ChekIfCurrentNode_LiesInFailedNodePath_AndAddNewCharacter')
    ->where(['node' => '[0-9]+']);





//  yes node antwoord score opslaan
Route::post('start/{node?}/no/{relation?}', [GameController::class, 'score_opslaan'])->name('score_opslaan')->where('page', '[0-9]+');

//  no node antwoord score opslaan
Route::post('start/{node?}/yes/{relation?}', [GameController::class, 'score_opslaan'])->name('score_opslaan')->where('page', '[0-9]+');



// karakter OPSLAAN
Route::post('add/', [GameController::class, 'store'])->name('Add');

// toont leaderboard
Route::get('start/leaderboard', [GameController::class, 'leaderboard'])->name('leaderboard');;

// toont score invoer scherm
Route::get('start/scoreinvoer', [GameController::class, 'score_invoer'])->name('score_invoer');;

//zoekt naar alle paths van de gekozen node 4 times nodes. van beneden naar boven//
Route::post('/handle-loop-up', [GameController::class, 'handleLoopUpRequest'])->name('handle_loop_up');
