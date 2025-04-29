<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Hash;
use DB;

class RegisterController extends Controller
{
    /** Show the registration page */
    public function register()
    {
        return view('auth.register');
    }

    /** Store New User */
    public function storeUser(Request $request)
    {
        try {
            // Create an instance of the User model
            $users = new User();
            // Call the saveNewuser method
            return $users->saveNewuser($request);
            flash()->success('Account created successfully :)');
            return redirect('/login/hr/lgu/admins/cuyapo');
        } catch (\Exception $e) {
            \Log::error($e);
            flash()->error('Failed to Create Account. Please try again.');
            return redirect()->back();
        }
    }

    public function checkSuperAdmin()
    {
        $exists = User::where('role_name', 'Super Admin')->exists();
        return response()->json(['super_admin_exists' => $exists]);
    }

    public function checkEmailUser(Request $request)
    {
        $emailExists = User::where('email', $request->email)->exists();
        return response()->json(['exists' => $emailExists]);
    }
}
