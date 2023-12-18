@can('haveaccess', 'masterinvoice.edit')
<h2>Editar Factura Master</h2>
@include('custom.message') 
@include('masterinvoice.formHeader')

<button type="button" wire:click="update" class="btn btn-outline-warning">
    <i class="fas fa-sync"></i> Actualizar
</button>

<button wire:click="default" class="btn btn-outline-secondary">
    <i class="fas fa-ban"></i> Cancelar
</button>
@endcan