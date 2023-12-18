
<h2>Listado tipos de variedades</h2>
<div class="table-responsive">
   <table class="table table-sm table-hover">
    <thead>
       <tr>
          <th scope="col">ID</th>
          <th scope="col">Nombre</th>
          <th scope="col">Nombre Cientifico</th>
          <th scope="col">Creado / Editado</th>
          <th scope="col">Fecha Creado / Editado</th>
          <th class="text-center" colspan="2">@can('haveaccess', 'variety.edit') Editar @endcan  @can('haveaccess', 'variety.destroy')/ Eliminar @endcan</th>
       </tr>
    </thead>
    <tbody>
       @foreach ($varieties as $variety)
         <tr>
            <td>{{ $variety->id }}</td>
            <td>{{ $variety->name }}</td>
            <td>{{ $variety->scientific_name }}</td>
            <td>
               {{ ucfirst($variety->user->name) }} / 
               @foreach ($users as $user)
                  @if ($user->id == $variety->update_user)
                     {{ ucfirst($user->name) }}
                  @endif
               @endforeach
            </td>
            <td>
               {{ date('d/m/Y', strtotime($variety->created_at)) }} / {{ date('d/m/Y', strtotime($variety->updated_at)) }}
            </td>
            <td colspan="2" class="text-center">
               @can('haveaccess', 'variety.edit')
               <button wire:click="edit({{ $variety->id }})" class="btn btn-sm btn-outline-warning">
                  <i class="far fa-edit"></i>
               </button>
               @endcan
               @can('haveaccess', 'variety.destroy')
               <button wire:click="destroy({{ $variety->id }})" class="btn btn-sm btn-outline-danger">
                  <i class="fas fa-trash"></i>
               </button>
               @endcan
            </td>
         </tr>
       @endforeach
    </tbody>
 </table>
 {{ $varieties->links() }}
</div>
