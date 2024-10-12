<div class="form-row">
    <div class="col-md-3 form-group">
      {{ Form::label('client_id', 'Cliente', ['class' => 'control-label']) }}
      {{ Form::select('client_id', $clients, null, ['class' => 'form-control', 'placeholder' => 'Seleccione cliente', 'required']) }}
    </div>
    <div class="form-group col-md-3">
        {{ Form::label('load_type', 'Tipo de carga') }}
        {{ Form::select('load_type', [
           'load' => 'Maritimo',
           'flight' => 'Aereo'
           ], null, ['class' => 'form-control', 'placeholder' => 'Seleccione tipo', 'id' => 'tipo', 'required']) }}
     </div>
    <div class="col-md-3 form-group load">
        {{ Form::label('load_id', 'Contenedor', ['class' => 'control-label']) }}
        {{ Form::select('load_id', $loads, null, ['class' => 'form-control select-load', 'placeholder' => 'Seleccione maritimo']) }}
    </div>
    <div class="col-md-3 form-group flight">
        {{ Form::label('flight_id', 'Vuelo', ['class' => 'control-label']) }}
        {{ Form::select('flight_id', $flights, null, ['class' => 'form-control select-flight', 'placeholder' => 'Seleccione aereo']) }}
    </div>
    <div class="col-md-3 form-group">
        {{ Form::label('date', 'Fecha', ['class' => 'control-label']) }}
        {{ Form::date('date', null, ['class' => 'form-control', 'required'])}}
    </div>
    <div class="form-group col-md-3">
        {{ Form::label('type', 'Tipo') }}
        {{ Form::select('type', ['transport' => 'TRANSPORT'], null, ['placeholder' => 'Seleccione Tipo', 'class' => 'form-control', 'required']) }}
     </div>
     <div class="form-group col-md-3">
        {{ Form::label('terms', 'Terminos') }}
        {{ Form::select('terms', ['cod' => 'COD'], null, ['placeholder' => 'Seleccione Terminos', 'class' => 'form-control', 'required']) }}
     </div>
    {{ Form::hidden('id_user', Auth::user()->id) }}
    {{ Form::hidden('update_user', Auth::user()->id) }}
 </div>
 @section('scripts')
 <script>
   $(document).ready(function(){
        var tipo = $('#tipo').val();
        $('.load').hide();
        $('.flight').hide();
        $('#tipo').on('change', function() {
            if($('#tipo').val() == 'load'){
               //console.log('cliente');
               $('.load').show();
               $('#load_id').prop('required',true);
               $('.flight').hide();
            }else if($('#tipo').val() == 'flight'){
               $('.flight').show();
               $('#flight_id').prop('required',true);
               $('.load').hide();
               //console.log('finca');
            }
        });
        $('.select-flight').select2({
            theme: 'bootstrap4',
        });
        $('.select-load').select2({
            theme: 'bootstrap4',
        });
   });
 </script>
 @endsection