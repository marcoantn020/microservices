<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()
        ->json(['message' => 'Api is running']);
});

Route::get('/test', function () {
    \App\Jobs\CompanyCreatedJob::dispatch('test@test.com')->onQueue('queue_email');
    return response()
        ->json(['message' => 'success']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
