<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Packing;
use Illuminate\Support\Facades\Gate;

class PackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess', 'packing.index');

        $packings = Packing::orderBy('description', 'ASC')->paginate(10);

        return view('packing.index', compact('packings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess', 'packing.create');

        return view('packing.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('haveaccess', 'packing.create');

        $packing = Packing::create($request->all());
        $packing->save();   

        return redirect()->route('packing.index')
            ->with('status_success', 'Observación Empaque con éxito');
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
        Gate::authorize('haveaccess', 'packing.edit');

        $packing = Packing::find($id);

        return view('packing.edit', compact('packing'));
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
        Gate::authorize('haveaccess', 'packing.edit');

        $packing = Packing::find($id);

        $packing->update($request->all());

        return redirect()->route('packing.index')
            ->with('status_success', 'Observación Empaque editada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('haveaccess', 'packing.destroy');

        $packing = Packing::find($id);
        $packing->delete();

        return redirect()->route('packing.index')
            ->with('status_success', 'Observación Empaque eliminada con éxito');
    }
}
