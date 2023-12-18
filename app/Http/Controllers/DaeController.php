<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dae;
use App\Farm;
use App\Http\Requests\DaeRequest;

class DaeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $daes = Dae::with('farm')->orderBy('date', 'ASC')->paginate(15);
        //dd($daes);
        return view('dae.index', compact('daes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $farmsList = Farm::select('id', 'name', 'tradename')->orderBy('name', 'ASC')->get();

        return view('dae.create', compact('farmsList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DaeRequest $request)
    {
        Dae::create($request->all());

        return redirect()->route('dae.index')
            ->with('status_success', 'DAE agregada con éxito');
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
        $dae = Dae::find($id);
        $farmsList = Farm::select('id', 'name', 'tradename')->orderBy('name', 'ASC')->get();

        return view('dae.edit', compact('farmsList', 'dae'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DaeRequest $request, $id)
    {
        $dae = Dae::find($id);
        $dae->update($request->all());

        return redirect()->route('dae.index')
            ->with('status_success', 'DAE editada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dae = Dae::find($id);
        $dae->delete();

        return redirect()->route('dae.index')
            ->with('status_success', 'DAE eliminada con éxito');
    }
}
