<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\WelcomeUser;
use App\Jobs\SendWelcomeEmail;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auths.login');
    }
    
    public function showStudentRegisterForm()
    {
        return view('auths.register', [
            'role' => User::ROLE_STUDENT,
            'roleLabel' => 'Student',
        ]);
    }

    public function showStaffRegisterForm()
    {
        return view('auths.register', [
            'role' => User::ROLE_STAFF,
            'roleLabel' => 'Staff',
        ]);
    }

    public function showAdminRegisterForm()
    {
        return view('auths.register', [
            'role' => User::ROLE_ADMIN,
            'roleLabel' => 'Administrator',
        ]);
    }

    //TODO: make the dob filled from the user table by adding dob to users table
    public function registerStudent(RegisterRequest $request)
    {
        $this->registerUserWithRole($request, User::ROLE_STUDENT);
        return redirect()->intended('/');
    }

    public function registerStaff(RegisterRequest $request)
    {
        $this->registerUserWithRole($request, User::ROLE_STAFF);
        return redirect()->intended('/');
    }

    public function registerAdmin(RegisterRequest $request)
    {
        $this->registerUserWithRole($request, User::ROLE_ADMIN);
        return redirect()->intended('/');
    }

    private function registerUserWithRole(RegisterRequest $request, string $role)
    {
        $user = null; // Initialize the $user variable
        // Validate the request data
        $validatedData = $request->validated();

        DB::transaction( function () use ($validatedData, $role, $request) {
            // Create a new user
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'role' => $role
            ]);

            if($request->hasFile('profile_image')) {
                $path = $request->file('profile_image')->store('profile_images', 'public');
                $user->image()->create(['image_path' => $path]);
            }

            if ($user->isStudent()) {
                $user->student()->create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'dob' => now()->subYears(18)->toDateString(), // Set default DOB to 18 years ago
                    'profile_image' => null, // Set default profile image to null
                ]);
            }

            SendWelcomeEmail::dispatch($user);

            $request->session()->regenerate();

            Auth::login($user);

            return $user;
        });
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }
}
