<?php

namespace App\Http\Livewire;

use App\ItemForInvoice;
use App\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;

class ItemForInvoiceComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap'; /// Importante
    public $view = 'create';
    public $name, $itemforinvoice_id;
    public $term;

    public function render()
    {
        Gate::authorize('haveaccess', 'itemforinvoice'); // cambiar

        return view('livewire.item-for-invoice-component', [
            'itemsforinvoices' => ItemForInvoice::when($this->term, function($query, $term){
                return $query->where('name', 'LIKE', "%$term%");
            })->orderBy('name', 'ASC')->with('user')->paginate(10),
            'users' => User::orderBy('name', 'ASC')->get()
        ]);
    }

    public function store()
    {
        // Validaciones
        $this->validate([
            'name'      => 'required|unique:item_for_invoices,name',
        ]);

        $itemforinvoice = ItemForInvoice::create([
            'name'          => $this->name,
            'id_user'       => Auth::user()->id,
            'update_user'   => Auth::user()->id,
        ]);
        
        session()->flash('create', 'El item "' . $itemforinvoice->name . '" se creó con éxito');

        $this->edit($itemforinvoice->id);
    }

    public function edit($id)
    {
        $itemforinvoice = ItemForInvoice::find($id);

        $this->itemforinvoice_id = $itemforinvoice->id;
        $this->name = $itemforinvoice->name;

        $this->view = 'edit';
    }

    public function update()
    {
        // Validaciones
        $this->validate([
            'name'      => 'required|unique:item_for_invoices,name,' . $this->itemforinvoice_id,
        ]);

        $itemforinvoice = ItemForInvoice::find($this->itemforinvoice_id);

        $itemforinvoice->update([
            'name'          => $this->name,
            'id_user'       => $itemforinvoice->id_user,
            'update_user'   => Auth::user()->id,
        ]);

        session()->flash('edit', 'El item "' . $itemforinvoice->name . '" se actualizó con éxito');
        $this->default();
    }

    public function destroy($id)
    {
        $itemforinvoice = ItemForInvoice::find($id);
        ItemForInvoice::destroy($id);
        session()->flash('delete', 'Eliminaste el item "' . $itemforinvoice->name . '"');
    }

    public function default()
    {
        Gate::authorize('haveaccess', 'farm.index');
        $this->name = '';

        $this->view = 'create';
    }
}
