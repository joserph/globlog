<div class="form-row">
   <div class="form-group col-md-2">
      {{ Form::label('shipment', 'Carga') }}
      {{ Form::text('shipment', null, ['class' => 'form-control']) }}
   </div>
   <div class="form-group col-md-4">
      {{ Form::label('bl', 'BL') }}
      {{ Form::text('bl', null, ['class' => 'form-control']) }}
   </div>
   <div class="form-group col-md-3">
      {{ Form::label('booking', 'Booking') }}
      {{ Form::text('booking', null, ['class' => 'form-control']) }}
   </div>
   <div class="form-group col-md-3">
      {{ Form::label('carrier', 'Transportista') }}
      {{ Form::text('carrier', null, ['class' => 'form-control']) }}
   </div>
   <div class="form-group col-md-4">
      {{ Form::label('id_logistic_company', 'Carguera') }}
      {{ Form::select('id_logistic_company', $logistics_companies, null, ['class' => 'form-control', 'placeholder' => 'Seleccione Carguera']) }}
   </div>
   <div class="form-group col-md-4">
      {{ Form::label('date', 'Fecha Salida') }}
      {{ Form::date('date', null, ['class' => 'form-control']) }}
   </div>
   <div class="form-group col-md-4">
      {{ Form::label('arrival_date', 'Fecha llegada') }}
      {{ Form::date('arrival_date', null, ['class' => 'form-control']) }}
   </div>
   
   <div class="form-group col-md-6">
      {{ Form::label('code_deep', 'Código Termografo Fondo') }}
      {{ Form::text('code_deep', null, ['class' => 'form-control']) }}
   </div>
   <div class="form-group col-md-6">
      {{ Form::label('brand_deep', 'Marca Termografo Fondo') }}
      {{ Form::text('brand_deep', null, ['class' => 'form-control']) }}
   </div>
   <div class="form-group col-md-6">
      {{ Form::label('code_door', 'Código Termografo Puerta') }}
      {{ Form::text('code_door', null, ['class' => 'form-control']) }}
   </div>
   <div class="form-group col-md-6">
      {{ Form::label('brand_door', 'Marca Termografo Puerta') }}
      {{ Form::text('brand_door', null, ['class' => 'form-control']) }}
   </div>

   <div class="form-group col-md-3">
      {{ Form::label('container_number', 'Número Contenedor') }}
      {{ Form::text('container_number', null, ['class' => 'form-control']) }}
   </div>
   <div class="form-group col-md-3">
      {{ Form::label('seal_bottle', 'Sello Botella') }}
      {{ Form::text('seal_bottle', null, ['class' => 'form-control']) }}
   </div>
   <div class="form-group col-md-3">
      {{ Form::label('seal_cable', 'Sello Cable') }}
      {{ Form::text('seal_cable', null, ['class' => 'form-control']) }}
   </div>
   <div class="form-group col-md-3">
      {{ Form::label('seal_sticker', 'Sello Sticker') }}
      {{ Form::text('seal_sticker', null, ['class' => 'form-control']) }}
   </div>
   <div class="form-group col-md-4">
      {{ Form::label('id_qa', 'Empresa QA') }}
      {{ Form::select('id_qa', $qacompanies, null, ['class' => 'form-control', 'placeholder' => 'Seleccione Carguera']) }}
   </div>
   <div class="form-group col-md-3">
      {{ Form::label('floor', 'Paletas al Piso') }}
      {{ Form::select('floor', [
         'si' => 'Si',
         'no' => 'No'
         ], null, ['class' => 'form-control', 'placeholder' => 'Paletas al Piso']) }}
   </div>
   <div class="form-group col-md-2" id="hide">
      {{ Form::label('num_pallets', 'Cantidad de paletas') }}
      {{ Form::number('num_pallets', null, ['class' => 'form-control']) }}
   </div>

   {{ Form::hidden('update_user', Auth::user()->id) }}
 </div>
     