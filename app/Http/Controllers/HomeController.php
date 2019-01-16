<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * USER CRUD
     */
    public function getusers()
    {
        return User::with('roles')->latest()->paginate(10);
    }

    public function storeuser(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:6',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
        ]);

        $user->assignRole($request->role);

        return response()->json($user, 200);
    }

    public function updateuser(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$request->id
        ]);

        $user = User::findOrFail($request->id);

        $updated = $user->update([
            'name'  => $request->name,
            'email' => $request->email
        ]);

        $user->syncRoles($request->selectedroles);

        return response()->json($updated, 200);
    }

    public function deleteuser($id)
    {
        $user = User::findOrFail($id);
        $deleted = $user->delete();

        return response()->json($deleted, 200);
    }
}
