<div class="form-row">
    <div class="col-md-4 form-group">
      {{ Form::label('description_id', 'Descripcion', ['class' => 'control-label']) }}
      {{ Form::select('description_id', $descriptions, null, ['class' => 'custom-select', 'placeholder' => 'Seleccione descripcion', 'required']) }}
    </div>
    <div class="col-md-2 form-group">
        {{ Form::label('pieces', 'Piezas', ['class' => 'control-label']) }}
        {{ Form::text('pieces', null, ['class' => 'form-control grupo', 'placeholder' => 'Piezas', 'required']) }}
    </div>
    <div class="col-md-2 form-group">
        {{ Form::label('quantity', 'Cantidad', ['class' => 'control-label']) }}
        {{ Form::text('quantity', null, ['class' => 'form-control grupo', 'placeholder' => 'Cantidad', 'required']) }}
    </div>
    <div class="col-md-2 form-group">
        {{ Form::label('rate', 'Tarifa', ['class' => 'control-label']) }}
        {{ Form::text('rate', null, ['class' => 'form-control grupo', 'placeholder' => 'Tarifa', 'required']) }}
    </div>
    <div class="col-md-2 form-group">
        {{ Form::label('amount', 'Total', ['class' => 'control-label']) }}
        {{ Form::text('amount', null, ['class' => 'form-control grupo', 'placeholder' => 'Total', 'readonly', 'required']) }}
    </div>
    {{ Form::hidden('id_user', Auth::user()->id) }}
    {{ Form::hidden('update_user', Auth::user()->id) }}
    {{ Form::hidden('invoice_id', $invoice->id) }}
 </div>
