<?php

namespace App\Http\Controllers;

use App\Models\UsuarioEstudiante;
use Illuminate\Http\Request;

class UsuarioEstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = UsuarioEstudiante::all();
        return response()->json(($usuarios));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UsuarioEstudiante $usuarioEstudiante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UsuarioEstudiante $usuarioEstudiante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UsuarioEstudiante $usuarioEstudiante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UsuarioEstudiante $usuarioEstudiante)
    {
        //
    }
}
