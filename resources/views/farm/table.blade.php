@can('haveaccess', 'farm.index')

<h2>Listado de Fincas</h2>

<div class="table-responsive">
   <div class="form-group row">
      <label for="inputPassword" class="col-sm-1 col-form-label">Buscar</label>
      <div class="col-sm-11">
        <input type="text" wire:model="term" class="form-control">
      </div>
    </div>

    
   <table class="table table-sm table-hover" id="farm-table">
    <thead>
       <tr>
       <th scope="col">ID</th>
          <th scope="col">Nombre</th>
          <th scope="col">RUC</th>
          <th scope="col">Nombre Comercial</th>
          <th scope="col">Teléfono</th>
          <th scope="col">Dirección</th>
          <th scope="col">Estado</th>
          <th scope="col">Ciudad</th>
          <th scope="col">País</th>
          <th scope="col">Creado / Editado</th>
          <th scope="col">Fecha Creado / Editado</th>
          <th class="text-center" colspan="2">@can('haveaccess', 'farm.edit') Editar @endcan  @can('haveaccess', 'farm.destroy')/ Eliminar @endcan</th>
       </tr>
    </thead>
    <tbody>
       @foreach ($farms as $farm)
         <tr>
            <td>{{ $farm->id }}</td>
            <td><a class="text-decoration-none" href="{{ route('farm.show', $farm->id) }}">{{ $farm->name }}</a></td>
            <td>{{ $farm->ruc }}</td>
            <td>{{ $farm->tradename }}</td>
            <td>{{ $farm->phone }}</td>
            <td>{{ Str::limit($farm->address, 20) }}</td>
            <td>{{ $farm->state }}</td>
            <td>{{ $farm->city }}</td>
            <td>{{ $farm->country }}</td>
            <td>
               {{ ucfirst($farm->user->name) }} / 
               @foreach ($users as $user)
                  @if ($user->id == $farm->update_user)
                     {{ ucfirst($user->name) }}
                  @endif
               @endforeach
            </td>
            <td>
               {{ date('d/m/Y', strtotime($farm->created_at)) }} / {{ date('d/m/Y', strtotime($farm->updated_at)) }}
            </td>
            <td colspan="2" class="text-center">
               @can('haveaccess', 'farm.edit')
               <button wire:click="edit({{ $farm->id }})" class="btn btn-sm btn-outline-warning">
                  <i class="far fa-edit"></i>
               </button>
               @endcan
               @can('haveaccess', 'farm.destroy')
               <button wire:click="destroy({{ $farm->id }})" class="btn btn-sm btn-outline-danger">
                  <i class="fas fa-trash"></i>
               </button>
               @endcan
            </td>
         </tr>
       @endforeach
    </tbody>
 </table>
 {{ $farms->links() }}
</div>
@endcan
