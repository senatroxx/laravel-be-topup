<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\PasswordRequest;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function changePassword(PasswordRequest $request)
    {
        $credentials = $request->validated();

        $user = auth('admin-api')->user();
        // Check if the current password is correct
        if (!Hash::check($credentials['current_password'], $user->password)) {
            return Response::status('error')
                ->message("Current password is incorrect.")
                ->result();
        }

        // Update the password
        $user->password = Hash::make($credentials['password']);
        $user->save();

        return Response::status('success')
            ->message("Password successfully updated.")
            ->result();
    }
}
