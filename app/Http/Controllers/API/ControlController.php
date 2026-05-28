<?php

namespace App\Http\Controllers\API;

use App\Models\Control;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ControlController extends Controller
{
    public function index()
    {
        $controles = Control::with('departamento')->get();

        return response()->json([
            'success' => true,
            'data' => $controles
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'codigo' => 'required|string|max:50|unique:controles,codigo',

            'id_depa' => 'required|exists:departamentos,id'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $control = Control::create([

            'codigo' => $request->codigo,

            'id_depa' => $request->id_depa

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Control registrado correctamente',
            'data' => $control
        ], 201);
    }
    public function show(string $id)
    {
        $control = Control::with('departamento')->find($id);

        if (!$control) {

            return response()->json([
                'success' => false,
                'message' => 'Control no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $control
        ], 200);
    }
    public function update(Request $request, string $id)
    {
        $control = Control::find($id);

        if (!$control) {

            return response()->json([
                'success' => false,
                'message' => 'Control no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [

            'codigo' => 'required|string|max:50',

            'id_depa' => 'required|exists:departamentos,id'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $control->update([

            'codigo' => $request->codigo,

            'id_depa' => $request->id_depa

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Control actualizado correctamente',
            'data' => $control
        ], 200);
    }
    public function destroy(string $id)
    {
        $control = Control::find($id);

        if (!$control) {

            return response()->json([
                'success' => false,
                'message' => 'Control no encontrado'
            ], 404);
        }

        $control->delete();

        return response()->json([
            'success' => true,
            'message' => 'Control eliminado correctamente'
        ], 200);
    }
}