<?php 
namespace App\Http\Controllers;

use App\Models\ViewData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

use Illuminate\Support\Facades\Artisan;



// if (Auth::check() && Auth::id() == $adminId) {
//     $admin = Admin::findOrFail($adminId);
// }
// return redirect()->route('painel')->with(['message' => 'Acesso negado.']);

class ViewDataController extends Controller
{
    public function index($adminId)
    {
        if (Auth::check() && Auth::id() == $adminId) {
            $admin = Admin::findOrFail($adminId);
            $viewData = ViewData::all();
            $appName = config('app.name'); 
            return view('painel.functions', compact('viewData', 'admin', 'appName'));
        }
        return redirect()->route('painel')->with(['message' => 'Acesso negado.']);
    }

    public function edit($adminId, $id)
    {
        if (Auth::check() && Auth::id() == $adminId) {
            $admin = Admin::findOrFail($adminId);
            $viewData = ViewData::all();
            $editViewData = ViewData::find($id);
            $viewData = ViewData::all();
            $appName = config('app.name'); 
            return view('painel.functions', compact('editViewData', 'viewData', 'admin', 'appName'));
    
        }
        return redirect()->route('painel')->with(['message' => 'Acesso negado.']);
    }

    
    public function delete($adminId, $id)
    {
        if (Auth::check() && Auth::id() == $adminId) {
            ViewData::find($id)->delete();
            return redirect()->route('painel.functions.index', $adminId)->with('status', 'Função deletada com sucesso');
    
        }
        return redirect()->route('painel')->with(['message' => 'Acesso negado.']);
    
    }

    public function store(Request $request, $adminId)
    {
        if (Auth::check() && Auth::id() == $adminId) {
            $request->validate([
                'type' => 'required|string',
                'content' => 'required|string',
                'link' => 'nullable|url',
                'min' => 'nullable|integer',
                'max' => 'nullable|integer',
            ]);

            $data = ViewData::updateOrCreate(
                ['id' => $request->id],
                [
                    'type' => $request->type,
                    'content' => $request->content,
                    'link' => $request->link ?? null,
                    'min' => $request->min ?? 0,
                    'max' => $request->max ?? 100,
                ]
            );
            return redirect()->route('painel.functions.index', $adminId)->with('status', 'Função salva com sucesso');
        }
        return redirect()->route('painel')->with(['message' => 'Acesso negado.']);

    }


    public function getAllFunctions()
    {
        $viewData = ViewData::all();
        $appName = config('app.name'); 

        return response()->json([
            'app_name' => $appName,
            'data' => $viewData,
        ]);
    }


    public function updateAppName(Request $request, $adminId)
    {
        if (Auth::check() && Auth::id() == $adminId) {
            $newAppName = $request->name;

            $path = base_path('.env');

            if (file_exists($path)) {
                $envContents = file_get_contents($path);

                // Garante que o padrão "APP_NAME=" existe antes de substituir
                if (preg_match('/^APP_NAME=.*$/m', $envContents)) {
                    $newEnvContents = preg_replace(
                        '/^APP_NAME=.*$/m',
                        "APP_NAME=\"{$newAppName}\"",
                        $envContents
                    );
                } else {
                    $newEnvContents = $envContents . PHP_EOL . "APP_NAME=\"{$newAppName}\"";
                }

                file_put_contents($path, $newEnvContents);
            } else {
                return response()->json(['error' => '.env file not found'], 404);
            }

            return redirect()->route('painel.functions.index', $adminId)->with('status', 'Nome salvo com sucesso');
        }
        return redirect()->route('painel')->with(['message' => 'Acesso negado.']);
    }



}
