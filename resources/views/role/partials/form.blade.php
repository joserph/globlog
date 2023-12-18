<div class="form-group row">
    {{ Form::label('name', 'Nombre', ['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-10">
        {{ Form::text('name', null, ['class' => 'form-control']) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('slug', 'Slug', ['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-10">
        {{ Form::text('slug', null, ['class' => 'form-control']) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('description', 'Descricción', ['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-10">
        {{ Form::textarea('description', null, ['class' => 'form-control']) }}
    </div>
</div>
<hr>
<h3>Full Acceso</h3>
<div class="form-group">
    <label>{{ Form::radio('full_access', 'yes') }} Si</label>
    <label>{{ Form::radio('full_access', 'no', true) }} No</label>
</div>

<h3>Lista de Permisos</h3>
<div class="form-group">
    
    @foreach($permissions as $permission)
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <input class="form-check-input" type="checkbox" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" name="permission[]" 
        
        @if(is_array(old('permission')) && in_array("$permission->id", old('permission'))) checked 
        @endif
        >
        <label class="form-check-label" for="permission_{{ $permission->id }}">
            {{ $permission->id }} - {{ $permission->name }} <em>{{ $permission->description }}</em>
        </label>
    </div>
    @endforeach
</div>

