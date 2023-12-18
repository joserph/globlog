<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Load;
use App\MasterInvoiceItem;
use App\Company;

class LoadingPlaneController extends Controller
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

        // Buscamos todos los items con id_load actual
        $invoiceItems = MasterInvoiceItem::select('*')
            ->where('id_load', '=', $code)
            ->with('variety')
            ->with('invoiceh')
            ->with('client')
            ->join('farms', 'master_invoice_items.id_farm', '=', 'farms.id')
            ->orderBy('farms.name', 'ASC')
            ->get();
        
        // Buscamos los clientes que esten en esta carga, por el id_load
        $clientsInInvoice = MasterInvoiceItem::where('id_load', '=', $code)
            ->join('clients', 'master_invoice_items.id_client', '=', 'clients.id')
            ->select('clients.id', 'clients.name')
            ->orderBy('clients.name', 'ASC')
            ->get();

        // Eliminamos los clientes duplicados
        $clients = collect(array_unique($clientsInInvoice->toArray(), SORT_REGULAR));
        // Total pieces
        $totalPieces = MasterInvoiceItem::where('id_load', '=', $code)->sum('pieces');

        // Mi empresa
        $company = Company::first();

        return view('loadingplane.index', compact('invoiceItems', 'clientsInInvoice', 'clients', 'load', 'totalPieces', 'company'));
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
        //
    }
}
