<div class="form-row">
    <div class="form-group col-md-3">
       {{ Form::label('type', 'Tipo') }}
       {{ Form::select('type', [
          'client' => 'Cliente',
          'farm' => 'Finca'
          ], null, ['class' => 'form-control', 'placeholder' => 'Seleccione tipo', 'id' => 'tipo']) }}
    </div>
    
      <div class="col-md-3 form-group finca">
         {{ Form::label('farm', 'Finca', ['class' => 'control-label']) }}
         {{ Form::select('farm', $farms, $color->id_type, ['class' => 'form-control select-farm', 'placeholder' => 'Seleccione finca']) }}
      </div>
    
      <div class="col-md-3 form-group cliente">
         {{ Form::label('client', 'Cliente', ['class' => 'control-label']) }}
         {{ Form::select('client', $clients, $color->id_type, ['class' => 'form-control select-client', 'placeholder' => 'Seleccione cliente']) }}
      </div>
    
    <div class="form-group col-md-3">
       {{ Form::label('color', 'Color') }}
       {{ Form::color('color', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-3">
      {{ Form::label('label', 'Etiqueta') }}
      {{ Form::select('label', [
         'square' => 'Cuadrado',
         'point' => 'Punto'
         ], null, ['class' => 'form-control', 'placeholder' => 'Seleccione Etiqueta']) }}
   </div>
   <div class="form-group col-md-3">
      {{ Form::label('load_type', 'Tipo de Carga') }}
      {{ Form::select('load_type', [
         'aereo' => 'Aéreo',
         'maritimo' => 'Marítimo'
         ], null, ['class' => 'form-control', 'placeholder' => 'Seleccione Tipo de Carga']) }}
   </div>
    {{ Form::hidden('update_user', Auth::user()->id) }}
 </div>
 @section('scripts')
 <script>
   $(document).ready(function(){
        var tipo = $('#tipo').val();
        console.log(tipo);
        if(tipo == 'client')
        {
            $('.finca').hide();
        }else{
            $('.cliente').hide();
        }
        $('#tipo').on('change', function() {
            if($('#tipo').val() == 'client'){
               console.log('cliente');
               $('.cliente').show();
               $('.finca').hide();
            }else if($('#tipo').val() == 'farm'){
               $('.finca').show();
               $('.cliente').hide();
               console.log('finca');
            }
        });
      
   });
 </script>
 @endsection
     