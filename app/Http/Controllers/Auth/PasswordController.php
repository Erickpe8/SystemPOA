<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;

class PasswordController extends Controller
{
    /**
     * Verify if the current password is correct
     */
    public function verify(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string']
        ]);

        $isValid = Hash::check(
            $request->current_password,
            $request->user()->password
        );

        return response()->json(['valid' => $isValid]);
    }

    /**
     * Update the user's password
     */
    public function update(Request $request)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        $request->user()->forceFill([
            'password' => Hash::make($validated['password']),
        ])->save();

        return back()->with('status', 'password-updated');
    }
}
