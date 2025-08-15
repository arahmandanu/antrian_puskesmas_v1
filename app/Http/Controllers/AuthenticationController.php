<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    /**
     * Display a login page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle the login request.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        Auth::attempt($request->only('email', 'password'));

        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        flash('Invalid credentials.')->error();
        return redirect()->back();
    }

    /**
     * Logout the user.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
