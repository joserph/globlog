<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\VarietyFlower;
use App\Variety;

class VaietiesFlowersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess', 'packing.index');

        $varietiesflowers = VarietyFlower::orderBy('name', 'ASC')->with('variety')->paginate(15);
        //dd($varietiesflowers);
        return view('varietiesflowers.index', compact('varietiesflowers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess', 'varietiesflowers.create');

        $vatieties = Variety::pluck('name', 'id');

        return view('varietiesflowers.create', compact('vatieties'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('haveaccess', 'varietiesflowers.create');

        $varietyflower = VarietyFlower::create($request->all());
        $varietyflower->save();   

        return redirect()->route('varietiesflowers.index')
            ->with('status_success', 'Variedad de flor creada con éxito');
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
        Gate::authorize('haveaccess', 'varietiesflowers.edit');

        $varietyflower = VarietyFlower::find($id);
        $vatieties = Variety::pluck('name', 'id');

        return view('varietiesflowers.edit', compact('varietyflower', 'vatieties'));
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
        Gate::authorize('haveaccess', 'varietiesflowers.edit');

        $varietyflower = VarietyFlower::find($id);

        $varietyflower->update($request->all());

        return redirect()->route('varietiesflowers.index')
            ->with('status_success', 'Variedad de flor editada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('haveaccess', 'varietiesflowers.destroy');

        $varietyflower = VarietyFlower::find($id);
        $varietyflower->delete();

        return redirect()->route('varietiesflowers.index')
            ->with('status_success', 'Variedad de flor eliminada con éxito');
    }
}
