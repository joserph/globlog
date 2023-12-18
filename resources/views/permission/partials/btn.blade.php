<td width="20px" class="text-center">
    @can('haveaccess', 'permission.show')
       <a href="{{ route('permission.show', $id) }}" class="btn btn-outline-info btn-sm"><i class="fas fa-eye"></i></a>
    @endcan
 </td>
 <td width="20px" class="text-center">
    @can('haveaccess', 'permission.edit')
       <a href="{{ route('permission.edit', $id) }}" class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i></a>
    @endcan
 </td>
 <td width="20px" class="text-center">
    @can('haveaccess', 'permission.destroy')
       {{ Form::open(['route' => ['permission.destroy', $id], 'method' => 'DELETE', 'style' => 'display: inline-block']) }}
          {{ Form::button('<i class="fas fa-trash-alt"></i> ' . '', ['type' => 'submit', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Eliminar permiso', 'class' => 'btn btn-sm btn-outline-danger', 'onclick' => 'return confirm("¿Seguro de eliminar el permiso?")']) }}
       {{ Form::close() }}
    @endcan
    
 </td>