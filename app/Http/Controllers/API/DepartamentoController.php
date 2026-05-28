<?php

namespace App\Http\Controllers\API;

use App\Models\Departamento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DepartamentoController extends Controller
{

    public function index()
    {
        $departamentos = Departamento::all();

        return response()->json([
            'success' => true,
            'data' => $departamentos
        ], 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'depa' => 'required|string|max:20|unique:departamentos,depa',

            'codigo' => 'required|string|max:20|unique:departamentos,codigo',

            'moroso' => 'required|boolean'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $departamento = Departamento::create([

            'depa' => $request->depa,

            'codigo' => $request->codigo,

            'moroso' => $request->moroso

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Departamento registrado correctamente',
            'data' => $departamento
        ], 201);
    }

    public function show(string $id)
    {
        $departamento = Departamento::find($id);

        if (!$departamento) {

            return response()->json([
                'success' => false,
                'message' => 'Departamento no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $departamento
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $departamento = Departamento::find($id);

        if (!$departamento) {

            return response()->json([
                'success' => false,
                'message' => 'Departamento no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [

            'depa' => 'required|string|max:20',

            'codigo' => 'required|string|max:20',

            'moroso' => 'required|boolean'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $departamento->update([

            'depa' => $request->depa,

            'codigo' => $request->codigo,

            'moroso' => $request->moroso

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Departamento actualizado correctamente',
            'data' => $departamento
        ], 200);
    }

    public function destroy(string $id)
    {
        $departamento = Departamento::find($id);

        if (!$departamento) {

            return response()->json([
                'success' => false,
                'message' => 'Departamento no encontrado'
            ], 404);
        }

        $departamento->delete();

        return response()->json([
            'success' => true,
            'message' => 'Departamento eliminado correctamente'
        ], 200);
    }
}