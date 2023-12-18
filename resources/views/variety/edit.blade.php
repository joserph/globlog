@can('haveaccess', 'variety.edit')
<h2>Editar tipo de variedad</h2>
@include('custom.message') 
@include('variety.form')

<button type="button" wire:click="update" class="btn btn-outline-warning">
    <i class="fas fa-sync"></i> Actualizar
</button>

<button wire:click="default" class="btn btn-outline-secondary">
    <i class="fas fa-ban"></i> Cancelar
</button>
@endcan