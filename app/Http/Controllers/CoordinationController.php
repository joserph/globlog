<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Farm;
use App\Client;
use App\Variety;
use App\Load;
use App\Company;
use App\Coordination;
use App\Http\Requests\CoordinationRequest;
use App\Http\Requests\UpdateCoordinationRequest;
use Barryvdh\DomPDF\Facade as PDF;
use App\Flight;
use App\Marketer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CoordinationImport;

class CoordinationController extends Controller
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
        // Coordinaciones
        $coordinations = Coordination::select('*')
            ->where('id_load', '=', $code)
            ->with('variety')
            ->join('farms', 'coordinations.id_farm', '=', 'farms.id')
            ->select('farms.name', 'coordinations.*')
            ->orderBy('farms.name', 'ASC')
            ->get();
        // Fincas
        $farms = Farm::orderBy('name', 'ASC')->pluck('name', 'id');
        $farmsList = Farm::select('id', 'name', 'tradename')->orderBy('name', 'ASC')->get();
        // Clientes
        $clients = Client::orderBy('name', 'ASC')->pluck('name', 'id');
        $clientsList = Client::select('id', 'name')->orderBy('name', 'ASC')->get();
        
        //dd($clientLists);
        // Variedades
        $varieties = Variety::orderBy('name', 'ASC')->pluck('name', 'id');
        // Comercializadores
        $marketers = Marketer::orderBy('name', 'ASC')->pluck('name', 'id');
        // Empresa
        $company = Company::first();
        // Buscamos los clientes que esten en esta carga, por el id_load
        $clientsCoord = Coordination::where('id_load', '=', $code)
            ->join('clients', 'coordinations.id_client', '=', 'clients.id')
            ->select('clients.id', 'clients.name')
            ->orderBy('clients.name', 'ASC')
            ->get();
        // Eliminamos los clientes duplicados
        $clientsCoordination = collect(array_unique($clientsCoord->toArray(), SORT_REGULAR));

        //dd($coordinations);
        return view('coordination.index', compact('farms', 'clients', 'varieties', 'load', 'company', 'coordinations', 'clientsCoordination', 'farmsList', 'clientsList', 'marketers'));
    }

    public function importExcel(Request $request, $load)
    {
        $file = $request->file('excel_coord');
        //dd($file);
        Excel::import(new CoordinationImport, $file);

        return redirect()->route('coordination.index', $load)
            ->with('status_success', 'Coordinación importada con éxito');
        /* Otro Ejemplo 
        if($request->hasFile('excel_coord'))
        {
            $path = $request->file('excel_coord')->getRealPath();
            $datos = Excel::load($path, function($reader){

            })->get();
            if(!empty($datos) && $datos->count())
            {
                $datos = $datos->toArray();
                for($i = 0; $i < count($datos); $i++)
                {
                    $datosImport[] = $datos[$i];
                }
            }
            dd($path);
        }
        */
        
    }

    public function transferCoordination($load, $request)
    {
        //dd($request);
    }

    public function coordinationExcel($code)
    {
        $url = url()->full();
        $ruc = strpos($url, 'ruc');
        if($ruc == false)
        {
            $ruc = false;
        }else{
            $ruc = true;
        }
        //dd($ruc);
        $load = Load::with('logistic_company')->find($code);
        // CLIENTES
        // Buscamos los clientes que esten en esta carga, por el id_load
        $clientsCoord = Coordination::where('id_load', '=', $code)
            ->join('clients', 'coordinations.id_client', '=', 'clients.id')
            ->select('clients.id', 'clients.name')
            ->orderBy('clients.name', 'ASC')
            ->get();
        // Eliminamos los clientes duplicados
        $clientsDistribution = collect(array_unique($clientsCoord->toArray(), SORT_REGULAR));
        // Coordinaciones
        // $coordinations = Coordination::select('*')
            // ->where('id_load', '=', $code)
            // ->with('variety')
            // ->with('farm')
            // ->join('clients', 'coordinations.id_client', '=', 'clients.id')
            // ->select('clients.name', 'coordinations.*')
            // ->orderBy('clients.name', 'ASC')
            // /*->join('farms', 'distributions.id_farm', '=', 'farms.id')
            // ->select('farms.name', 'distributions.*')
            // ->orderBy('farms.name', 'ASC')*/
            // ->get();
        $coordinations = Coordination::select('*')
            ->where('id_load', '=', $code)
            ->with('variety')
            ->join('clients', 'coordinations.id_client', '=', 'clients.id')
            ->join('farms', 'coordinations.id_farm', '=', 'farms.id')
            ->select('farms.name as farm_name', 'farms.ruc as farm_ruc', 'coordinations.*', 'clients.name as client_name')
            ->orderBy('clients.name', 'ASC')
            ->orderBy('farms.name', 'ASC')
            ->get();
        //dd($coordinations);
        
        $test = Coordination::excel($load, $clientsDistribution, $coordinations, $ruc);
        //dd($test);
    }

    public function coordinationPdf()
    {
        // Busco el ID de la carga por medio de la URL
        $url = $_SERVER["REQUEST_URI"];
        $arr = explode("?", $url);
        $code = $arr[1];
        $load = Load::find($code);

        // Coordinaciones
        $coordinations = Coordination::select('*')
            ->where('id_load', '=', $code)
            ->with('variety')
            ->join('farms', 'coordinations.id_farm', '=', 'farms.id')
            ->select('farms.name', 'coordinations.*')
            ->orderBy('farms.name', 'ASC')
            ->get();

        // Fincas
        $farms = Farm::orderBy('name', 'ASC')->pluck('name', 'id');
        // Clientes
        $clients = Client::orderBy('name', 'ASC')->pluck('name', 'id');
        // Variedades
        $varieties = Variety::orderBy('name', 'ASC')->pluck('name', 'id');

        // Empresa
        $company = Company::first();
        // Buscamos los clientes que esten en esta carga, por el id_load
        $clientsCoord = Coordination::where('id_load', '=', $code)
            ->join('clients', 'coordinations.id_client', '=', 'clients.id')
            ->select('clients.id', 'clients.name')
            ->orderBy('clients.name', 'ASC')
            ->get();
        // Eliminamos los clientes duplicados
        $clientsCoordination = collect(array_unique($clientsCoord->toArray(), SORT_REGULAR));

        //dd('HOLA');
        $coordinationPdf = PDF::loadView('coordination.coordinationPdf', compact(
            'load', 'coordinations', 'company', 'clientsCoordination', 'farms', 'clients', 'varieties'
        ))->setPaper('A4', 'landscape');
        //dd($farmsItemsLoad);
        return $coordinationPdf->stream();
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
    public function store(CoordinationRequest $request)
    {
        // calculo de fulls
        $request['fulls'] = ($request['hb'] * 0.5) + ($request['qb'] * 0.25) + ($request['eb'] * 0.125);
        $request['fulls_r'] = ($request['hb_r'] * 0.5) + ($request['qb_r'] * 0.25) + ($request['eb_r'] * 0.125);
        // calculo de piezas
        $request['pieces'] = $request['hb'] + $request['qb'] + $request['eb'];
        $request['pieces_r'] = $request['hb_r'] + $request['qb_r'] + $request['eb_r'];
        // Faltantes 
        $request['missing'] = $request['pieces'] - $request['pieces_r'];
        
        $coordination = Coordination::create($request->all());

        return redirect()->route('coordination.index', $coordination->id_load)
            ->with('status_success', 'Coordinación guardada con éxito');
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
        //dd($request->all());
        $coordination = Coordination::find($id);

        $data = request()->validate([
            'hawb'          => 'required|unique:coordinations,hawb,' . $coordination->id,
            'pieces'        => '',
            'hb'            => 'required',
            'qb'            => 'required', 
            'eb'            => 'required', 
            'hb_r'          => '',
            'qb_r'          => '',
            'eb_r'          => '',
            'missing'       => '',
            'id_client'     => 'required',
            'id_farm'       => 'required',
            'id_load'       => 'required',
            'variety_id'    => 'required',
            'id_user'       => '',
            'update_user'   => 'required'
        ]);

        // calculo de fulls
        $request['fulls'] = ($request['hb'] * 0.5) + ($request['qb'] * 0.25) + ($request['eb'] * 0.125);
        $request['fulls_r'] = ($request['hb_r'] * 0.5) + ($request['qb_r'] * 0.25) + ($request['eb_r'] * 0.125);
        // calculo de piezas
        $request['pieces'] = $request['hb'] + $request['qb'] + $request['eb'];
        $request['pieces_r'] = $request['hb_r'] + $request['qb_r'] + $request['eb_r'];
        // Faltantes 
        $request['missing'] = $request['pieces'] - $request['pieces_r'];

        $coordination->update($request->all());
        $load = Load::where('id', '=', $coordination->id_load)->first();

        return redirect()->route('coordination.index', $load->id)
            ->with('status_success', 'Item de coordinación editada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coordination = Coordination::find($id);
        $coordination->delete();
        $load = Load::where('id', '=', $coordination->id_load)->first();

        return redirect()->route('coordination.index', $load->id)
            ->with('status_success', 'Coordinación eliminada con éxito');
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        //dd($ids[0]);
        if($ids[0] == "on"){
            $new_ids = array_slice($ids, 1); // Elimino el primer valos del Array.
        }else{
            $new_ids = $ids;
        }
        
        Coordination::whereIn('id', $new_ids)->delete();
        return response()->json(["success" => "Coordinaciones eliminadas"]);
        //
    }
}
