<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/pull', function() {
    $process = new Process(["git pull"]);
    $process->setWorkingDirectory(base_path());
    $process->run();

    if($process->isSuccessful()){
        return ['OK'];
    } else {
        throw new ProcessFailedException($process);
    }

});
