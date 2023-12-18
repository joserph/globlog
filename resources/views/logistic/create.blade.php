@can('haveaccess', 'logistic.create')
<h2>Crear Empresa de logística</h2>
@include('custom.message') 

@include('logistic.form')

<button wire:click="store" class="btn btn-outline-primary" id="createLogistic" data-toggle="tooltip" data-placement="top" title="Crear Empresa">
    <i class="fas fa-plus-circle"></i> Crear
</button>
@endcan