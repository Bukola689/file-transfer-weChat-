<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//       Route::middleware('auth:api')->group(function () {
//     // User transfers
//     Route::get('/transfers', 'TransferController::index');
//     Route::post('/transfers', 'TransferController::store');
//     Route::get('/transfers/{uuid}', 'TransferController::show');
//     Route::delete('/transfers/{uuid}', 'TransferController::destroy');
    
//     // Admin routes
//     Route::prefix('admin')->middleware('admin')->group(function () {
//         Route::get('/transfers', 'Admin\TransferController@index');
//         Route::get('/transfers/{uuid}', 'Admin\TransferController@show');
//         Route::delete('/transfers/{uuid}', 'Admin\TransferController@destroy');
//     });
// });

// // Public download routes
// Route::get('/download/{uuid}', 'DownloadController@show');
// Route::post('/download/{uuid}/authenticate', 'DownloadController@authenticate');
// Route::get('/download/{uuid}/files', 'DownloadController@files');
