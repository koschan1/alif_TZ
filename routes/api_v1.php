<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\GetUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post("/user", [GetUserController::class, 'getUser']);
    Route::post("/contacts", [GetUserController::class, 'getContacts']);
    Route::post("/contact/{id}", [GetUserController::class, 'getContact']);
    Route::post("/create", [GetUserController::class, 'createContact']);
    Route::post("/update/{id}", [GetUserController::class, 'updateContact']);
    Route::post("/search", [GetUserController::class, 'search']);
});

Route::controller(AuthController::class)->group(function (){
   Route::post('login', "login");
   Route::post('register', "register");
});

