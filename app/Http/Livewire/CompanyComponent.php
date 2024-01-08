<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Company;
use Auth;

class CompanyComponent extends Component
{
    public $company_id, $name, $phone, $address, $state, $city, $country, $zip_code;
    public $view = 'create';

    public function render()
    {
        return view('livewire.company-component', [
            'companies' => Company::orderBy('id', 'DESC')->paginate(5),
            'company' => Company::first()
        ]);
    }

    public function store()
    {
        // Validaciones
        $this->validate([
            'name'      => 'required',
            'phone'     => 'required',
            'address'   => 'required',
            'state'     => 'required',
            'city'      => 'required',
            'country'   => 'required',
            'zip_code'  => 'required'
        ]);

        $company = Company::create([
            'name'          => $this->name,
            'phone'         => $this->phone,
            'address'       => $this->address,
            'state'         => $this->state,
            'city'          => $this->city,
            'country'       => $this->country,
            'id_user'       => Auth::user()->id,
            'update_user'   => Auth::user()->id,
            'zip_code'      => $this->zip_code
        ]);

        $this->edit($company->id);

        session()->flash('create', 'La empresa "' . $company->name . '" fué creada con éxito');
    }

    public function edit($id)
    {
        $company = Company::find($id);

        $this->company_id = $company->id;
        $this->name = $company->name;
        $this->phone = $company->phone;
        $this->address = $company->address;
        $this->state = $company->state;
        $this->city = $company->city;
        $this->country = $company->country;
        $this->zip_code = $company->zip_code;

        $this->view = 'edit';
    }

    public function update()
    {
        // validaciones
        $this->validate([
            'name'      => 'required',
            'phone'     => 'required',
            'address'   => 'required',
            'state'     => 'required',
            'city'      => 'required',
            'country'   => 'required',
            'zip_code'  => 'required'
        ]);

        $company = Company::find($this->company_id);

        $company->update([
            'name'          => $this->name,
            'phone'         => $this->phone,
            'address'       => $this->address,
            'state'         => $this->state,
            'city'          => $this->city,
            'country'       => $this->country,
            'id_user'       => $company->id_user,
            'update_user'   => Auth::user()->id,
            'zip_code'      => $this->zip_code
        ]);

        session()->flash('edit', 'La empresa "' . $company->name . '" se actualizó con éxito');

        $this->default();
    }

    public function default()
    {
        $this->company_id = '';
        $this->name = '';
        $this->phone = '';
        $this->address = '';
        $this->state = '';
        $this->city = '';
        $this->country = '';
        $this->zip_code = '';

        $this->view = 'create';
    }

    public function destroy($id)
    {
        $company = Company::find($id);
        
        $company->delete();

        session()->flash('delete', 'Eliminaste la empresa');
    }

}
