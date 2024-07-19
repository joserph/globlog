<td width="45px" class="text-center">
    @can('haveaccess', 'invoices.show')
       <a href="{{ route('invoices.show', $id) }}" class="btn btn-outline-success btn-sm"><i class="fas fa-eye"></i></a>
    @endcan
 </td>
 <td width="45px" class="text-center">
    @can('haveaccess', 'invoices.edit')
       <a href="{{ route('invoices.edit', $id) }}" class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i></a>
    @endcan
 </td>