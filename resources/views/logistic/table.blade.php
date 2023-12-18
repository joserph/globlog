@can('haveaccess', 'logistic.index')
<h2>Empresas de logística</h2>
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
          <th scope="col">Estatus</th>
          <th class="text-center" colspan="2">@can('haveaccess', 'logistic.edit') Editar @endcan  @can('haveaccess', 'logistic.destroy')/ Eliminar @endcan</th>
       </tr>
    </thead>
    <tbody>
       @foreach ($logistics as $logistic)
         <tr>
            <td>{{ $logistic->name }}</td>
            <td>{{ $logistic->phone }}</td>
            <td>{{ $logistic->address }}</td>
            <td>{{ $logistic->state }}</td>
            <td>{{ $logistic->city }}</td>
            <td>{{ $logistic->country }}</td>
            <td>{{ $logistic->active }}</td>
            <td colspan="2" class="text-center">
               @can('haveaccess', 'logistic.edit')
               <button wire:click="edit({{ $logistic->id }})" class="btn btn-sm btn-outline-warning">
                  <i class="far fa-edit"></i>
               </button>
               @endcan
               @can('haveaccess', 'logistic.destroy')
               <button wire:click="destroy({{ $logistic->id }})" class="btn btn-sm btn-outline-danger">
                  <i class="fas fa-trash"></i>
               </button>
               @endcan
            </td>
         </tr>
       @endforeach
    </tbody>
 </table>
 {{ $logistics->links() }}
</div>
@endcan