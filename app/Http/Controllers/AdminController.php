<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function createAdmin(Request $request)
    {
        $admin = Admin::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Admin created successfully', 'admin' => $admin]);
    }

    public function createUser(Request $request, $adminId)
    {
        $admin = Admin::findOrFail($adminId);

        $user = $admin->users()->create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User created successfully', 'user' => $user]);
    }
}
