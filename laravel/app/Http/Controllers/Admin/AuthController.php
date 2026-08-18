<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $creds = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('admin')->attempt($creds, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function profile()
    {
        return view('admin.profile', ['admin' => Auth::guard('admin')->user()]);
    }

    public function updateAccount(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:180|unique:admins,email,' . $admin->id,
        ]);
        $admin->name = $data['name'];
        $admin->email = $data['email'];
        $admin->save();

        return back()->with('success', 'Account details updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $request->validate([
            'current_password' => 'required|string',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Your current password is incorrect.']);
        }

        $admin->password = $request->password; // hashed via model cast
        $admin->save();

        // Keep the session authenticated after password change
        Auth::guard('admin')->logout();
        Auth::guard('admin')->login($admin);
        $request->session()->regenerate();

        return back()->with('success', 'Password changed successfully.');
    }
}
