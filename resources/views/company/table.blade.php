@can('haveaccess', 'company.index')
<h2>Mi Empresa</h2>
<div class="table-responsive">
   <table class="table table-sm table-hover">
    <thead>
       <tr>
          <th scope="col">Nombre</th>
          <th scope="col">Teléfono</th>
          <th scope="col">Dirección</th>
          <th scope="col">Estado</th>
          <th scope="col">Ciudad</th>
          <th scope="col">País</th>
          <th class="text-center" colspan="2">@can('haveaccess', 'company.edit') Editar @endcan  @can('haveaccess', 'company.destroy')/ Eliminar @endcan</th>
       </tr>
    </thead>
    <tbody>
       @foreach ($companies as $company)
         <tr>
            <td>{{ $company->name }}</td>
            <td>{{ $company->phone }}</td>
            <td>{{ $company->address }}</td>
            <td>{{ $company->state }}</td>
            <td>{{ $company->city }}</td>
            <td>{{ $company->country }}</td>
            <td colspan="2" class="text-center">
               @can('haveaccess', 'company.edit')
               <button wire:click="edit({{ $company->id }})" class="btn btn-sm btn-outline-warning">
                  <i class="far fa-edit"></i>
               </button>
               @endcan
               @can('haveaccess', 'company.destroy')
               <button wire:click="destroy({{ $company->id }})" class="btn btn-sm btn-outline-danger">
                  <i class="fas fa-trash"></i>
               </button>
               @endcan
            </td>
         </tr>
       @endforeach
    </tbody>
 </table>
 {{ $companies->links() }}
</div>
@endcan