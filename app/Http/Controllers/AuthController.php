<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect based on role
            if (Auth::user()->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }
            
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'Invalid Email Or Password',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Generate 6-digit OTP
        $otp = sprintf("%06d", mt_rand(1, 999999));

        // Save registration data temporarily in session
        Session::put('registration_data', [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        Session::put('registration_otp', $otp);

        // Send OTP email
        try {
            Mail::to($request->email)->send(new \App\Mail\VerifyOtpMail($otp, $request->name));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('OTP Email failed: ' . $e->getMessage());
        }

        return redirect()->route('verify.otp')->with('success', 'OTP sent to your email! Please verify to complete registration.');
    }

    public function showVerifyOtp()
    {
        if (!Session::has('registration_data')) {
            return redirect()->route('register')->withErrors(['email' => 'Session expired. Please register again.']);
        }
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $sessionOtp = Session::get('registration_otp');
        $registrationData = Session::get('registration_data');

        if (!$sessionOtp || !$registrationData) {
            return redirect()->route('register')->withErrors(['email' => 'Session expired. Please register again.']);
        }

        if ($request->otp !== (string)$sessionOtp) {
            return back()->withErrors(['otp' => 'Invalid OTP entered. Please try again.']);
        }

        // OTP is correct! Create user
        $user = User::create([
            'name' => $registrationData['name'],
            'email' => $registrationData['email'],
            'phone' => $registrationData['phone'],
            'password' => $registrationData['password'],
        ]);

        // Clear Session
        Session::forget(['registration_data', 'registration_otp']);

        // Log in the user automatically
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Account verified and created successfully!');
    }

    public function resendOtp()
    {
        $registrationData = Session::get('registration_data');
        if (!$registrationData) {
            return redirect()->route('register')->withErrors(['email' => 'Session expired. Please register again.']);
        }

        // Generate new 6-digit OTP
        $otp = sprintf("%06d", mt_rand(1, 999999));
        Session::put('registration_otp', $otp);

        // Send new OTP email
        try {
            Mail::to($registrationData['email'])->send(new \App\Mail\VerifyOtpMail($otp, $registrationData['name']));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Resend OTP Email failed: ' . $e->getMessage());
        }

        return back()->with('success', 'A new OTP has been sent successfully.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
