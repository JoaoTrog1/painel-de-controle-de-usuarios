<?php


namespace App\Http\Controllers;

use App\Models\AppModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AppController extends Controller
{

    public function showApp()
    {
        return response()->json(AppModel::find(1)->only(['nome', 'f1', 'f2', 'comando']));
    }


    
    public function showCreateForm($adminId)
    {
        if (Auth::check() && Auth::id() == $adminId) {
            return view('painel.app', ['action' => route('app.store'), 'method' => 'POST', 'data' => null]);
        }
        return redirect()->route('painel')->with(['message' => 'Acesso negado.']);
    }


    public function showEditForm($adminId, $id)
    {
        if (Auth::check() && Auth::id() == $adminId) {
            $admin = Admin::find($adminId);
            $app = AppModel::findOrFail($id);
            return view('painel.app', [
                'action' => route('app.update', ['admin' => $admin->id, 'id' => $id]),
                'method' => 'PUT',
                'data' => $app,
                'admin' => $admin,
            ]);
        }
        return redirect()->route('painel')->with(['message' => 'Acesso negado.']);
    }

    public function store(Request $request, $adminId)
    {
        if (Auth::check() && Auth::id() == $adminId) {
            $data = $request->validate([
                'nome' => 'required|string|max:255',
                'f1' => 'required|string|max:255',
                'f2' => 'required|string|max:255',
                'comando' => 'required|string|max:255',
            ]);
    
            AppModel::create($data);
            return redirect()->route('app.create');
        }
        return redirect()->route('painel')->with(['message' => 'Acesso negado.']);
        
    }

    // Atualiza os dados existentes
    public function update(Request $request, $adminId, $id)
    {
        if (Auth::check() && Auth::id() == $adminId) {
            $admin = Admin::find($adminId);
            $data = $request->validate([
                'nome' => 'required|string|max:255',
                'f1' => 'required|string|max:255',
                'f2' => 'required|string|max:255',
                'comando' => 'required|string|max:255',
            ]);
    
            $app = AppModel::findOrFail($id);
            $app->update($data);
            return redirect()->route('app.edit', ['admin' => $admin->id, 'id' => $id]);
        }
        return redirect()->route('painel')->with(['message' => 'Acesso negado.']);
       
    }
}
