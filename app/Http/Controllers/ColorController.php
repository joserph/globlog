<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Color;
use App\Farm;
use App\Client;
use Illuminate\Support\Facades\Gate;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess', 'color.index');

        $farms = Farm::orderBy('name', 'ASC')->get();
        $clients = Client::orderBy('name', 'ASC')->get();
        $colors = Color::orderBy('type', 'ASC')->paginate(15);
        return view('color.index', compact('colors', 'farms', 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess', 'color.create');

        $farms = Farm::pluck('name', 'id');
        $clients = Client::orderBy('name', 'ASC')->pluck('name', 'id');
        return view('color.create', compact('farms', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('haveaccess', 'color.create');

        $id_type = ($request->farm) ? $request->farm : $request->client;
        $color = Color::create([
            'type' => $request->type,
            'id_type' => $id_type,
            'color' => $request->color,
            'label' => $request->label,
            'id_user' => $request->id_user,
            'update_user' => $request->update_user,
            'load_type' => $request->load_type
        ]);

        return redirect()->route('color.index')
            ->with('status_success', 'Color creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Gate::authorize('haveaccess', 'color.edit');

        $farms = Farm::pluck('name', 'id');
        $clients = Client::pluck('name', 'id');
        $color = Color::find($id);
        return view('color.edit', compact('color', 'farms', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('haveaccess', 'color.edit');

        $color = Color::find($id);

        $id_type = ($request->farm) ? $request->farm : $request->client;
        $color->update([
            'type' => $request->type,
            'id_type' => $id_type,
            'color' => $request->color,
            'label' => $request->label,
            'update_user' => $request->update_user,
            'load_type' => $request->load_type
        ]);

        return redirect()->route('color.index')
            ->with('status_success', 'Color editado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('haveaccess', 'color.destroy');

        $color = Color::find($id);
        $color->delete();

        return redirect()->route('color.index')
            ->with('status_success', 'Color eliminado con éxito');
    }
}
