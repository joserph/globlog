<div class="row">
    <div class="col-sm-2">
        {{ Form::label('report_w', 'Reported Weight', ['class' => 'control-label']) }}
        {{ Form::text('report_w', null, ['class' => 'form-control']) }}
    </div>
    <div class="col-sm-2">
        {{ Form::label('large', 'Largo', ['class' => 'control-label']) }}
        {{ Form::text('large', null, ['class' => 'form-control']) }}
    </div>
    <div class="col-sm-2">
        {{ Form::label('width', 'Ancho', ['class' => 'control-label']) }}
        {{ Form::text('width', null, ['class' => 'form-control']) }}
    </div>
    <div class="col-sm-2">
        {{ Form::label('high', 'Alto', ['class' => 'control-label']) }}
        {{ Form::text('high', null, ['class' => 'form-control']) }}
    </div>
    <div class="col-sm-4">
        {{ Form::label('observation', 'Observación', ['class' => 'control-label']) }}
        {{ Form::select('observation', $packings, null, ['class' => 'form-control', 'placeholder' => 'Seleccione Observación']) }}
    </div>

    {{ Form::hidden('update_user', Auth::user()->id, ['id' => 'update_user']) }}
    {{ Form::hidden('id_flight', $flight->id, ['id' => 'id_flight']) }}
    {{ Form::hidden('id_distribution', $item['id'], ['id' => 'id_distribution']) }}
    
</div>

