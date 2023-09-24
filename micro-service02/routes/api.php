<?php

use App\Http\Controllers\Api\EvaluationController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
   return response()
   ->json([
       'message' => 'api is running'
   ]);
});

Route::get('/evaluations/{company}', [EvaluationController::class, 'index']);
Route::post('/evaluations', [EvaluationController::class, 'store']);
