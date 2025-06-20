<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Storage;

class ProveedorController extends Controller {
    public function store(Request $request) {
        $fields = $request->validate([
            'categoria_servicio' => 'required|string',
            'descripcion' => 'required|string',
            'ubicacion' => 'required|string',
            'telefono' => 'required|string',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $path = $request->file('imagen')->store('public/proveedores');
        $url = Storage::url($path);

        $proveedor = Proveedor::create([
            'user_id' => $request->user()->id,
            'categoria_servicio' => $fields['categoria_servicio'],
            'descripcion' => $fields['descripcion'],
            'ubicacion' => $fields['ubicacion'],
            'telefono' => $fields['telefono'],
            'imagen' => $url,
        ]);

        return response()->json($proveedor, 201);
    }

    public function index(Request $request) {
        $query = Proveedor::query();

        if ($request->has('categoria')) {
            $query->where('categoria_servicio', $request->categoria);
        }

        if ($request->has('ubicacion')) {
            $query->where('ubicacion', $request->ubicacion);
        }

        return $query->get();
    }
}
