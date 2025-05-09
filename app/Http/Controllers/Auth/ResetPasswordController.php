<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use DB;

class ResetPasswordController extends Controller
{
    /** Show the reset password page */
    public function getPassword($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function getEmployeePassword($token)
    {
        return view('auth.passwords.resetemployee', ['token' => $token]);
    }

    /** Update the user's password */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Check if the reset token is valid
        $resetRecord = DB::table('password_resets')->where('email', $request->email)->where('token', $request->token)->first();

        if (!$resetRecord) {
            flash()->error('Invalid token!');
            return back();
        }

        // Update the user’s password
        User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

        $user = User::where('email', $request->email)->first();

        // Remove the reset record
        DB::table('password_resets')->where('email', $request->email)->delete();

        flash()->success('Your password has been changed! :)');
        if ($user->role_name == 'Admin' || $user->role_name == 'Super Admin') {
            return redirect()->route('loginadmin');
        } else {
            return redirect()->route('login');
        }
    }
}