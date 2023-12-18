<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterInvoiceItem;
use Auth;
use App\Load;
use App\InvoiceHeader;
use App\Http\Requests\AddMasterInvoiceItemRequest;
use App\Http\Requests\UpdateMarterInvoiceItemRequest;
use App\PalletItem;
use App\Coordination;

class MasterInvoiceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $invoiceItems = MasterInvoiceItem::with('farm')->with('variety')->get();
        dd($invoiceItems);
        return $invoiceItems;
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

    public function generarMasterPallet($load)
    {
        // Buscamos la información agregadas en los pallets
        $itemsCargaAll = PalletItem::select('*')
        ->where('id_load', '=', $load)
        ->join('farms', 'pallet_items.id_farm', '=', 'farms.id')
        ->select('farms.name', 'pallet_items.*')
        ->orderBy('farms.name', 'ASC')
        ->get();
        // Eliminanos los duplicados
        $itemsCarga = PalletItem::groupEqualsItemsCargas($itemsCargaAll, $load);
        // Buscamos la Invoice Header
        $invoiceHeader = InvoiceHeader::where('id_load', $load)->first();
        
        //dd($itemsCarga);
        foreach($itemsCarga as $item)
        {
            // Buscamos informacion de las corrdinaciones.
            $infoCoor = Coordination::where([
                ['id_farm', '=', $item['id_farm']],
                ['id_client', '=', $item['id_client']],
                ['id_load', '=', $load],
            ])->select('hawb', 'variety_id')->first();
            
            $masterInvoiceItems = MasterInvoiceItem::create(
                [
                    'id_invoiceh'       => $invoiceHeader->id,
                    'id_client'         => $item['id_client'],
                    'id_farm'           => $item['id_farm'],
                    'id_load'           => $load,
                    'variety_id'        => $infoCoor->variety_id,
                    'hawb'              => $infoCoor->hawb,
                    'pieces'            => $item['quantity'],
                    'hb'                => $item['hb'],
                    'qb'                => $item['qb'],
                    'eb'                => $item['eb'],
                    'stems'             => 10,
                    'price'             => 0.01,
                    'bunches'           => 1,
                    'fulls'             => ($item['hb'] * 0.5) + ($item['qb'] * 0.25) + ($item['eb'] * 0.125),    
                    'total'             => (10 * 0.01),
                    'id_user'           => Auth::user()->id,
                    'update_user'       => Auth::user()->id,
                    'stems_p_bunches'   => 25,
                    'fa_cl_de'          => $item['id_farm'] . '-' . $item['id_client'] . '-' . $infoCoor->variety_id,
                    'client_confim_id'  => $item['id_client']
                ]
            );
        }
        // Actualizamos los totales en la table Invoice Header
        $fulls = MasterInvoiceItem::select('fulls')->where('id_load', '=', $load)->sum('fulls');
        $bunches = MasterInvoiceItem::select('bunches')->where('id_load', '=', $load)->sum('bunches');
        $pieces = MasterInvoiceItem::select('pieces')->where('id_load', '=', $load)->sum('pieces');
        $stems = MasterInvoiceItem::select('stems')->where('id_load', '=', $load)->sum('stems');
        $total_t = MasterInvoiceItem::select('total')->where('id_load', '=', $load)->sum('total');
        $invoiceHeader = InvoiceHeader::find($invoiceHeader->id);
        //dd($invoiceHeader);
        $invoiceHeader->update([
            'total_fulls'   => $fulls,
            'total_bunches' => $bunches,
            'total_pieces'  => $pieces,
            'total_stems'   => $stems,
            'total'         => $total_t
        ]);

        return redirect()->route('masterinvoices.index', $load)
            ->with('status_success', 'Se agregarón las fincas Paletizadas');
        
    }    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddMasterInvoiceItemRequest $request)
    {
        // Carga
        //dd($request->id_invoiceh);
        //dd($request->bunches);
        if(!$request->client_confim_id)
        {
            $request->client_confim_id = $request->id_client;
        }
        
        $masterInvoiceHeader = MasterInvoiceItem::create([
            'id_invoiceh'       => $request->id_invoiceh,
            'id_client'         => $request->id_client,
            'id_farm'           => $request->id_farm,
            'id_load'           => $request->id_load,
            'variety_id'        => $request->variety_id,
            'hawb'              => $request->hawb,
            'pieces'            => $request->pieces,
            'hb'                => $request->hb,
            'qb'                => $request->qb,
            'eb'                => $request->eb ,
            'stems'             => $request->stems,
            'price'             => $request->price,
            'bunches'           => $request->bunches,
            'fulls'             => $request->fulls,    
            'total'             => $request->total,
            'id_user'           => $request->id_user,
            'update_user'       => $request->update_user,
            'stems_p_bunches'   => $request->stems_p_bunches,
            'fa_cl_de'          => $request->fa_cl_de,
            'client_confim_id'  => $request->client_confim_id
        ]);
        // Actualizamos los totales en la table Invoice Header
        $fulls = MasterInvoiceItem::select('fulls')->where('id_load', '=', $masterInvoiceHeader->id_load)->sum('fulls');
        $bunches = MasterInvoiceItem::select('bunches')->where('id_load', '=', $masterInvoiceHeader->id_load)->sum('bunches');
        $pieces = MasterInvoiceItem::select('pieces')->where('id_load', '=', $masterInvoiceHeader->id_load)->sum('pieces');
        $stems = MasterInvoiceItem::select('stems')->where('id_load', '=', $masterInvoiceHeader->id_load)->sum('stems');
        $total_t = MasterInvoiceItem::select('total')->where('id_load', '=', $masterInvoiceHeader->id_load)->sum('total');
        $invoiceHeader = InvoiceHeader::find($masterInvoiceHeader->id_invoiceh);
        $invoiceHeader->update([
            'total_fulls'   => $fulls,
            'total_bunches' => $bunches,
            'total_pieces'  => $pieces,
            'total_stems'   => $stems,
            'total'         => $total_t
        ]);
        return;
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
        $invoiceItems = MasterInvoiceItem::findOrFail($id);

        return $invoiceItems;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMarterInvoiceItemRequest $request, $id)
    {
        $masterInvoiceItem = MasterInvoiceItem::find($id);
        // Calculo de los total de piezas.
        //$pieces = $request->hb + $request->qb + $request->eb;
        // Calculo de los fulls.
        //$fulls = ($request->hb * 0.50) + ($request->qb * 0.25) + ($request->eb * 0.125);
        //$fa_cl_de_ = $request->id_farm . '-' . $request->id_client . '-' . $request->variety_id;
        //$total = $request->stems * $request->price;

        $masterInvoiceItem->update([
            'id_invoiceh'       => $request->id_invoiceh,
            'id_client'         => $request->id_client,
            'id_farm'           => $request->id_farm,
            'id_load'           => $request->id_load,
            'variety_id'        => $request->variety_id,
            'hawb'              => $request->hawb,
            'pieces'            => $request->pieces,
            'hb'                => $request->hb,
            'qb'                => $request->qb,
            'eb'                => $request->eb,
            'stems'             => $request->stems,
            'price'             => $request->price,
            'bunches'           => $request->bunches,
            'fulls'             => $request->fulls,    
            'total'             => $request->total,
            'update_user'       => $request->update_user,
            'stems_p_bunches'   => $request->stems_p_bunches,
            'fa_cl_de'          => $request->fa_cl_de,
            'client_confim_id'  => $request->client_confim_id
        ]);

        // Actualizamos los totales en la table Invoice Header
        $fulls = MasterInvoiceItem::select('fulls')->where('id_load', '=', $masterInvoiceItem->id_load)->sum('fulls');
        $bunches = MasterInvoiceItem::select('bunches')->where('id_load', '=', $masterInvoiceItem->id_load)->sum('bunches');
        $pieces = MasterInvoiceItem::select('pieces')->where('id_load', '=', $masterInvoiceItem->id_load)->sum('pieces');
        $stems = MasterInvoiceItem::select('stems')->where('id_load', '=', $masterInvoiceItem->id_load)->sum('stems');
        $total_t = MasterInvoiceItem::select('total')->where('id_load', '=', $masterInvoiceItem->id_load)->sum('total');
        $invoiceHeader = InvoiceHeader::find($masterInvoiceItem->id_invoiceh);
        $invoiceHeader->update([
            'total_fulls'   => $fulls,
            'total_bunches' => $bunches,
            'total_pieces'  => $pieces,
            'total_stems'   => $stems,
            'total'         => $total_t
        ]);
        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoiceItems = MasterInvoiceItem::findOrFail($id);
        $invoiceItems->delete();
    }
}
