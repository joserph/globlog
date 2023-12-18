<div class="form-row">
    <div class="col-md-6 form-group">
        {{ Form::label('name', 'Nombre', ['class' => 'control-label']) }}
        {{ Form::text('name', null, ['class' => 'form-control select-farm', 'placeholder' => 'Nombre de la variedad']) }}
    </div>
    <div class="col-md-6 form-group">
        {{ Form::label('type', 'Tipo de flor', ['class' => 'control-label']) }}
        {{ Form::select('type', $vatieties, null, ['class' => 'form-control select-client', 'placeholder' => 'Seleccione tipo']) }}
    </div>
    {{ Form::hidden('update_user', Auth::user()->id) }}
 </div>