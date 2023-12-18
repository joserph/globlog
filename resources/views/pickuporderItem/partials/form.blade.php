<div class="form-row">
    <div class="form-group col-md-3">
       {{ Form::label('awb', 'Número AWB') }}
       {{ Form::text('awb', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-5">
       {{ Form::label('description', 'Descripción') }}
       {{ Form::text('description', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-2">
       {{ Form::label('pieces', 'N° Piezas') }}
       {{ Form::text('pieces', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-2">
       {{ Form::label('pallets', 'N° Pallets') }}
       {{ Form::text('pallets', null, ['class' => 'form-control']) }}
    </div>
    
    {{ Form::hidden('id_pickup', $pickuporder->id) }}
    {{ Form::hidden('id_user', Auth::user()->id) }}
    {{ Form::hidden('update_user', Auth::user()->id) }}
</div>
     