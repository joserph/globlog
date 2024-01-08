@can('haveaccess', 'itemforinvoice.index')

<h2>Listado de items</h2>

<div class="table-responsive">
   <div class="form-group row">
      <label for="inputPassword" class="col-sm-1 col-form-label">Buscar</label>
      <div class="col-sm-11">
        <input type="text" wire:model="term" class="form-control">
      </div>
    </div>

    
   <table class="table table-sm table-hover" id="itemforinvoice-table">
    <thead>
       <tr>
       <th scope="col">ID</th>
          <th scope="col">Nombre</th>
          <th scope="col">Creado / Editado</th>
          <th scope="col">Fecha Creado / Editado</th>
          <th class="text-center" colspan="2">@can('haveaccess', 'itemforinvoice.edit') Editar @endcan  @can('haveaccess', 'itemforinvoice.destroy')/ Eliminar @endcan</th>
       </tr>
    </thead>
    <tbody>
       @foreach ($itemsforinvoices as $item)
         <tr>
            <td>{{ $item->id }}</td>
            {{-- <td><a class="text-decoration-none" href="{{ route('itemforinvoice.show', $item->id) }}">{{ $item->name }}</a></td> --}}
            <td>{{ $item->name }}</td>
            <td>
               {{ ucfirst($item->user->name) }} / 
               @foreach ($users as $user)
                  @if ($user->id == $item->update_user)
                     {{ ucfirst($user->name) }}
                  @endif
               @endforeach
            </td>
            <td>
               {{ date('d/m/Y', strtotime($item->created_at)) }} / {{ date('d/m/Y', strtotime($item->updated_at)) }}
            </td>
            <td colspan="2" class="text-center">
               @can('haveaccess', 'itemforinvoice.edit')
               <button wire:click="edit({{ $item->id }})" class="btn btn-sm btn-outline-warning">
                  <i class="far fa-edit"></i>
               </button>
               @endcan
               @can('haveaccess', 'itemforinvoice.destroy')
               <button wire:click="destroy({{ $item->id }})" class="btn btn-sm btn-outline-danger">
                  <i class="fas fa-trash"></i>
               </button>
               @endcan
            </td>
         </tr>
       @endforeach
    </tbody>
 </table>
 {{ $itemsforinvoices->links() }}
</div>
@endcan
