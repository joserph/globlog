<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Variety;
use Livewire\WithPagination;
use Auth;
use App\User;

class VarietyComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap'; /// Importante

    public $name, $variety_id, $scientific_name;
    public $view = 'create';
    
    public function render()
    {
        return view('livewire.variety-component', [
            'varieties' => Variety::orderBy('name', 'ASC')->with('user')->paginate(10),
            'users' => User::orderBy('name', 'ASC')->get()
        ]);
    }

    public function store()
    {
        // Validaciones
        $this->validate([
            'name'              => 'required',
            'scientific_name'   => 'required'
        ]);

        $variety = Variety::create([
            'name'              => $this->name,
            'scientific_name'   => $this->scientific_name,
            'id_user'           => Auth::user()->id,
            'update_user'       => Auth::user()->id
        ]);

        session()->flash('create', 'La variedad "' . $variety->name . '" se creo con éxito');

        // Madamos a la vista editar
        $this->edit($variety->id);
    }

    public function edit($id)
    {
        $variety = Variety::find($id);

        $this->variety_id = $variety->id;
        $this->name = $variety->name;
        $this->scientific_name = $variety->scientific_name;

        $this->view = 'edit';
    }

    public function update()
    {
        // Validaciones
        $this->validate([
            'name'              => 'required',
            'scientific_name'   => 'required'
        ]);

        $variety = Variety::find($this->variety_id);

        $variety->update([
            'name'              => $this->name,
            'scientific_name'   => $this->scientific_name,
            'id_user'           => Auth::user()->id,
            'update_user'       => Auth::user()->id
        ]);

        session()->flash('edit', 'La Variedad "' . $variety->name . '" se actualizó con éxito');
        // Madamos a la viste default
        $this->default();
    }

    public function default()
    {
        $this->name = '';

        $this->view = 'create';
    }

    public function destroy($id)
    {
        $variety = Variety::find($id);
        Variety::destroy($id);
        session()->flash('delete', 'Eliminaste la variedad "' . $variety->name);
    }
}
