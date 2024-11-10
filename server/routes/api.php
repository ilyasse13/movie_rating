<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\WatchlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/verify-email', [AuthController::class, 'verifyemail']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'userdata']);
    Route::get('/userwatchlist', [WatchlistController::class, 'userwatchlist']);
    Route::post('/addtowatchlist', [WatchlistController::class, 'insertWatchlist']);
    Route::delete('/deletewatch/{movie_id}',[WatchlistController::class,'deleteWatchlist']);
    Route::get('/movierate/{movie_id}',[RatingController::class,'getMovieRating']);
    Route::get('/allratings',[RatingController::class,'getAllMoviesAverageRatings']);
    Route::post('/addRating',[RatingController::class,'addRating']);

});




