<div class="modal fade" id="editModal{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
          <div class="modal-header">
                <h5 class="modal-title text-dark" id="agregarItemLabel">Contenedor {{ $load->shipment }} - Espacio {{ $item->space }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
          </div>
          <div class="modal-body">
                {{ Form::open(['route' => 'sketches.store', 'class' => 'form-horizontal']) }}
                <div class="modal-body">
                   {!! Form::hidden('update_user', \Auth::user()->id) !!}
                   {{ Form::hidden('id', $item->id) }}
                   {{ Form::label('id_pallet', 'Paleta', ['class' => 'control-label text-dark']) }}
                   {{ Form::select('id_pallet', $palletsSelect, null, ['class' => 'form-control', 'placeholder' => 'Quitar Paleta']) }}
                </div>
                <div class="modal-footer">
                   <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                   <button type="submit" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Crear Empresa">
                      <i class="fas fa-plus-circle"></i> Crear
                   </button>
                </div>
                {{ Form::close() }}
          </div>
       </div>
    </div>
 </div>