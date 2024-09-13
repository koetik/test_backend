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

Route::post('approver', [\App\Http\Controllers\ApproverController::class, 'store']);
Route::post('approval-stages', [\App\Http\Controllers\ApprovalStageController::class, 'store']);
Route::put('approval-stages/{id}', [\App\Http\Controllers\ApprovalStageController::class, 'update']);

Route::post('expenses', [\App\Http\Controllers\ExpenseController::class, 'store']);
Route::get('expenses/{id}', [\App\Http\Controllers\ExpenseController::class, 'show']);
Route::patch('expenses/{id}/approve', [\App\Http\Controllers\ExpenseController::class, 'update']);