<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Load;
use App\Sketch;
use App\Pallet;
use App\PalletItem;
use App\Farm;
use App\Client;
use Illuminate\Support\Collection;
use App\SketchPercent;
use App\Color;

class SketchController extends Controller
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

        // Buscamos si existe los espacios en la DB.
        $position24 = Sketch::where('id_load', '=', $load->id)->where('space', '>', '0')->get()->last();
        $space = $position24 ? 1 : 0;

        // Buscamos las paletas de la carga actual.
        $pallets = Pallet::where('id_load', $load->id)->get();

        // Buscamos las paletas ya guardadas
        $palletSave = Sketch::where('id_load', $load->id)->select('id_pallet')->get();
        
        $palletSaveArray = array();
        foreach($palletSave as $key => $item)
        {
            if($item->id_pallet)
            {
                $palletSaveArray[] = $item->id_pallet;
            }
        }
        //
        // Pallets para select
        $palletsSelect = Pallet::where('id_load', $load->id)->pluck('number', 'id')->except($palletSaveArray);
        // Sketch
        $sketches = Sketch::where('id_load', $load->id)->with('pallet')->get();
        // PalletItems
        $palletsItems = PalletItem::where('id_load', '=', $load->id)->with('client')->get();
        //dd($pallets);
        // Farms
        $farms = Farm::all();
        // Clients
        $clients = Client::all();
        // Porcentaje
        $sketchPercent = SketchPercent::where('id_load', $load->id)->with('client')->get();
        // Colores de los clientes
        $colors = Color::where('type', 'client')->get();
        //dd($sketches);
        return view('sketches.index', compact('clients', 'load', 'farms', 'pallets', 'sketches', 'space', 'palletsSelect', 'palletsItems', 'sketchPercent', 'colors'));
    }

    public static function testView() {
        return "Hello World!";
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
        if($request->quantity)
        {
            
            // Generar espacios
            $id_load = Load::select('id')->where('id', '=', $request->id_load)->get();

            // Generamos los porcentajes
            PalletItem::createSketchPercent($id_load[0]->id);

            for($i = 1; $i <= $request->quantity; $i++)
            {
                $sketch = new Sketch();
                $sketch->id_load = $id_load[0]->id;
                $sketch->space = $i;
                $sketch->id_user = $request->id_user;
                $sketch->update_user = $request->update_user;
                $sketch->save();
            }
            $load = Load::where('id', '=', $sketch->id_load)->get();

            

            return redirect()->route('sketches.index', $load[0]->id)
                ->with('status_success', 'Se generarón ' . $sketch->space . ' espacios con éxito');

        }else{
            //dd($request->id_pallet);
            // Editar espacio.
            $currentSpace = Sketch::find($request->id);

            if($request->id_pallet)
            {
                $currentSpace->update([
                    'space' => $currentSpace->space,
                    'id_pallet' => $request->id_pallet,
                    'id_load' => $currentSpace->id_load,
                    'id_user' => $currentSpace->id_user,
                    'update_user' => $request->update_user
                ]);
            }else{
                $currentSpace->update([
                    'space' => $currentSpace->space,
                    'id_pallet' => $request->id_pallet,
                    'id_load' => $currentSpace->id_load,
                    'id_user' => $currentSpace->id_user,
                    'update_user' => $request->update_user
                ]);
            }
            
            $load = Load::where('id', '=', $currentSpace->id_load)->get();

            return redirect()->route('sketches.index', $load[0]->id)
            ->with('status_success', 'Espacio agregado con éxito');
        }
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
        // Eliminar los espacios
        $allSpaces = Sketch::where('id_load', $id)->get();
        foreach($allSpaces as $space)
        {
            $spaceDelete = Sketch::find($space->id);
            $spaceDelete->delete();
        }
        // Eliminar los porcentajes
        $allPercent = SketchPercent::where('id_load', $id)->get();
        foreach($allPercent as $percent)
        {
            $percentDelete = SketchPercent::find($percent->id);
            $percentDelete->delete();
        }

        return redirect()->route('sketches.index', $id)
            ->with('info', 'Espacios revertidos');
    }
}
