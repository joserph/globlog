<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QACompany;
use App\Http\Requests\QACompanyRequest;

class QACompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $qa_companies = QACompany::paginate(10);

        return view('qacompany.index', compact('qa_companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('qacompany.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QACompanyRequest $request)
    {
        $qa_company = QACompany::create($request->all());

        return redirect()->route('qacompany.index')
            ->with('status_success', 'Empresa QA agregada con éxito');
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
        $qacompany = QACompany::find($id);

        return view('qacompany.edit', compact('qacompany'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QACompanyRequest $request, $id)
    {
        $qacompany = QACompany::find($id);
        $qacompany->update($request->all());

        return redirect()->route('qacompany.index')
            ->with('status_success', 'Empresa QA actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $qacompany = QACompany::find($id);
        $qacompany->delete();

        return redirect()->route('qacompany.index')
            ->with('status_success', 'Empresa QA eliminada con éxito');
    }
}
