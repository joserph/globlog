@can('haveaccess', 'client.index')
<h2>Listado de Clientes 
   <a href="{{ route('client.excel') }}" target="_blank" class="btn btn-xs btn-outline-success pull-right"><i class="fas fa-file-excel"></i> Descargar Excel de Clientes</a>
</h2>
<div class="table-responsive">
   <div class="form-group row">
      <label for="inputPassword" class="col-sm-1 col-form-label">Buscar</label>
      <div class="col-sm-11">
        <input type="text" wire:model="term" class="form-control">
      </div>
    </div>
   <table class="table table-sm table-hover">
    <thead>
       <tr>
       <th scope="col" class="text-center">ID</th>
          <th scope="col" class="text-center">Nombre</th>
          <th scope="col" class="text-center">Teléfono</th>
          <th scope="col" class="text-center">Correo</th>
          <th scope="col" class="text-center">Dirección</th>
          <th scope="col" class="text-center">POA</th>
          <th scope="col" class="text-center">Color</th>
          <th scope="col" class="text-center">Propietario</th>
          <th scope="col" class="text-center">Sub Propietario</th>
          <th scope="col" class="text-center">Nombres Relacionados</th>
          <th scope="col" class="text-center">Broker/Comprador</th>
          <th scope="col" class="text-center">Creado / Editado</th>
          <th scope="col" class="text-center">Fecha Creado / Editado</th>
          <th class="text-center" colspan="2">@can('haveaccess', 'client.edit') Editar @endcan  @can('haveaccess', 'client.destroy')/ Eliminar @endcan</th>
       </tr>
    </thead>
    <tbody>
       @foreach ($clients as $client)
         <tr>
            <td>{{ $client->id }}</td>
            <td>{{ $client->name }}</td>
            <td>{{ $client->phone }}</td>
            <td>{{ $client->email }}</td>
            <td>{{ Str::limit($client->address, 15) }}</td>
            <td>
               @if ($client->poa == 'yes')
               <span class="badge badge-success">SI</span>
               @else
               <span class="badge badge-dark">NO</span>
               @endif
            </td>
            <td>
               @foreach ($colors as $item)
                  @if ($client->id == $item->id_type)
                     @if ($item->label == 'square')
                        <span style="color: {{ $item->color }};" data-toggle="tooltip" data-placement="top" title="Etiqueta Cuadrada">
                           <i class="fas fa-square fa-2x"></i>
                        </span>
                     @else 
                        <span style="color: {{ $item->color }};" data-toggle="tooltip" data-placement="top" title="Etiqueta Punto">
                           <i class="fas fa-circle fa-2x"></i>
                        </span>
                     @endif
                  @endif
               @endforeach
            </td>
            <td>{{ $client->owner }}</td>
            <td>{{ $client->sub_owner }}</td>
            <td>{{ $client->related_names }}</td>
            <td>{{ $client->buyer }}</td>
            <td>
               {{ ucfirst($client->user->name) }} / 
               @foreach ($users as $user)
                  @if ($user->id == $client->update_user)
                     {{ ucfirst($user->name) }}
                  @endif
               @endforeach
            </td>
            <td>
               {{ date('d/m/Y', strtotime($client->created_at)) }} / {{ date('d/m/Y', strtotime($client->updated_at)) }}
            </td>
            <td colspan="2" class="text-center">
               @can('haveaccess', 'client.edit')
               <button wire:click="edit({{ $client->id }})" class="btn btn-sm btn-outline-warning">
                  <i class="far fa-edit"></i>
               </button>
               @endcan
               @can('haveaccess', 'client.destroy')
               <button wire:click="destroy({{ $client->id }})" class="btn btn-sm btn-outline-danger">
                  <i class="fas fa-trash"></i>
               </button>
               @endcan
            </td>
         </tr>
       @endforeach
    </tbody>
 </table>
 {{ $clients->links() }}
</div>
@endcan