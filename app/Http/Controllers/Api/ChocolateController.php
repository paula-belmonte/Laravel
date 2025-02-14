<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chocolate;
use App\Models\Tipo;
use Illuminate\Http\Request;

class ChocolateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Chocolate::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de entrada
       // $request->validate([
         //   'nombre' => 'required|string|max:255',
           // 'marca' => 'required|string|max:255',
           // 'porcentaje' => 'required|numeric',
           // 'codigotipo' => 'required|exists:tipos,codigo', // Verificar que codigotipo exista en tipos
       // ]);

        // Crear chocolate
        $chocolate = Chocolate::create($request->all());
        return response()->json($chocolate, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Chocolate $chocolate)
    {
        return $chocolate;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chocolate $chocolate)
    {
        // Validación de entrada
       // $request->validate([
         //   'nombre' => 'required|string|max:255',
         //   'marca' => 'required|string|max:255',
         //   'porcentaje' => 'required|numeric',
         //   'codigotipo' => 'required|exists:tipos,codigo',
       // ]);

        // Actualizar chocolate
        $chocolate->update($request->all());
        return response()->json($chocolate);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chocolate $chocolate)
    {
        $chocolate->delete();
        return response()->json(null, 204);
    }
}
