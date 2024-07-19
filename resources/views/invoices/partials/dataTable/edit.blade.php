@can('haveaccess', 'invoices.edit')
    <a href="{{ route('invoices.edit', $id) }}" class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i></a>
@endcan