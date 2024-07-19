@can('haveaccess', 'invoices.show')
    <a href="{{ route('invoices.show', $id) }}" class="btn btn-outline-success btn-sm"><i class="fas fa-eye"></i></a>
@endcan