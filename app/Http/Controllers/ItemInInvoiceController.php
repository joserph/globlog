<?php

namespace App\Http\Controllers;

use App\ItemInInvoice;
use Illuminate\Http\Request;
use App\Http\Requests\ItemInInvoiceRequest;
use App\Invoice;

class ItemInInvoiceController extends Controller
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
    public function store(ItemInInvoiceRequest $request)
    {
        $item_in_invoice = ItemInInvoice::create($request->all());
        // actualizamos totales de la cabecera
        $total_pieces = ItemInInvoice::select('pieces')->where('invoice_id', $item_in_invoice->invoice_id)->sum('pieces');
        $total_quantity = ItemInInvoice::select('quantity')->where('invoice_id', $item_in_invoice->invoice_id)->sum('quantity');
        $total_amount = ItemInInvoice::select('amount')->where('invoice_id', $item_in_invoice->invoice_id)->sum('amount');
        $invoice = Invoice::find($item_in_invoice->invoice_id);

        $invoice->update([
            'total_pieces'      => $total_pieces,
            'total_quantity'    => $total_quantity,
            'total_amount'      => $total_amount
        ]);

        return redirect()->route('invoices.show', $item_in_invoice->invoice_id)
            ->with('status_success', 'Item creado con éxito');
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
    public function update(ItemInInvoiceRequest $request, $id)
    {
        $item_in_invoice = ItemInInvoice::find($id);
        $item_in_invoice->update($request->all());

        // actualizamos totales de la cabecera
        $total_pieces = ItemInInvoice::select('pieces')->where('invoice_id', $item_in_invoice->invoice_id)->sum('pieces');
        $total_quantity = ItemInInvoice::select('quantity')->where('invoice_id', $item_in_invoice->invoice_id)->sum('quantity');
        $total_amount = ItemInInvoice::select('amount')->where('invoice_id', $item_in_invoice->invoice_id)->sum('amount');
        $invoice = Invoice::find($item_in_invoice->invoice_id);

        $invoice->update([
            'total_pieces'      => $total_pieces,
            'total_quantity'    => $total_quantity,
            'total_amount'      => $total_amount
        ]);

        return redirect()->route('invoices.show', $item_in_invoice->invoice_id)
            ->with('status_success', 'Item actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item_in_invoice = ItemInInvoice::find($id);
        $item_in_invoice->delete();

        return redirect()->route('invoices.show', $item_in_invoice->invoice_id)
            ->with('status_success', 'Item eliminado con éxito');
    }
}
