<?php

use App\Http\Controllers\activityController;
use App\Http\Controllers\proyectController;
use App\Http\Controllers\taskController;
use App\Http\Controllers\userController;
use App\Http\Controllers\UserProyectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

    Route::post('/login',[userController::class,'login'])->name('login');
    Route::post('/register',[userController::class,'user_create'])->name('register');


    Route::group(['middleware'=>['auth:sanctum']],function(){
//User action

        Route::get('/close_session',[userController::class,'close_session'])->name('close_session');
//proyect action
        Route::put('/proyect_create',[proyectController::class,'store'])->name('proyect_create');
        Route::delete('proyect_delete',[proyectController::class,'remove_proyect'])->name('proyect_delete')->middleware('UserRoll:proyect_delete');
        Route::get('/list_custon_proyect', [proyectController::class,'list_custon_proyect'])->name('list_custon_proyect');

//Task action
        Route::put('/task_create',[taskController::class,'store'])->name('task_create')->middleware('UserRoll:task_create');
        Route::delete('/task_delete',[taskController::class,'remove'])->name('task_delete')->middleware('UserRoll:task_delete');
        Route::post('/task_modify',[taskController::class,'modify'])->name('task_modify')->middleware('UserRoll:task_create');
        Route::get('get_task',[taskController::class,'get_task'])->name('get_task');

//activity action

        Route::put('/activity_create',[activityController::class,'store'])->name('activity_create')->middleware('UserRoll:activity_create');
        Route::delete('/activity_delete',[activityController::class,'remove'])->name('activity_delete')->middleware('UserRoll:activity_delete');
        Route::post('/activity_modify',[activityController::class,'modify'])->name('activity_modify')->middleware('UserRoll:activity_create');
        Route::get('/get_activity',[activityController::class,'list_custon_activity'])->name('get_activity');

//user_has_proyect
//
        Route::put('user_proyect_create',[UserProyectController::class,'store'])->name('user_proyect_create')->middleware('UserRoll:relation_user_proyect');
        Route::put('user_proyect_modify',[UserProyectController::class,'modify'])->name('user_proyect_modify')->middleware('UserRoll:relation_user_proyect');
        Route::get('/get_user_proyect',[UserProyectController::class,'get_relation_user_proyect'])->name('get_user_proyect');
    });

