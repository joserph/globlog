<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\LogisticCompany;
use Auth;

class LogisticCompanyComponent extends Component
{
    public $logistic_id, $name, $ruc, $phone, $address, $state, $city, $country, $active;
    public $view = 'create';

    public function render()
    {
        return view('livewire.logistic-company-component', [
            'logistics' => LogisticCompany::orderBy('id', 'DESC')->paginate(5)
        ]);
    }

    public function store()
    {
        // Validacines
        $this->validate([
            'name'      => 'required',
            'ruc'       => 'required',
            'phone'     => 'required|alpha_num',
            'address'   => 'required',
            'state'     => 'required',
            'city'      => 'required',
            'country'   => 'required',
            'active'    => 'required',
        ]);

        // Buscar si hay alguna empresa de logistica activa
        $lc_active = LogisticCompany::select('id')->where('active', '=', 'yes')->first();

        if($lc_active)
        {
            // forzar a guardar en 'NO' para que solo exista una sola empresa de logistica activa
            $this->active = 'no';

            $logistic = LogisticCompany::create([
                'name'          => $this->name,
                'ruc'           => $this->ruc,
                'phone'         => $this->phone,
                'address'       => $this->address,
                'state'         => $this->state,
                'city'          => $this->city,
                'country'       => $this->country,
                'active'        => $this->active,
                'id_user'       => Auth::user()->id,
                'update_user'   => Auth::user()->id
            ]);
            // Mandamos un mensaje para indicar que no se puede colocar como empresa activa
            session()->flash('create', 'La empresa de logística "' . $logistic->name . '" se creo con éxito, pero no se puede colocar como "Cargamos Actualmente" porque hay otra empresa de logística.');
        }else{
            $logistic = LogisticCompany::create([
                'name'          => $this->name,
                'ruc'           => $this->ruc,
                'phone'         => $this->phone,
                'address'       => $this->address,
                'state'         => $this->state,
                'city'          => $this->city,
                'country'       => $this->country,
                'active'        => $this->active,
                'id_user'       => Auth::user()->id,
                'update_user'   => Auth::user()->id
            ]);
    
           session()->flash('create', 'La empresa de logística "' . $logistic->name . '" se creo con éxito');
        }

        $this->edit($logistic->id);
    }

    public function edit($id)
    {
        $logistic = LogisticCompany::find($id);

        $this->logistic_id = $logistic->id;
        $this->name = $logistic->name;
        $this->ruc = $logistic->ruc;
        $this->phone = $logistic->phone;
        $this->address = $logistic->address;
        $this->state = $logistic->state;
        $this->city = $logistic->city;
        $this->country = $logistic->country;
        $this->active = $logistic->active;

        $this->view = 'edit';
    }

    public function update()
    {
        // Validaniones
        $this->validate([
            'name'      => 'required',
            'ruc'       => 'required',
            'phone'     => 'required|alpha_num',
            'address'   => 'required',
            'state'     => 'required',
            'city'      => 'required',
            'country'   => 'required',
            'active'    => 'required',
        ]);
        
        // Buscar la data en la DB
        $logistic = LogisticCompany::find($this->logistic_id);

        // Buscar si hay alguna empresa de logistica activa
        $lc_active = LogisticCompany::select('id')->where('active', '=', 'yes')->first();

        if($lc_active){
            // forzar a guardar en 'NO' para que solo exista una sola empresa de logistica activa
            $this->active = 'no';

            $logistic->update([
                'name'          => $this->name,
                'ruc'           => $this->ruc,
                'phone'         => $this->phone,
                'address'       => $this->address,
                'state'         => $this->state,
                'city'          => $this->city,
                'country'       => $this->country,
                'active'        => $this->active,
                'id_user'       => $logistic->id_user,
                'update_user'   => Auth::user()->id
            ]);
    
            session()->flash('edit', 'La empresa de logística "' . $logistic->name . '" se actualizó con éxito, pero no se puede colocar como "Cargamos Actualmente" porque hay otra empresa de logística.');
        }else{
            $logistic->update([
                'name'          => $this->name,
                'ruc'           => $this->ruc,
                'phone'         => $this->phone,
                'address'       => $this->address,
                'state'         => $this->state,
                'city'          => $this->city,
                'country'       => $this->country,
                'active'        => $this->active,
                'id_user'       => $logistic->id_user,
                'update_user'   => Auth::user()->id
            ]);
    
            session()->flash('edit', 'La empresa de logística "' . $logistic->name . '" se actualizó con éxito');
        }

        $this->default();
    }

    public function default()
    {
        $this->name = '';
        $this->ruc = '';
        $this->phone = '';
        $this->address = '';
        $this->state = '';
        $this->city = '';
        $this->country = '';
        $this->active = '';

        $this->view = 'create';
    }

    public function destroy($id)
    {
        $logistic = LogisticCompany::find($id);

        $logistic->delete();

        session()->flash('delete', 'La empresa de logística se eliminó con éxito');
    }
}
