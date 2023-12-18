<div class="form-row">
    <div class="form-group col-md-3">
       {{ Form::label('awb', 'AWB') }}
       {{ Form::text('awb', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-3">
       {{ Form::label('carrier', 'Transportista') }}
       {{ Form::text('carrier', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-3">
       {{ Form::label('date', 'Fecha') }}
       {{ Form::date('date', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-3">
      {{ Form::label('arrival_date', 'Fecha llegada') }}
      {{ Form::date('arrival_date', null, ['class' => 'form-control']) }}
   </div>
   <div class="form-group col-md-3">
      {{ Form::label('code', 'Código Termografo') }}
      {{ Form::text('code', null, ['class' => 'form-control']) }}
   </div>
   <div class="form-group col-md-3">
      {{ Form::label('brand', 'Marca Termografo') }}
      {{ Form::text('brand', null, ['class' => 'form-control']) }}
   </div>
   <div class="form-group col-md-3">
      {{ Form::label('type_awb', 'Tipo de AWB') }}
      {{ Form::select('type_awb', ['own' => 'Propia', 'external' => 'Externa'], null, ['placeholder' => 'Seleccione Tipo AWB', 'class' => 'form-control']) }}
   </div>
   <div class="form-group col-md-3">
      {{ Form::label('status', 'Estatus de Guía') }}
      {{ Form::select('status', ['open' => 'Abierta', 'closed' => 'Cerrada'], null, ['placeholder' => 'Seleccione Estatus', 'class' => 'form-control']) }}
   </div>
    {{ Form::hidden('update_user', Auth::user()->id) }}
 </div>
     