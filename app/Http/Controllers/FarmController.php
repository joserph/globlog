<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PalletItem;
use App\Farm;
use Illuminate\Support\Facades\DB;

class FarmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Traer las cargas maritimas asociadas a la finca
        $pallet_items = PalletItem::where('id_farm', $id)->with('client')->get();
        $farmInPallet = DB::table('loads')
            ->join('pallet_items', 'pallet_items.id_load', '=', 'loads.id')
            //->join('logistic_companies', 'logistic_companies.id', '=', 'loads.id_logistic_company')
            ->where('pallet_items.id_farm', '=', $id)
            ->select('pallet_items.*', 'loads.bl', 'loads.date as load_date')
            ->orderBy('loads.date', 'ASC')
            ->get();
        // la finca
        $farm = Farm::find($id);
        dd($farmInPallet);
        return view('farm.show', compact('farmInPallet', 'farm'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
