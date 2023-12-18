<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Farm;
use App\User;
use Auth;
use Illuminate\Support\Facades\Gate;

class FarmComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap'; /// Importante

    public $farm_id, $name, $tradename, $phone, $address, $state, $city, $country, $ruc;
    public $view = 'create';
    public $term;

    public function render()
    {
        Gate::authorize('haveaccess', 'farms');
        
        // Mostramos todos los registros 
        return view('livewire.farm-component', [
            'farms' => Farm::when($this->term, function($query, $term){
                return $query->where('name', 'LIKE', "%$term%")
                ->orWhere('tradename', 'LIKE', "%$term%")
                ->orWhere('address', 'LIKE', "%$term%")
                ->orWhere('state', 'LIKE', "%$term%")
                ->orWhere('city', 'LIKE', "%$term%")
                ->orWhere('ruc', 'LIKE', "%$term%")
                ->orWhere('country', 'LIKE', "%$term%");
            })->orderBy('name', 'ASC')->with('user')->paginate(10),
            'users' => User::orderBy('name', 'ASC')->get()
        ]);
    }

    public function store()
    {
        // Validaciones
        $this->validate([
            'name'      => 'required|unique:farms,name',
            'tradename' => 'required|unique:farms,tradename',
            'phone'     => 'required',
            'address'   => 'required',
            'state'     => 'required',
            'city'      => 'required',
            'country'   => 'required',
            'ruc'       => 'required|unique:farms,ruc'
        ]);

        $farm = Farm::create([
            'name'          => $this->name,
            'tradename'     => $this->tradename,
            'phone'         => $this->phone,
            'address'       => $this->address,
            'state'         => $this->state,
            'city'          => $this->city,
            'country'       => $this->country,
            'id_user'       => Auth::user()->id,
            'update_user'   => Auth::user()->id,
            'ruc'           => $this->ruc
        ]);
        
        session()->flash('create', 'La finca "' . $farm->name . '" se creó con éxito');

        $this->edit($farm->id);
    }

    public function edit($id)
    {
        $farm = Farm::find($id);

        $this->farm_id = $farm->id;
        $this->name = $farm->name;
        $this->tradename = $farm->tradename;
        $this->phone = $farm->phone;
        $this->address = $farm->address;
        $this->state = $farm->state;
        $this->city = $farm->city;
        $this->country = $farm->country;
        $this->ruc = $farm->ruc;

        $this->view = 'edit';
    }

    public function update()
    {
        // Validaciones
        $this->validate([
            'name'      => 'required|unique:farms,name,' . $this->farm_id,
            'tradename' => 'required|unique:farms,tradename,' . $this->farm_id,
            'phone'     => 'required',
            'address'   => 'required',
            'state'     => 'required',
            'city'      => 'required',
            'country'   => 'required',
            'ruc'       => 'required|unique:farms,ruc,' . $this->farm_id
        ]);

        $farm = Farm::find($this->farm_id);

        $farm->update([
            'name'          => $this->name,
            'tradename'     => $this->tradename,
            'phone'         => $this->phone,
            'address'       => $this->address,
            'state'         => $this->state,
            'city'          => $this->city,
            'country'       => $this->country,
            'id_user'       => $farm->id_user,
            'update_user'   => Auth::user()->id,
            'ruc'           => $this->ruc
        ]);

        session()->flash('edit', 'La finca "' . $farm->name . '" se actualizó con éxito');
        $this->default();
    }

    public function destroy($id)
    {
        $farm = Farm::find($id);
        Farm::destroy($id);
        session()->flash('delete', 'Eliminaste la finca "' . $farm->name . '"');
    }

    public function default()
    {
        Gate::authorize('haveaccess', 'farm.index');
        $this->name = '';
        $this->tradename = '';
        $this->phone = '';
        $this->address = '';
        $this->state = '';
        $this->city = '';
        $this->country = '';
        $this->ruc = '';

        $this->view = 'create';
    }
}
