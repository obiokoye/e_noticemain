<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PaymentCycleController;
use App\Http\Controllers\SubscriptionController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'index'])->name('auth.index');
Route::post('/', [AuthController::class, 'login'])->name('auth.login');
Route::get('logout', [AuthController::class, 'logout']); 


Route::group(['middleware' => 'useradmin'], function(){

    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('userrole', [UserRoleController::class, 'index'])->name('userrole.index');
    Route::get('userrole/create', [UserRoleController::class, 'create'])->name('userrole.create');
    Route::post('userrole/store', [UserRoleController::class, 'store'])->name('userrole.store');
    Route::get('userrole/edit/{id}', [UserRoleController::class, 'edit'])->name('userrole.edit');
    Route::post('userrole/update/{id}', [UserRoleController::class, 'update'])->name('userrole.update');
    Route::get('userrole/delete/{id}', [UserRoleController::class, 'destroy'])->name('userrole.destroy');

    Route::get('users', [UserController::class, 'index'])->name('user.index');
    Route::get('users/create', [UserController::class, 'create'])->name('user.create');
    Route::post('users/store', [UserController::class, 'store'])->name('user.store');
    Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('users/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('users/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('departments', [DepartmentController::class, 'index'])->name('department.index');
    Route::get('departments/create', [DepartmentController::class, 'create'])->name('department.create');
    Route::post('departments/store', [DepartmentController::class, 'store'])->name('department.store');
    Route::get('departments/edit/{id}', [DepartmentController::class, 'edit'])->name('department.edit');
    Route::post('departments/update/{id}', [DepartmentController::class, 'update'])->name('department.update');
    Route::get('departments/delete/{id}', [DepartmentController::class, 'destroy'])->name('department.destroy');

    Route::get('category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    Route::get('paymentcycle', [PaymentCycleController::class, 'index'])->name('paymentcycle.index');
    Route::get('paymentcycle/create', [PaymentCycleController::class, 'create'])->name('paymentcycle.create');
    Route::post('paymentcycle/store', [PaymentCycleController::class, 'store'])->name('paymentcycle.store');
    Route::get('paymentcycle/edit/{id}', [PaymentCycleController::class, 'edit'])->name('paymentcycle.edit');
    Route::post('paymentcycle/update/{id}', [PaymentCycleController::class, 'update'])->name('paymentcycle.update');
    Route::get('paymentcycle/delete/{id}', [PaymentCycleController::class, 'destroy'])->name('paymentcycle.destroy');


//subscriptions routes
    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscription.index');
    Route::get('subscriptions/create', [SubscriptionController::class, 'create'])->name('subscription.create');
    Route::post('subscriptions/store', [SubscriptionController::class, 'store'])->name('subscription.store');
    Route::get('subscriptions/edit/{id}', [SubscriptionController::class, 'edit'])->name('subscription.edit');
    Route::post('subscriptions/update/{id}', [SubscriptionController::class, 'update'])->name('subscription.update');
    Route::get('subscriptions/delete/{id}', [SubscriptionController::class, 'destroy'])->name('subscription.destroy');

//subscription Renewal routes
    Route::get('subscription/renew', [SubscriptionController::class, 'showRenewalModal'])->name('subscription.renew');
    Route::post('subscription/renew/auto/{id}', [SubscriptionController::class, 'autoRenew'])->name('subscription.renew.auto');
    Route::post('subscription/renew/custom/{id}', [SubscriptionController::class, 'customRenew'])->name('subscription.renew.custom');


//Reports Routes
    Route::get('reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('/reports/filter', [ReportsController::class, 'filter'])->name('reports.filter');


});







