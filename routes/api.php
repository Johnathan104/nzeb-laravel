<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\BuildingPartController;
use App\Http\Controllers\Api\MaintenanceController;
use App\Http\Controllers\Api\IssueController;
use App\Http\Controllers\Api\CheckController;

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request){
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/getself', [AuthController::class, 'getSelf']);
    Route::get('/user/{id}', [AuthController::class, 'getUser']);
    Route::get('/admin/getusers', [AdminController::class, 'getAllUsers']);
    Route::post('/admin/edituser', [AdminController::class, 'editUser']);
    Route::post('/admin/deleteuser', [AdminController::class, 'deleteUser']);
    Route::get('/getrooms', [RoomController::class, 'getrooms']);
    Route::post('/getroom', [RoomController::class, 'getroom']);
    Route::post('/createroom', [RoomController::class, 'store']);
    Route::post('/deleteroom', [RoomController::class, 'remove']);
    Route::post('/admin/addbuildingpart', [RoomController::class, 'addBuildingPart']);
    Route::post('/removebuildingpart', [RoomController::class, 'deletePart']);
    Route::put('/editRoom/{id}', [RoomController::class, 'edit']);
    Route::post('/makeMaintenance', [MaintenanceController::class, 'store']);
    Route::get('/maintenance/self', [MaintenanceController::class, 'getYourMaintenance']);
    Route::get('/admin/checkadmin', [AdminController::class, 'checkadmin']);
    Route::get('/admin/getallmaintenances', [MaintenanceController::class, 'getallMaintenances']);
    Route::post('/admin/deletemaintenance', [MaintenanceController::class, 'deleteMaintenance']);
    Route::post('/admin/acceptmaintenance', [MaintenanceController::class, 'acceptMaintenance']);
    Route::get('/buildingparts/getall', [BuildingPartController::class, 'getAll']);
    Route::put('/buildingparts/get/{id}', [BuildingPartController::class, 'getPart']);
    Route::put('/issues/update/{id}', [IssueController::class, 'update']);
    Route::post('/addIssue', [IssueController::class, 'store']);
    Route::get('/getissues', [IssueController::class, 'index']);
    Route::put('/getissue/{id}', [IssueController::class, 'show']);
    Route::post('/deleteIssue/{id}', [IssueController::class, 'remove']);
    Route::post('/changeStatus/{id}', [IssueController::class, 'changeStatus']);
    Route::get('/issue/self', [IssueController::class, 'getYourIssue']);
    Route::post('/checks/create', [CheckController::class, 'store']);
    Route::get('/checks', [CheckController::class, 'index']);
    Route::put('/checks/{id}', [CheckController::class, 'update']);
});

Route::get('/buildingparts/getall', [BuildingPartController::class, 'getAll']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);

