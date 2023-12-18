<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PickUpOrder;
use Illuminate\Support\Facades\Gate;
use App\PickUpOrderItem;

class PickUpOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess', 'pickuporder.index');

        $pickuporders = PickUpOrder::get();
        //dd($pickUpOrders);

        return view('pickuporder.index', compact('pickuporders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess', 'pickuporder.create');

        return view('pickuporder.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('haveaccess', 'pickuporder.create');
        // Busco si existe un Pick Up
        $searchCarrier = PickUpOrder::first();
        //dd($searchCarrier);
        if(empty($searchCarrier))
        {
            $carrier = 15;
            //dd($carrier);
        }else{
            $allPickUpOrder = PickUpOrder::get();
            $searchCarrier = $allPickUpOrder->last();
            //dd($searchCarrier->carrier_num);
            $carrier = $searchCarrier->carrier_num + 1;
        }
        $pickuporder = PickUpOrder::create(
            [
                'date'              => $request->date,
                'loading_date'      => $request->loading_date,
                'loading_hour'      => $request->loading_hour,
                'carrier_company'   => $request->carrier_company,
                'driver_name'       => $request->driver_name,
                'pick_up_location'  => $request->pick_up_location,
                'pick_up_address'   => $request->pick_up_address,
                'city_pu'           => $request->city_pu,
                'state_pu'          => $request->state_pu,
                'zip_code_pu'       => $request->zip_code_pu,
                'country_pu'        => $request->country_pu,
                'consigned_to'      => $request->consigned_to,
                'drop_off_address'  => $request->drop_off_address,
                'city_do'           => $request->city_do,
                'state_do'          => $request->state_do,
                'zip_code_do'       => $request->zip_code_do,
                'country_do'        => $request->country_do,
                'carrier_num'       => $carrier,
                'id_user'           => $request->id_user,
                'update_user'       => $request->update_user
            ]
        );
        
        //dd($pickuporder);

        //$pickuporder = PickUpOrder::create($request->all());

        return redirect()->route('pickuporder.index')
            ->with('status_success', 'Pink Up Order guardado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Gate::authorize('haveaccess', 'pickuporder.show');

        $pickuporder = PickUpOrder::find($id);

        $pickuporderItems = PickUpOrderItem::where('id_pickup', $pickuporder->id)->get();
        //dd($pickuporderItems);
        return view('pickuporder.show', compact('pickuporder', 'pickuporderItems'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Gate::authorize('haveaccess', 'pickuporder.edit');

        $pickuporder = PickUpOrder::find($id);

        return view('pickuporder.edit', compact('pickuporder'));
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
        Gate::authorize('haveaccess', 'pickuporder.edit');

        $pickuporder = PickUpOrder::find($id);
        $pickuporder->update($request->all());

        return redirect()->route('pickuporder.index')
            ->with('status_success', 'Pick up order actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('haveaccess', 'pickuporder.destroy');

        $pickuporder->delete();

        return back()->with('status_success', 'Eliminado correctamente');
    }
}
