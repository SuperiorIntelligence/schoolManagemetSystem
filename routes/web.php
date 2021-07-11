<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backEnd\UserController;
use App\Http\Controllers\backend\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('admin.index');
})->name('dashboard');

Route::get("/logout",[AdminController::class,"logout"])->name("logoutAdmin");

//User Management User


Route::prefix('users')->group(function (){
    Route::get("/view",[UserController::class,"UserView"])->name("UserView");
    Route::get("/add",[UserController::class,"UserAdd"])->name("userAdd");
    Route::post("/store",[UserController::class,"UserStore"])->name("usersStore");

    Route::get("/edite/{id}",[UserController::class,"UserEdite"])->name("usersEdite");
    Route::get("/delete/{id}",[UserController::class,"UserDelete"])->name("usersDelete");
    Route::post("/update/{id}",[UserController::class,"UserUpdate"])->name("usersUpdate");

    Route::get("/delete/{id}",[UserController::class,"UserDelete"])->name("usersDelete");

});

//User Profile and change Password
Route::prefix('profiles')->group(function (){
    Route::get("/view",[ProfileController::class,"profileView"])->name("profileView");

    Route::get("/edite",[ProfileController::class,"editeProfile"])->name("editeProfile");

    Route::post("/store",[ProfileController::class,"storeProfile"])->name("profileStore");

    Route::get("/edite/password",[ProfileController::class,"changePassword"])->name("changePassword");

    Route::post("/password/update",[ProfileController::class,"updatePassword"])->name("updatePassword");


});
