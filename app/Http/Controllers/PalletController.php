<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Load;
use App\Pallet;
use App\Farm;
use App\Client;
use App\PalletItem;
use App\Coordination;

class PalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Busco el ID de la carga por medio de la URL
        $url = $_SERVER["REQUEST_URI"];
        $arr = explode("?", $url);
        $code = $arr[1];
        $load = Load::find($code);
        
        $pallets = Pallet::where('id_load', '=', $load->id)->orderBy('id', 'DESC')->get();
        
        $last_pallet = Pallet::where('id_load', '=', $load->id)->select('counter')->get()->last();
        //dd($load);
        // Total contenedor
        $total_container = PalletItem::where('id_load', '=', $load->id)->sum('quantity');
        // Total HB
        $total_hb = PalletItem::where('id_load', '=', $load->id)->sum('hb');
        // Total QB
        $total_qb = PalletItem::where('id_load', '=', $load->id)->sum('qb');
        // Total EB
        $total_eb = PalletItem::where('id_load', '=', $load->id)->sum('eb');
        
        if($last_pallet)
        {
            $counter = $last_pallet->counter + 1;
        }else{
            $counter = 1;
        }
        
        $number = $code . '-' . $counter;
        $palletItem = PalletItem::where('id_load', '=', $load->id)
            ->join('clients', 'pallet_items.id_client', '=', 'clients.id')
            ->select('pallet_items.*', 'clients.name')
            ->orderBy('clients.name', 'ASC')
            ->orderBy('pallet_items.farms', 'ASC')
            ->get();
        //$palletItem = PalletItem::where('id_load', '=', $load->id)->orderBy('farms', 'ASC')->get();
        //dd($palletItem);
        // Farms
        $farms = Farm::orderBy('name', 'ASC')->get();
        // Clients
        $clients = Client::orderBy('name', 'ASC')->get();
        //dd($clients);
        $farmsEdit = Farm::orderBy('name', 'ASC')->pluck('name', 'id');

        $resumenCarga = PalletItem::where('id_load', '=', $code)
            ->join('clients', 'pallet_items.id_client', '=', 'clients.id')
            ->select('clients.id', 'clients.name')
            ->orderBy('clients.name', 'ASC')
            ->get();
        // Eliminamos los clientes duplicados
        $resumenCargaAll = collect(array_unique($resumenCarga->toArray(), SORT_REGULAR));
        // Items de carga
        $itemsCargaAll = PalletItem::select('*')
            ->where('id_load', '=', $code)
            ->join('farms', 'pallet_items.id_farm', '=', 'farms.id')
            ->select('farms.name', 'pallet_items.*')
            ->orderBy('farms.name', 'ASC')
            ->get();
        
        $itemsCarga = PalletItem::groupEqualsItemsCargas($itemsCargaAll, $code);
        // Verifico si existe un pallet con la carga actual
        $palletsExist = Pallet::where('id_load', '=', $code)->first();
        $palletsExist2 = Pallet::where([
            ['id_load', '=', $code],
            ['coordination', '=', 'yes'],
        ])->first();

        
        // Buscamos las fincas coordinadas
        $farmCoord = Coordination::where('id_load', $code)->select('id_farm')->get()->toArray();
        // Buscamos los clientes coordinados
        $clientCoord = Coordination::where('id_load', $code)->select('id_client')->get()->toArray();

        if($palletsExist2)
        {
            // Fincas
            $farmsList = Farm::whereIn('id', $farmCoord)->select('id', 'name', 'tradename')->orderBy('name', 'ASC')->get();
            // Clientes
            $clientsList = Client::whereIn('id', $clientCoord)->select('id', 'name')->orderBy('name', 'ASC')->get();
        }else{
            // Fincas
            $farmsList = Farm::select('id', 'name', 'tradename')->orderBy('name', 'ASC')->get();
            // Clientes
            $clientsList = Client::select('id', 'name')->orderBy('name', 'ASC')->get();
        }
        //dd($pallets);

        return view('pallets.index', compact('palletsExist2', 'farmsEdit', 'resumenCargaAll', 'itemsCarga', 'pallets','code', 'farmsList', 'clientsList', 'counter', 'number', 'load', 'palletItem', 'farms', 'clients', 'total_container', 'total_hb', 'total_qb', 'total_eb', 'palletsExist'));
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
        if($request->usda == 'on')
        {
            $request->usda = 1;
        }
        //dd($request->usda);
        $pallet = Pallet::create(
            [
                'id_user' => $request->id_user,
                'update_user' => $request->update_user,
                'id_load' => $request->id_load,
                'number1' => $request->number1,
                'counter' => $request->counter,
                'number' => $request->number,
                'usda' => $request->usda
            ]
        );

        if($request->usda == 1)
        {
            // Buscamos las fincas en coordinaciones
            $fincasCoord = Coordination::where('id_load', $request->id_load)->get();
            // Agregamos las fincas coordinadas
            //dd($fincasCoord);
            foreach($fincasCoord as $item)
            {
                $palletitem = PalletItem::create([
                    'id_user' => \Auth::user()->id,
                    'update_user' => \Auth::user()->id,
                    'id_load' => $item->id_load,
                    'id_pallet' => $pallet->id,
                    'id_farm' => $item->id_farm,
                    'id_client' => $item->id_client,
                    'hb' => 1,
                    'qb' => 0,
                    'eb' => 0,
                    'quantity' => 1,
                    'piso' => null
                ]);
                $farm = Farm::select('name')->where('id', '=', $palletitem->id_farm)->first();
                $palletitem->farms = $farm->name;
                $palletitem->save();
            }
        }

        // Total paleta
        $total_pallet = PalletItem::where('id_pallet', '=', $pallet->id)->sum('quantity');
        //dd($total_pallet);
        $pallet->quantity = $total_pallet;

        if($pallet->usda == 1)
        {
            $id_load = Load::select('shipment')->where('id', '=', $pallet->id_load)->first();
            $pallet->number = $id_load->shipment .'-USDA-' . $pallet->counter;
        }else{
            $pallet->number = $pallet->number . '-' . $pallet->counter;
        }
        $pallet->save();
        $load = Load::where('id', '=', $pallet->id_load)->get();
        
        return redirect()->route('pallets.index', $load[0]->id)
            ->with('info', 'Paleta Guardada con exito');
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
        //dd($request);
        $pallet = Pallet::find($request->id);
        $load = Load::where('id', '=', $pallet->id_load)->first();
        //dd($load);
        if($request->edit_pallet)
        {
            //dd($load);
            // Editamos la paleta (USDA)
            if($request->usda == 'on')
            {
                //$id_load = Load::select('shipment')->where('id', '=', $pallet->id_load)->first();
                $pallet->update([
                    'usda' => 1,
                    'number' => $load->shipment .'-USDA-' . $pallet->counter
                ]);
            }else{
                $pallet->update([
                    'usda' => null,
                    'number' => $load->shipment . '-' . $pallet->counter
                ]);
            }
            
            $pallet->save();

            return redirect()->route('pallets.index', $load->id)
                ->with('status_success', 'Paleta editada con exito');
        }else{
            // Agregamos o quitamos las fincas y clientes coordinados.
            if($request->coordination)
            {
                $pallet->update([
                    'coordination' => 'yes'
                ]);
                $pallet->save();
            }else{
                $pallet->update([
                    'coordination' => 'no'
                ]);
                $pallet->save();
            }

            return redirect()->route('pallets.index', $load->id)
                ->with('status_success', 'Cambio en el uso de finca y clientes');
        }
        
        
        
        

        return redirect()->route('pallets.index', $load[0]->id)
            ->with('info', 'Paleta editada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pallet = Pallet::find($id);
        $pallet->delete();

        $load = Load::where('id', '=', $pallet->id_load)->get();
        
        return redirect()->route('pallets.index', $load[0]->id)
            ->with('info', 'Paleta Eliminada con exito');
    }
}
