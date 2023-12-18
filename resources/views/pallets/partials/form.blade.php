<div class="row">
   {!! Form::hidden('id_user', \Auth::user()->id) !!}
   {!! Form::hidden('update_user', \Auth::user()->id) !!}
   {!! Form::hidden('id_load', $load->id) !!}

   <div class="col-md-4 form-group">
      {{ Form::label('number', 'Número', ['class' => 'control-label']) }}
      <div class="input-group mb-3">
         <span class="input-group-text" id="basic-addon1">{{ $load->shipment }} -</span>
         {{ Form::number('number1', $counter, ['class' => 'form-control', 'readonly']) }}
         {!! Form::hidden('counter', $counter) !!}
         {!! Form::hidden('number', $load->shipment) !!}
      </div>
   </div>
   <div class="col-md-12 form-group">
      {{ Form::label('usda', 'USDA', ['class' => 'control-label']) }}
      <div class="col-sm-2">
         {{ Form::checkbox('usda', null, false) }}
      </div>
   </div>
</div>
                            
                 