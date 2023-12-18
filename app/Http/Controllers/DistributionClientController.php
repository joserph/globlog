<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Variety;
use App\Airline;
use App\Flight;
use App\Dae;
use Carbon\Carbon;
use Auth;
use App\User;
use App\Distribution;
use App\Hawb;
use App\Http\Requests\AddDistributionRequest;
use App\Http\Requests\UpdateDistributionRequest;

class DistributionClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Aerolineas
        $airlines = Airline::orderBy('name', 'ASC')->pluck('name', 'id');
        // Vuelo
        $flights_opens = Flight::with('airline')->where('type_awb', '=', 'own')->where('status', '=', 'open')->get();
        // Finca Usuario
        $auth_user = Auth::user();
        $farm_user = User::with('farm')->where('id', $auth_user->id)->first();
        // Coordinaciones de la finca especifica
        $distributions = Distribution::with('farm')->with('client')->with('variety')->with('flight')->where('id_user', $auth_user->id)->get();
        //dd($distributions);
        // Verificar si tiene o no dae en caso de que solo tengamos 1 vuelo habilitado
        if($flights_opens->count() < 2)
        {
            if($flights_opens->count() == 0){
                $message = 'No existen guias de vuelos aperturadas';
                $code = 0;
            }else{
                // Validamos el destino
                $mes = Carbon::parse($flights_opens[0]->date);
                $mes_vuelo = $mes->format('m');
                $anio = Carbon::parse($flights_opens[0]->date);
                $anio_vuelo = $anio->format('Y');
                $dia = Carbon::parse($flights_opens[0]->date);
                $dia_vuelo = $dia->format('d');
                
                // Validamos el año
                $dae_valid = Dae::whereYear('date', $anio_vuelo)
                    ->whereMonth('date', $mes_vuelo)
                    ->whereDay('date', '<=', $dia_vuelo)
                    ->whereDay('arrival_date', '>=', $dia_vuelo)
                    ->where('id_farm', $farm_user->id_farm)
                    ->where('destination_country', $flights_opens[0]->destination_country)
                    ->first();

                if($dae_valid){
                    $message = 'La DAE que tiene activa para este vuelo es: ' . $dae_valid->num_dae;
                    $code = 1;
                }else{
                    $message = 'No tienes DAE para los vuelos activos';
                    $code = 0;
                }
            }
            //dd('Solo 1');
        }else{
            //dd($flights_opens);
            // $mes = Carbon::parse($flights_opens[0]->date);
            // $mes_vuelo = $mes->format('m');
            // $anio = Carbon::parse($flights_opens[0]->date);
            // $anio_vuelo = $anio->format('Y');
            // $dia = Carbon::parse($flights_opens[0]->date);
            // $dia_vuelo = $dia->format('d');

            // $dae_valid = Dae::whereYear('date', $anio_vuelo)
            //     ->whereMonth('date', $mes_vuelo)
            //     ->whereDay('date', '<=', $dia_vuelo)
            //     ->whereDay('arrival_date', '>=', $dia_vuelo)
            //     ->where('id_farm', $farm_user->id_farm)
            //     ->where('destination_country', $flights_opens[0]->destination_country)
            //     ->first();

            // if($dae_valid){
            //     $message = 'La DAE que tiene activa para este vuelo es: ' . $dae_valid->num_dae;
            //     $code = 1;
            // }else{
            //     $message = 'No tienes DAE para los vuelos activos';
            //     $code = 0;
            // }
            $message = 'Verifique vuelo para validar DAE';
            $code = 1;
            //dd($dae_valid);
        }
        
        //dd($flights_opens);
        return view('distribution-client.index', compact('airlines', 'flights_opens', 'message', 'code', 'farm_user', 'distributions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientsList = Client::select('id', 'name')->orderBy('name', 'ASC')->get();
        $varieties = Variety::orderBy('name', 'ASC')->pluck('name', 'id');
        // Vuelos Abiertos
        $flights_opens = Flight::with('airline')->where('type_awb', '=', 'own')->where('status', '=', 'open')->get();

        return view('distribution-client.create', compact('clientsList', 'varieties', 'flights_opens'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddDistributionRequest $request)
    {
        // calculo de fulls
        $request['fulls'] = ($request['hb'] * 0.5) + ($request['qb'] * 0.25) + ($request['eb'] * 0.125);
        $request['fulls_r'] = ($request['hb_r'] * 0.5) + ($request['qb_r'] * 0.25) + ($request['eb_r'] * 0.125);
        // calculo de piezas
        $request['pieces'] = $request['hb'] + $request['qb'] + $request['eb'];
        $request['pieces_r'] = $request['hb_r'] + $request['qb_r'] + $request['eb_r'];
        // Faltantes 
        $request['missing'] = $request['pieces'] - $request['pieces_r'];

        // Guardamos laguia hija en caso de ser Vuelo propio
        $flight = Flight::find($request['id_flight']);
        $hawb_last = Hawb::select('hawb')->get()->last();
        if($flight->type_awb == 'own')
        {
            $new_hawb = (intval($hawb_last->hawb) + 1);
            $hawb_zero = str_pad($new_hawb, 8, "0", STR_PAD_LEFT);
            $uno = substr($hawb_zero, 0, 4);
            $dos = substr($hawb_zero, 4, 8);
            $hawb_format = 'FFC-' . $uno . '-' . $dos;
            $hawb = Hawb::create([
                'hawb'          => $new_hawb,
                'hawb_format'   => $hawb_format,
                'id_user'       => Auth::user()->id,
                'update_user'   => Auth::user()->id,
            ]);
            $request['id_hawb'] = $hawb->id;
            $request['hawb'] = $hawb_format;
        }
        //dd($request);
        $distrubution_client = Distribution::create($request->all());

        return redirect()->route('distribution-client.index')
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
        $distribution = Distribution::find($id);
        $clientsList = Client::select('id', 'name')->orderBy('name', 'ASC')->get();
        $varieties = Variety::orderBy('name', 'ASC')->pluck('name', 'id');
        // Vuelos Abiertos
        $flights_opens = Flight::with('airline')->where('type_awb', '=', 'own')->where('status', '=', 'open')->get();

        return view('distribution-client.edit', compact('distribution', 'clientsList', 'varieties', 'flights_opens'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDistributionRequest $request, $id)
    {
        $distribution = Distribution::find($id);

        $distribution->update($request->all());

        return redirect()->route('distribution-client.index')
            ->with('status_success', 'Coordinación actualizada con éxito');
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
