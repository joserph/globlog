<div class="form-row">
    <div class="form-group col-md-6">
        {{ Form::label('name', 'Nombre') }}
        {{ Form::text('name', null, ['class' => 'form-control']) }}
    </div>  
    <div class="form-group col-md-3">
        {{ Form::label('ruc', 'RUC') }}
        {{ Form::text('ruc', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-3">
        {{ Form::label('phone', 'Teléfono') }}
        {{ Form::text('phone', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-4">
        {{ Form::label('email', 'Correo') }}
        {{ Form::email('email', null, ['class' => 'form-control']) }}
    </div>
    @isset($dae)
        {{ Form::hidden('update_user', Auth::user()->id) }}
    @else
        {{ Form::hidden('id_user', Auth::user()->id) }}
        {{ Form::hidden('update_user', Auth::user()->id) }}
    @endisset
</div>    
	    