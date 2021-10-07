<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\WebFunction;

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

/* GLOBAL WEB */
Route::get('/', [WebController::class, 'index'])->name('/');
Route::get('/search', [WebController::class, 'search'])->name('search');
Route::get('/login', [WebController::class, 'login'])->name('login');
Route::get('/register', [WebController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/face', [WebController::class, 'face'])->name('face');
Route::get('/owner/login', [OwnerController::class, 'login'])->name('ownerLogin');
Route::get('/owner/register', [OwnerController::class, 'register'])->name('ownerRegister');

/* FUNCTION */
Route::post('/auth/user/login', [AuthController::class, 'login'])->name('userLoginFunction');
Route::post('/auth/owner/login', [AuthController::class, 'ownerLogin'])->name('ownerLoginFunction');
Route::post('/auth/user/register', [AuthController::class, 'register'])->name('userRegisterFunction');
Route::get('/search/filter/{place}/{type}', [WebFunction::class, 'filterSearch'])->name('filterSearch');
Route::get('/user/info/{id}', [WebFunction::class, 'getUserInfo']);

/* MUST BE USER AUTH */
Route::group(['middleware' => 'user.auth'], function () {
    Route::get('/detail/{id}/{name}', [WebController::class, 'detail'])->name('detail');
    Route::get('/account', [WebController::class, 'account'])->name('account');
    Route::post('/account/user/update', [AccountController::class, 'updateUserAccount'])->name('updateUserAccount');
    Route::get('/favorite/add/{id}', [WebFunction::class, 'addFavorite'])->name('addFavorite');
    Route::get('/favorite/remove/{id}', [WebFunction::class, 'removeFavorite'])->name('removeFavorite');
    Route::post('/review/add', [WebFunction::class, 'addReview'])->name('addReview');
    Route::post('/pay/day', [WebFunction::class, 'payDay'])->name('payDay');
    Route::post('/pay/month', [WebFunction::class, 'payMonth'])->name('payMonth');
    Route::post('/pay/year', [WebFunction::class, 'payYear'])->name('payYear');
    Route::get('/pay/bill/{id}', [WebFunction::class, 'payBill'])->name('payBill');
    Route::post('/pay/topup', [WebFunction::class, 'topupBalance'])->name('topupBalance');
    Route::get('/account/add/balance/{balance}', [WebFunction::class, 'addBalance'])->name('addBalance');
});

Route::get('/owner', function () {
    return redirect('/owner/dashboard');
});

/* MUST BE OWNER AUTH */
Route::group(['middleware' => 'owner.auth'], function () {
    Route::get('/owner/dashboard', [OwnerController::class, 'dashboard'])->name('ownerDashboard');
    Route::get('/owner/income', [OwnerController::class, 'income']);
    Route::get('/owner/booking', [OwnerController::class, 'booking']);
    Route::get('/owner/bill', [OwnerController::class, 'bill']);
    Route::get('/owner/property', [OwnerController::class, 'property']);
    Route::get('/owner/chat', [OwnerController::class, 'chat'])->name('ownerChat');

    Route::post('owner/property/insert', [OwnerController::class, 'insertProperty']);
});

//route for admin without middleware
Route::get('/admin', function () {
    return redirect('/admin/dashboard');
});
Route::get('/admin/login', [AdminController::class, 'login'])->name('adminLogin');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('adminDashboard');
Route::get('/admin/user', [AdminController::class, 'manageUser'])->name('adminCollectionUser');
Route::get('/admin/user/{userid}', [AdminController::class, 'getUserByAdmin'])->name('adminGetUser');
Route::post('/admin/user/update/{id}', [AdminController::class, 'updateUser'])->name('adminUpdateUser');
Route::post('/admin/user/delete/{id}', [AdminController::class, 'deleteUser'])->name('adminDeleteUser');
Route::get('/admin/owner', [AdminController::class, 'collectionOwner'])->name('adminCollectionOwner');
Route::get('/admin/owner/{ownerid}', [AdminController::class, 'getOwner'])->name('adminGetOwner');
Route::post('/admin/owner/update/{ownerid}', [AdminController::class, 'updateOwner'])->name('adminUpdateOwner');
Route::post('/admin/owner/delete/{ownerid}', [AdminController::class, 'deleteOwner'])->name('adminDeleteOwner');
Route::get('/admin/facility', [AdminController::class, 'collectionFacility'])->name('adminFacility');
Route::get('/admin/facility/{id}', [AdminController::class, 'getFacility'])->name('adminGetFacility');
Route::post('/admin/facility/update/{id}', [AdminController::class, 'updateFacility'])->name('adminUpdateFacility');
Route::post('/admin/facility/delete/{id}', [AdminController::class, 'deleteFacility'])->name('adminDeleteFacility');
Route::post('/admin/facility/create', [AdminController::class, 'createFacility'])->name('adminCreateFacility');
Route::get('/admin/property',[AdminController::class, 'collectionProperty'])->name('adminProperty');
Route::post('/admin/property/delete/{id}',[AdminController::class, 'deleteProperty'])->name('adminDeleteProperty');
