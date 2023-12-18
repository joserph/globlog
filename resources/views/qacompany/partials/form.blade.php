<div class="form-row">
    <div class="form-group col-md-6">
        {{ Form::label('name', 'Nombre') }}
        {{ Form::text('name', null, ['class' => 'form-control']) }}
    </div>  
    <div class="form-group col-md-3">
        {{ Form::label('owner', 'Dueño') }}
        {{ Form::text('owner', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-3">
        {{ Form::label('phone', 'Teléfono') }}
        {{ Form::text('phone', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-9">
        {{ Form::label('address', 'Dirección') }}
        {{ Form::text('address', null, ['class' => 'form-control']) }}
    </div>
    
    <div class="form-group col-md-3">
        {{ Form::label('state', 'Estado / Provincia') }}
        {{ Form::text('state', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-3">
        {{ Form::label('city', 'Ciudad') }}
        {{ Form::text('city', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-3">
        {{ Form::label('country', 'Pais') }}
        {{ Form::text('country', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-4">
        {{ Form::label('email', 'Correo') }}
        {{ Form::email('email', null, ['class' => 'form-control']) }}
    </div>
    @isset($qa_company)
        {{ Form::hidden('update_user', Auth::user()->id) }}
    @else
        {{ Form::hidden('id_user', Auth::user()->id) }}
        {{ Form::hidden('update_user', Auth::user()->id) }}
    @endisset
</div>    
	    