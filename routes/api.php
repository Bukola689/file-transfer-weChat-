<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FileTransferController;
use App\Http\Controllers\DownloadController;
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

       Route::group(['prefix'=> 'auth'], function() {
            Route::post('register', [RegisterController::class, 'register']);
            Route::post('login', [LoginController::class, 'login']);
            Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
         Route::group(['middleware' => 'auth:sanctum'], function() {
            Route::post('logout', [LogoutController::class, 'logout']);
            Route::post('/email/verification-notification', [VerifyEmailController::class, 'resendNotification'])->name('verification.send');
            Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']); 
 
         });
     });

       Route::group(['middleware' => 'auth:sanctum'], function() {
    // User transfers
       Route::get('/transfers', [FileTransferController::class, 'index']);
       Route::post('/transfers', [FileTransferController::class, 'store']);
       Route::get('/transfers/{uuid}', [FileTransferController::class, 'show']);
       Route::delete('/transfers/{uuid}', [FileTransferController::class, 'destroy']);
    
    // Admin routes
      Route::prefix('admin')->middleware('admin')->group(function () {
          Route::get('/transfers', 'Admin\TransferController@index');
          Route::get('/transfers/{uuid}', 'Admin\TransferController@show');
          Route::delete('/transfers/{uuid}', 'Admin\TransferController@destroy');
         });
      });

// Public download routes
    Route::get('/download/{uuid}', [DownloadController::class, 'show']);
    Route::post('/download/{uuid}/authenticate',  [DownloadController::class, 'authenticate']);
    Route::get('/download/{uuid}/files', [DownloadController::class, 'files']);
