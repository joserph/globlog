<div class="form-row">
    <div class="col-md-12 form-group finca">
        {{ Form::label('description', 'Descripsión', ['class' => 'control-label']) }}
        {{ Form::text('description', null, ['class' => 'form-control select-farm', 'placeholder' => 'Observaciones Empaques']) }}
    </div>
    {{ Form::hidden('id_user', Auth::user()->id) }}
    {{ Form::hidden('update_user', Auth::user()->id) }}
 </div>