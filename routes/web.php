<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\Auth\LoginController;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Cookie;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Route::post('/logout', function () {
//     Auth::logout();
//     if (Auth::viaRemember()) {
//         dd(Cookie::forget('remember_web_'.config('app.name')));
//         return redirect('/login')->withCookie(Cookie::forget('remember_web_'.config('app.name')));
//     } else {
//         return redirect('/login');
//     }
// })->name('logout');

Route::group(['middleware' => 'auth.logout'], function () {
    // Các route mà chỉ người dùng đã đăng xuất mới có thể truy cập vào
    Route::resource('/medicine', MedicineController::class);
Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');
Route::resource('/invoice', InvoiceController::class);
Route::post('/medicine/search', [MedicineController::class, 'searchMedicine'])->name('medicine.search');
Route::resource('/statistic',StatisticController::class);
route::get('/import', function (){return view('imports.index');});
Route::get('/import/{import_date}', function ($importDate) {
    $imports = \App\Models\Import::whereDate('import_date', $importDate)->get();
    return view('imports.show', compact('imports', 'importDate'));
})->name('imports.show');
});
