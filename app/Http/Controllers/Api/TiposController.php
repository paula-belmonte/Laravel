<?php

namespace App\Http\Controllers\Api;

use App\Models\Tipo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TiposController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Tipo::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tipo = Tipo::create($request->all());
	return response()->json($tipo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tipo $tipo)
    {
        return $tipo;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tipo $tipo)
    {
        $tipo->update($request->all());
	return response()->json($tipo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tipo $tipo)
    {
        $tipo->delete();
	return response()->json(null, 204);
    }
}
