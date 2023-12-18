<div class="form-row">
    <div class="form-group col-md-4">
       {{ Form::label('date', 'Fecha') }}
       {{ Form::date('date', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-4">
       {{ Form::label('loading_date', 'Fecha de Carga') }}
       {{ Form::date('loading_date', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-2">
       {{ Form::label('loading_hour', 'Hora de Carga') }}
       {{ Form::time('loading_hour', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-4">
       {{ Form::label('carrier_company', 'Compañia de Transporte') }}
       {{ Form::text('carrier_company', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-4">
       {{ Form::label('driver_name', 'Nombre Chofer') }}
       {{ Form::text('driver_name', null, ['class' => 'form-control']) }}
    </div>
    
    <div class="form-group col-md-6">
       {{ Form::label('pick_up_location', 'Lugar de Recogida') }}
       {{ Form::text('pick_up_location', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-6">
       {{ Form::label('pick_up_address', 'Dirección de Recogina') }}
       {{ Form::text('pick_up_address', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-6">
       {{ Form::label('consigned_to', 'Consignado A') }}
       {{ Form::text('consigned_to', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-6">
       {{ Form::label('drop_off_address', 'Dirección de Entrega') }}
       {{ Form::text('drop_off_address', null, ['class' => 'form-control']) }}
    </div>
    {{ Form::hidden('carrier_num', null) }}
    {{ Form::hidden('update_user', Auth::user()->id) }}
 </div>
     