<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Tipo;

class TipoController extends Controller
{
    public function show($id)
    {
        $tipo = Tipo::findOrFail($id);
    }

    public function index()
    {
        $tipos = Tipo::all();
        return view('tipos.index', compact('tipos'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'nombre_tipo' => 'required',
                'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
    
            $tipo = new Tipo;
            $tipo->nombre_tipo = $request->nombre_tipo;
    
            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $tipo->imagen = $imageName;
            }
    
            $tipo->save();
            return redirect()->back()->with('success', 'Dato agregado exitosamente.');
        }
    
        $tipos = Tipo::all();
        return view('tipos.create', compact('tipos'));
    }
    
    public function destroy($id)
    {
        $tipo = Tipo::findOrFail($id);
        $tipo->delete();
        return redirect()->back()->with('delete_success', 'Dato eliminado exitosamente.');
    }
}
