@can('haveaccess', 'itemforinvoice.edit')
<h2>Editar item de la factura</h2>
@include('custom.message') 
@include('itemforinvoice.form')

<button type="button" wire:click="update" class="btn btn-outline-warning">
    <i class="fas fa-sync"></i> Actualizar
</button>

<button wire:click="default" class="btn btn-outline-secondary">
    <i class="fas fa-ban"></i> Cancelar
</button>
@endcan