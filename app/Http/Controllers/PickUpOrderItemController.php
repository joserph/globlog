<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\PickUpOrderItem;
use App\PickUpOrder;
use Barryvdh\DomPDF\Facade as PDF;

class PickUpOrderItemController extends Controller
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

    public function pickuporderPdf($id_pickup)
    {   
        $headpickup = PickUpOrder::find($id_pickup);

        $pickupitem = PickUpOrderItem::where('id_pickup', $id_pickup)->get();
        //dd($pickupitem);
        $pickuporderPdf = PDF::loadView('pickuporderItem.pickuporderPdf', compact(
            'headpickup', 'pickupitem'
        ))->setPaper('A4');

        return $pickuporderPdf->stream();
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
        Gate::authorize('haveaccess', 'pickuporderitem.create');

        $pickuporderitem = PickUpOrderItem::create($request->all());

        return redirect()->route('pickuporder.show', $pickuporderitem->id_pickup)
            ->with('status_success', 'Pink Up Order Item guardado con éxito');
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
        Gate::authorize('haveaccess', 'pickuporderitem.edit');

        $pickuporderitem = PickUpOrderItem::find($id);

        $pickuporderitem->update($request->all());

        return redirect()->route('pickuporder.show', $pickuporderitem->id_pickup)
            ->with('status_success', 'Pink Up Order Item actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pickuporderitem = PickUpOrderItem::find($id);

        $pickuporder = PickUpOrder::find($pickuporderitem->id_pickup);

        $pickuporderitem->delete();

        return redirect()->route('pickuporder.show', $pickuporder->id)
            ->with('status_success', 'Pink Up Order Item Eliminado con éxito');
    }
}
