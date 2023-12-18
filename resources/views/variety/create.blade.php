@can('haveaccess', 'variety.create')
<h2>Crear tipo de variedad</h2>
@include('custom.message') 

@include('variety.form')

<button wire:click="store" class="btn btn-outline-primary" id="createVariety" data-toggle="tooltip" data-placement="top" title="Crear variedad">
    <i class="fas fa-plus-circle"></i> Crear
</button>
@endcan