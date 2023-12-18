<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Flight;
use App\Distribution;
use App\WeightDistribution;
use App\Http\Requests\FlightRequest;
use App\Airline;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flights = Flight::with('airline')->orderBy('date', 'DESC')->paginate(15);
        //dd($flights);
        return view('flight.index', compact('flights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Aerolineas
        $airlines = Airline::orderBy('name', 'ASC')->pluck('name', 'id');

        return view('flight.create', compact('airlines'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FlightRequest $request)
    {
        $flight = Flight::create($request->all());

        return redirect()->route('flight.index')
            ->with('status_success', 'Vuelo creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $flight = Flight::find($id);
        $distributionCount = Distribution::where('id_flight', '=', $id)->sum('pieces');
        $weightCount = WeightDistribution::where('id_flight', '=', $id)->sum('report_w');
        //dd($distributionCount);
        return view('flight.show', compact('flight', 'distributionCount', 'weightCount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $flight = Flight::find($id);
        // Aerolineas
        $airlines = Airline::orderBy('name', 'ASC')->pluck('name', 'id');

        return view('flight.edit', compact('flight', 'airlines'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FlightRequest $request, $id)
    {
        $flight = Flight::find($id);

        $flight->update($request->all());

        return redirect()->route('flight.index')
            ->with('status_success', 'Vuelo editado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flight = Flight::find($id);
        $flight->delete();

        return redirect()->route('flight.index')
            ->with('status_success', 'Vuelo eliminada con éxito');
    }
}
