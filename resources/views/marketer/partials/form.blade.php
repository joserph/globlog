<div class="form-row">
    <div class="col-md-3 form-group finca">
        {{ Form::label('name', 'Nombre', ['class' => 'control-label']) }}
        {{ Form::text('name', null, ['class' => 'form-control select-farm', 'placeholder' => 'Nombre Comercializadora']) }}
    </div>
    <div class="col-md-9 form-group finca">
        {{ Form::label('clients', 'Clientes', ['class' => 'control-label']) }}
        {{ Form::text('clients', null, ['class' => 'form-control select-farm', 'placeholder' => 'Clientes']) }}
    </div>
    {{ Form::hidden('id_user', Auth::user()->id) }}
    {{ Form::hidden('update_user', Auth::user()->id) }}
 </div>