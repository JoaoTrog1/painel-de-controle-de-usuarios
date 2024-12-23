<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;    

class PainelController extends Controller
{
    public function painel()
    {
        return view("painel.login");
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);
        
        $admin = Admin::where('name', $request->name)->first();

        if ($admin && $admin->password === $request->password) {
            Auth::login($admin);
            return redirect()->route('users.index', ['admin' => $admin->id]);
        }
        
        return redirect()->route('painel')->with(['message' => 'Dados incorretos.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('painel');
    }
}
