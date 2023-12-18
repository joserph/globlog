@can('haveaccess', 'farm.edit')
<h2>Editar finca</h2>
@include('custom.message') 
@include('farm.form')

<button type="button" wire:click="update" class="btn btn-outline-warning">
    <i class="fas fa-sync"></i> Actualizar
</button>

<button wire:click="default" class="btn btn-outline-secondary">
    <i class="fas fa-ban"></i> Cancelar
</button>
@endcan