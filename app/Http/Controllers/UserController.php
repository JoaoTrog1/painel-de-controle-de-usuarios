<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $adminId)
    {
        if (Auth::check() && Auth::id() == $adminId) {
            $admin = Admin::find($adminId);
            $users = User::where('admin_id', $adminId)
                        ->when($request->search, function ($query) use ($request) {
                            return $query->where('name', 'like', '%' . $request->search . '%');
                        })
                        ->get();

            return view('painel.users', compact('users', 'admin'));
        }
        return redirect()->route('painel')->with(['message' => 'Acesso negado.']);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($adminId)
    {
        if (Auth::check() && Auth::id() == $adminId) {
            $admin = Admin::findOrFail($adminId);
            return view('painel.user', compact('admin'));
        }
        return redirect()->route('painel')->with(['message' => 'Acesso negado.']);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $adminId)
    {
        if (Auth::check() && Auth::id() == $adminId) {
            $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:users', 'regex:/^[a-zA-Z0-9]+$/'],
                'password' => 'required|string|max:255',
                'validade' => 'required|date',
            ]);
        
            User::create([
                'name' => $request->name,
                'password' => $request->password,
                'validade' => $request->validade,
                'admin_id' => $adminId, 
                'uid' => null,
            ]);
            return redirect()->route('users.create', $adminId)->with('success', 'User created successfully!');
        
        }
        return redirect()->route('painel')->with(['message' => 'Acesso negado.']);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($admin, $id)
    {
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($adminId, $id)
    {
        if (Auth::check() && Auth::id() == $adminId) {
            $admin = Admin::findOrFail($adminId);

            $user = User::where('id', $id)->where('admin_id', $admin->id)->firstOrFail();
    
            return view('painel.edit', compact('user', 'admin'));
        
        }
        return redirect()->route('painel')->with(['message' => 'Acesso negado.']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $adminId, $id)
    {
        if (Auth::check() && Auth::id() == $adminId) {
            $admin = Admin::findOrFail($adminId);
            $user = User::where('id', $id)->where('admin_id', $admin->id)->firstOrFail();
            $rules = [
                'password' => 'nullable|string', 
                'validade' => 'nullable|date',
            ];
    
            $request->validate($rules);
    
            $data = $request->only('password', 'validade');
    
            if (isset($data['password']) && !empty($data['password'])) {
                $data['password'] = $data['password'];
            } else {
                unset($data['password']);
            }
    
            if (isset($data['validade']) && empty($data['validade'])) {
                unset($data['validade']);
            }
    
            $user->update($data);
    
            return redirect()->route('users.index', $admin->id)->with('success', 'User updated successfully!');
        
        }
        return redirect()->route('painel')->with(['message' => 'Acesso negado.']);
    }


    public function reset($adminId, $id)
    {
        if (Auth::check() && Auth::id() == $adminId) {
            $admin = Admin::findOrFail($adminId);
            $user = User::where('id', $id)->where('admin_id', $admin->id)->firstOrFail();
    
            $user->update(['uid' => null]);

            return redirect()->route('users.index', $admin->id)->with('success', 'User updated successfully!');
        }
        return redirect()->route('painel')->with(['message' => 'Acesso negado.']);
    }
    



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($adminId, $id)
    {
        if (Auth::check() && Auth::id() == $adminId) {
            $item = User::findOrFail($id); 
            $item->delete();
            return redirect()->route('users.index', $adminId)->with('success', 'Item excluído com sucesso!');
        }
        return redirect()->route('painel')->with(['message' => 'Acesso negado.']);
    }
}
