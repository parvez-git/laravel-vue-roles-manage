<?php

namespace App\Http\Controllers;

use App\User;
use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function uploadProfilePicture(Request $request)
    {
        if ($request->hasFile('image')) {
            $profile = str_slug(auth()->user()->name).'-'.auth()->id().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images/profile'), $profile);
        }

        User::where('id', auth()->id())->update(['profile_picture' => $profile]);

        return response()->json([
            'profile' => $profile,
            'message' => 'Image uploaded successfully.'
        ]);
    }
}
