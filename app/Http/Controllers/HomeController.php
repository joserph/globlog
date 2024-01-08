<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Farm;
use App\Client;
use App\Variety;
use App\Load;
use App\Flight;
use App\Company;
use App\LogisticCompany;
use App\Color;
use App\Marketer;
use App\Packing;
use App\VarietyFlower;
use App\QACompany;
use App\Dae;
use App\Airline;
use App\Invoice;
use App\ItemForInvoice;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $farms = Farm::count();
        $clients = Client::count();
        $varieties = Variety::count();
        $loads = Load::count();
        $flights = Flight::count();
        $company = Company::count();
        $companyName = Company::get();
        $logisticCompany = LogisticCompany::count();
        $logisticCompanyName = LogisticCompany::get();
        $colors = Color::count();
        $marketers = Marketer::count();
        $packings = Packing::count();
        $varietiesflowers = VarietyFlower::count();
        $qacampanies = QACompany::count();
        $daes = Dae::count();
        $airlines = Airline::count();
        $invoices = Invoice::count();
        $itemsforinvoices = ItemForInvoice::count();
        //dd($companyName[0]->name);
        return view('home', compact(
            'farms', 
            'varietiesflowers', 
            'clients', 
            'varieties', 
            'loads', 
            'flights', 
            'company', 
            'companyName', 
            'logisticCompany', 
            'logisticCompanyName', 
            'colors', 
            'marketers', 
            'packings',
            'qacampanies',
            'daes',
            'airlines',
            'invoices',
            'itemsforinvoices'));
    }

    public function clientExcel()
    {
        Client::excel();
    }
}
