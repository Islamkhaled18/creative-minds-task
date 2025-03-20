<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

class AdminController extends Controller
{
    public function loginPage()
    {
        return view('admin.login');
    }

    public function loginSubmit(LoginRequest $request)
    {

        if (! auth()->attempt($request->only('mobile_number', 'password'))) {
            return back()->with('status', 'Invalid login details');
        }

        if (auth()->user()->user_type === 'admin') {
            toastr()->success('You are now logged in!');
            return redirect()->route('dashboard');
        }
        toastr()->error('You are not an admin!');
        return redirect()->route('admin.login');
    }

    public function AdminLogout()
    {
        auth()->logout();
        toastr()->error('You are now logged out!');
        return redirect()->route('admin.login');
    }

}
