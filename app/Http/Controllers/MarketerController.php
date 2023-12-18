<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Marketer;
use Illuminate\Support\Facades\Gate;

class MarketerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess', 'marketer.index');

        $marketers = Marketer::paginate(10);

        return view('marketer.index', compact('marketers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess', 'marketer.create');

        return view('marketer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('haveaccess', 'marketer.create');

        $marketer = Marketer::create($request->all());
        $marketer->save();

        return redirect()->route('marketer.index')
            ->with('status_success', 'Comercializadora creada con éxito');
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
        Gate::authorize('haveaccess', 'marketer.edit');

        $marketer = Marketer::find($id);

        return view('marketer.edit', compact('marketer'));
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
        Gate::authorize('haveaccess', 'marketer.edit');

        $marketer = Marketer::find($id);

        $marketer->update($request->all());

        return redirect()->route('marketer.index')
            ->with('status_success', 'Comercializadora editada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('haveaccess', 'marketer.destroy');

        $marketer = Marketer::find($id);
        $marketer->delete();

        return redirect()->route('marketer.index')
            ->with('status_success', 'Comercializadora eliminada con éxito');
    }
}
