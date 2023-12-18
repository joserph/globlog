<div class="form-group">
    {{ Form::label('name', 'Nombre', ['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-12">
        {{ Form::text('name', null, ['class' => 'form-control', 'readonly' => 'readonly']) }}
    </div>
</div>
<div class="form-group">
    {{ Form::label('email', 'Correo', ['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-12">
        {{ Form::text('email', null, ['class' => 'form-control', 'readonly' => 'readonly']) }}
    </div>
</div>
<div class="form-group">
    {{ Form::label('roles', 'Role', ['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-12">
        {{ Form::select('roles', $roles, null, ['class' => 'form-control', 'placeholder' => 'Seleccione role', 'readonly' => 'readonly']) }}
    </div>
</div>