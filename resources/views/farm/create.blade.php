@can('haveaccess', 'farm.create')
<h2>Crear finca</h2>
@include('custom.message') 

@include('farm.form')

<button wire:click="store" class="btn btn-outline-primary" id="createFarm" data-toggle="tooltip" data-placement="top" title="Crear Finca">
    <i class="fas fa-plus-circle"></i> Crear
</button>
@endcan