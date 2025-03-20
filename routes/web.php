<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin/login', [AdminController::class, 'loginPage'])->name('admin.login');
Route::post('/admin/login/submit', [AdminController::class, 'loginSubmit'])->name('admin.login.submit');

Route::middleware('auth')->group(function () {
    Route::get('notification', function () {

        return view('notification-test');
    });

    Route::post('/store-device-token', function (Request $request) {
        $request->validate([
            'token' => 'required|string',
        ]);

        auth()->user()->update(['device_token' => $request->token]);

        return response()->json(['success' => true]);
    })->middleware('auth');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/admin/usersAndDeliveries', [UserController::class, 'index'])->name('admin.users.index');               // get all
    Route::get('admin/usersAndDeliveries/create', [UserController::class, 'create'])->name('admin.users.create');       // create
    Route::post('/admin/usersAndDeliveries', [UserController::class, 'store'])->name('admin.users.store');              // store
    Route::get('/admin/usersAndDeliveries/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');     // edit
    Route::get('/admin/usersAndDeliveries/{user}', [UserController::class, 'show'])->name('admin.users.show');          // show
    Route::patch('/admin/usersAndDeliveries/{user}', [UserController::class, 'update'])->name('admin.users.update');    // update
    Route::delete('/admin/usersAndDeliveries/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy'); // destroy
    Route::post('/admin/users/update-verified-status', [UserController::class, 'updateVerifiedStatus'])->name('admin.users.updateVerifiedStatus');
    //logout
    Route::post('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');

});

require __DIR__ . '/auth.php';
