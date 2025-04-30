<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\department;
use App\Models\Employee;
use App\Models\TypeJob;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Session;
use Auth;
use DB;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'locked', 'unlock']);
    }

    /** Display the login page */
    public function loginadmin()
    {
        return view('auth.loginadmin');
    }


    public function login()
    {
        $employee = Employee::with(
            'contact',
            'governmentIds',
            'familyInfo',
            'education',
            'employment',
            'children',
            'user',
            'jobDetails.department',
            'jobDetails.position' // Load both department and position through jobDetails
        )->get();

        $userList = User::all();
        $departments = department::all();
        $typeJobs = TypeJob::all();

        if ($employee->isEmpty() || $userList->isEmpty() || $departments->isEmpty() || $typeJobs->isEmpty()) {
            abort(404); // Laravel's built-in 404 error
        }

        return view('auth.login', compact('employee', 'userList', 'departments', 'typeJobs'));
    }

    /** Authenticate user and redirect */
    public function authenticate(Request $request)
    {
        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $credentials = $request->only('email', 'password') + ['status' => 'Active'];

            // Attempt to login with the provided credentials
            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                // Check if user has an allowed role
                if (!in_array($user->role_name, ['Admin', 'Super Admin'])) {
                    // If the user is not Admin or Super Admin, log them out and return an error
                    Auth::logout();
                    flash()->error('Unauthorized access: Invalid role.');
                    return redirect()->back();
                }

                Session::put($this->getUserSessionData($user));

                // Update last login
                $user->update(['last_login' => Carbon::now()]);

                flash()->success('Login successfully :)');
                // Redirect to appropriate dashboard based on the role
                if ($user->role_name == 'Employee') {
                    return redirect()->route('em/dashboard'); // Redirect to employee dashboard
                } elseif (in_array($user->role_name, ['Admin', 'Super Admin'])) {
                    return redirect()->route('home'); // Redirect to admin home
                } else {
                    return redirect()->intended('home'); // Default fallback
                }
            }

            flash()->error('Wrong Username or Password');
            return redirect()->back();
        } catch (\Exception $e) {
            \Log::info($e);
            flash()->error('Login failed. Please try again.');
            return redirect()->back();
        }
    }


    public function authenticateEmployee(Request $request)
    {
        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $credentials = $request->only('email', 'password') + ['status' => 'Active'];

            // Attempt to login with the provided credentials
            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                // Check if the user is an 'Employee'
                if ($user->role_name != 'Employee') {
                    // If the role is not 'Employee', log them out and return an error
                    Auth::logout();
                    flash()->error('Unauthorized access: Invalid role.');
                    return redirect()->back();
                }

                // Proceed with the session and last login update
                Session::put($this->getUserSessionData($user));

                // Update last login
                $user->update(['last_login' => Carbon::now()]);

                flash()->success('Login successfully :)');
                return redirect()->route('em/dashboard'); // Redirect to employee dashboard
            }

            flash()->error('Wrong Username or Password');
            return redirect()->back();
        } catch (\Exception $e) {
            \Log::info($e);
            flash()->error('Login failed. Please try again.');
            return redirect()->back();
        }
    }



    /** Prepare User Session Data */
    private function getUserSessionData($user)
    {
        return [
            'name'                => $user->name,
            'email'               => $user->email,
            'user_id'             => $user->user_id,
            'join_date'           => $user->join_date,
            'phone_number'        => $user->phone_number,
            'status'              => $user->status,
            'role_name'           => $user->role_name,
            'avatar'              => $user->avatar,
            'position'            => $user->position,
            'department'          => $user->department,
            'line_manager'        => $user->line_manager,
            'second_line_manager' => $user->second_line_manager,
        ];
    }

    /** Logout and clear session */
    public function logout(Request $request)
    {
        $user = Auth::user();
        $request->session()->flush();
        Auth::logout();
        flash()->success('Logout successfully :)');
        if ($user && in_array($user->role_name, ['Admin', 'Super Admin'])) {
            return redirect()->route('loginadmin'); // admin login route
        } else {
            return redirect()->route('login'); // employee login route
        }
    }
}
