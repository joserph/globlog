<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterInvoiceItem;
use App\Load;
use Barryvdh\DomPDF\Facade as PDF;
use App\LogisticCompany;
use App\Company;

class ISFController extends Controller
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
        

        $loadCount = MasterInvoiceItem::where('id_load', '=', $code)
            ->with('variety')
            ->with('invoiceh')
            ->with('client')
            ->join('farms', 'master_invoice_items.id_farm', '=', 'farms.id')
            ->select('farms.*')
            ->orderBy('farms.name', 'ASC')
            ->get();

        //

        $farmsItemsLoad = $loadCount->unique('id');
        //dd($code);
        return view('isf.index', compact('farmsItemsLoad', 'code', 'load'));
    }

    public function isfPdf()
    {
        // Busco el ID de la carga por medio de la URL
        $url = $_SERVER["REQUEST_URI"];
        $arr = explode("?", $url);
        $code = $arr[1];
        $load = Load::find($code);

        $loadCount = MasterInvoiceItem::where('id_load', '=', $code)
            ->with('variety')
            ->with('invoiceh')
            ->with('client')
            ->join('farms', 'master_invoice_items.id_farm', '=', 'farms.id')
            ->select('farms.*')
            ->orderBy('farms.name', 'ASC')
            ->get();


        $farmsItemsLoad = $loadCount->unique('id');

        $isfPdf = PDF::loadView('isf.isfPdf', compact(
            'load',
            'farmsItemsLoad'
        ))->setPaper('A4', 'landscape');
        //dd($farmsItemsLoad);
        return $isfPdf->stream();
    }

    public function isf10_2Pdf(){
        // Busco el ID de la carga por medio de la URL
        $url = $_SERVER["REQUEST_URI"];
        $arr = explode("?", $url);
        $code = $arr[1];
        $load = Load::find($code);
        $logistic_company = LogisticCompany::where('active', 'yes')->first();
        $my_company = Company::first();
        //dd($logistic_company);

        $isf10_2Pdf = PDF::loadView('isf.isf10_2Pdf', compact(
            'load',
            'logistic_company',
            'my_company'
        ))->setPaper('A4');
        //dd($farmsItemsLoad);
        return $isf10_2Pdf->stream();
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
