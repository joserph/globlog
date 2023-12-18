@can('haveaccess', 'client.create')
<h2>Crear cliente</h2>
@include('custom.message') 

@include('client.form')

<button wire:click="store" class="btn btn-outline-primary" id="createClient" data-toggle="tooltip" data-placement="top" title="Crear Cliente">
    <i class="fas fa-plus-circle"></i> Crear
</button>
@endcan