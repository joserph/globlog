@can('haveaccess', 'company.create')
<h2>Crear Empresa</h2>
@include('custom.message') 

@include('company.form')

@if(!$company)
    <button wire:click="store" class="btn btn-outline-primary" id="createCompany" data-toggle="tooltip" data-placement="top" title="Crear Empresa">
        <i class="fas fa-plus-circle"></i> Crear
    </button>
@endif
@endcan