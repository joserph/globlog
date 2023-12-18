<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Load;
use App\Http\Requests\AddLoadRequest;
use App\Http\Requests\UpdateLoadRequest;
use App\MasterInvoiceItem;
use App\Coordination;
use App\Pallet;
use App\PalletItem;
use App\LogisticCompany;
use App\QACompany;

class LoadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loads = Load::with('invoiceheader')->orderBy('date', 'DESC')->orderBy('shipment', 'DESC')->paginate(15);
        $coordination = Coordination::join('clients', 'coordinations.id_client', '=', 'clients.id')->select('coordinations.id_load', 'clients.name')->orderBy('name', 'ASC')->distinct()->get(); //72
        $palletItem = PalletItem::get();
        $coordinacions = Coordination::get();
        $logistics_companies = LogisticCompany::select('id', 'name')->get();
        $qacompanies = QACompany::pluck('name', 'id');
        //dd($logistics_companies);
        
        return view('load.index', compact('loads', 'coordination', 'palletItem', 'coordinacions', 'logistics_companies', 'qacompanies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $logistics_companies = LogisticCompany::pluck('name', 'id');
        $qacompanies = QACompany::pluck('name', 'id');
        //dd($logistics_companies);
        return view('load.create', compact('logistics_companies', 'qacompanies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddLoadRequest $request)
    {
        $load = Load::create($request->all());

        return redirect()->route('load.index')
            ->with('status_success', 'Maritimo creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $load = Load::find($id);
        $loadCount = MasterInvoiceItem::where('id_load', '=', $id)->count();
        $farms = MasterInvoiceItem::select('id_farm')->where('id_load', '=', $id)->get();
        $farmsUnique = $farms->unique('id_farm');
        $farmsCount = $farmsUnique->count();
        $coordinationCount = Coordination::where('id_load', '=', $id)->count();
        $palletsCount = Pallet::where('id_load', '=', $id)->count();
        //dd($farmsCount);
        return view('load.show', compact('load', 'loadCount', 'farmsCount', 'coordinationCount', 'palletsCount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $load = Load::find($id);
        $logistics_companies = LogisticCompany::pluck('name', 'id');
        $qacompanies = QACompany::pluck('name', 'id');

        return view('load.edit', compact('load', 'logistics_companies', 'qacompanies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLoadRequest $request, $id)
    {
        $load = Load::find($id);

        $load->update($request->all());

        return redirect()->route('load.index')
            ->with('status_success', 'La carga se actualizó con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $load = Load::find($id);
        $load->delete();

        return redirect()->route('load.index')
            ->with('status_success', 'Carga eliminada con éxito');
    }
}
