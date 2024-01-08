<?php

namespace App\Http\Controllers;

use App\Client;
use App\Company;
use App\Flight;
use App\Invoice;
use App\ItemForInvoice;
use App\ItemInInvoice;
use App\Load;
use Illuminate\Http\Request;
use App\Http\Requests\InvoiceRequest;
use Barryvdh\DomPDF\Facade as PDF;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::orderBy('num_invoice', 'DESC')->paginate(10);

        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::orderBy('name', 'ASC')->pluck('name', 'id');
        $loads = Load::orderBy('bl', 'ASC')->pluck('bl', 'id');
        $flights = Flight::orderBy('awb', 'ASC')->pluck('awb', 'id');
        return view('invoices.create', compact('clients', 'loads', 'flights'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceRequest $request)
    {
        // Buscamos el ultimo valor de la variable Count
        $last_count = Invoice::select('count')->latest()->first();
        
        // if($last_count){
        //     $request['count'] = $last_count->count + 1;
        //     // dd($last_count->count);
        // }else{
        //     $request['count'] = 1;
        //     // dd($last_count);
        // }
        $request['count'] = ($last_count) ? ($last_count->count + 1) : 1;
        $left_count = str_pad($request['count'], 6, "0", STR_PAD_LEFT); 
        
        $request['num_invoice'] = 'GL' . date('Y', strtotime($request['date'])) . '-' . $left_count;
        //dd($request->all());
        $invoice = Invoice::create($request->all());

        return redirect()->route('invoices.show', $invoice->id)
            ->with('status_success', 'Cabecera de factura creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::find($id);
        $my_company = Company::first();
        $client = Client::find($invoice->client_id);
        $type_load = ($invoice->load_id) ? 'BL' : 'AWB';
        if($invoice->load_id)
        {
            $load_info = Load::find($invoice->load_id);
            $load = $load_info->bl;
        }else{
            $flight_info = Flight::find($invoice->flight_id);
            $load = $flight_info->awb;
        }
        $descriptions = ItemForInvoice::pluck('name', 'id');
        $items = ItemInInvoice::where('invoice_id', $id)->with('description')->orderBy('id', 'DESC')->get();
        // dd($items);
        return view('invoices.show', compact('invoice', 'my_company', 'client', 'type_load', 'load', 'descriptions', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::find($id);
        $clients = Client::orderBy('name', 'ASC')->pluck('name', 'id');
        $loads = Load::orderBy('bl', 'ASC')->pluck('bl', 'id');
        $flights = Flight::orderBy('awb', 'ASC')->pluck('awb', 'id');

        return view('invoices.edit', compact('invoice', 'clients', 'loads', 'flights'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InvoiceRequest $request, $id)
    {
        $invoice = Invoice::find($id);
        $invoice->update($request->all());

        return redirect()->route('invoices.index')
            ->with('status_success', 'Cabecera de factura editada con éxito');
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

    public function invoicePdf($id)
    {
        $invoice = Invoice::find($id);
        $my_company = Company::first();
        $client = Client::find($invoice->client_id);
        if($invoice->load_id)
        {
            $load_info = Load::find($invoice->load_id);
            $load = $load_info->bl;
        }else{
            $flight_info = Flight::find($invoice->flight_id);
            $load = $flight_info->awb;
        }
        $itemsInvoice = ItemInInvoice::where('invoice_id', $invoice->id)->get();
        // dd($client);
        $coordinationPdf = PDF::loadView('invoices.partials.invoicePdf', compact(
            'invoice', 'my_company', 'client', 'load', 'itemsInvoice'
        ));
        //dd($farmsItemsLoad);
        return $coordinationPdf->stream();
    }
}
