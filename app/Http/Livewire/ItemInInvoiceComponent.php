<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\ItemInInvoice;

class ItemInInvoiceComponent extends Component
{
    public function render()
    {
        return view('livewire.item-in-invoice-component', [
            'items' => ItemInInvoice::orderBy('id', 'DESC')->get(),
        ]);
    }
}
