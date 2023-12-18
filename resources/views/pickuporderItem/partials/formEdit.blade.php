<div class="form-row">
    <div class="form-group col-md-3">
       {{ Form::label('awb', 'Número AWB') }}
       {{ Form::text('awb', $item->awb, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-5">
       {{ Form::label('description', 'Descripción') }}
       {{ Form::text('description', $item->description, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-2">
       {{ Form::label('pieces', 'N° Piezas') }}
       {{ Form::text('pieces', $item->pieces, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-2">
       {{ Form::label('pallets', 'N° Pallets') }}
       {{ Form::text('pallets', $item->pallets, ['class' => 'form-control']) }}
    </div>
    
    {{ Form::hidden('id_pickup', $item->id_pickup) }}
    {{ Form::hidden('update_user', Auth::user()->id) }}
</div>
     