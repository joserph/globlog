<div class="form-group row">
    {{ Form::label('name', 'Nombre', ['class' => 'col-sm-3 control-label']) }}
    <div class="col-sm-9">
        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('email', 'Correo', ['class' => 'col-sm-3 control-label']) }}
    <div class="col-sm-9">
        {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Correo']) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('password', 'Contraseña', ['class' => 'col-sm-3 control-label']) }}
    <div class="col-sm-9">
        {{ Form::password('password', ['class' => 'awesome form-control', 'placeholder' => 'Contraseña']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('type_user', 'Tipo de Usuario', ['class' => 'col-sm-3 control-label']) }}
    <div class="col-sm-9">
        {{ Form::select('type_user', ['user' => 'Usuario Interno', 'farm' => 'Finca', 'charge_agency' => 'Agencia de Carga'], null, ['placeholder' => 'Seleccione Tipo de Usuario', 'class' => 'form-control']) }}
    </div>
</div>
<div class="form-group row hide" id="farms_input">
    {{ Form::label('id_farm', 'Finca', ['class' => 'control-label col-sm-3']) }}
    {{-- {{ Form::select('id_farm', $farms, null, ['class' => 'form-control select-farm', 'placeholder' => 'Seleccione finca']) }} --}}
    <div class="col-sm-9">
        <select class="form-control id_farm" name="id_farm" id="id_farm">
            <option value="">Seleccione finca</option>
            @foreach($farmsList as $itemFarm)
            <option value="{{ $itemFarm->id }}">{{ $itemFarm->name }} {{ $itemFarm->tradename }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row hide" id="clients_input">
    {{ Form::label('id_client', 'Cliente', ['class' => 'control-label col-sm-3']) }}
    {{-- {{ Form::select('id_client', $clients, null, ['class' => 'form-control select-client', 'placeholder' => 'Seleccione cliente']) }} --}}
    <div class="col-sm-9">
        <select class="form-control id_client" name="id_client" id="id_client">
            <option value="">Seleccione cliente</option>
            @foreach($clientsList as $itemClient)
            <option value="{{ $itemClient->id }}">{{ str_replace('SAG-', '', $itemClient->name) }}</option>
            @endforeach
        </select>
    </div>
</div>

@if (Auth::user()->roles[0]->full_access != 'no')
<div class="form-group row">
    {{ Form::label('roles', 'Role', ['class' => 'col-sm-3 control-label']) }}
    <div class="col-sm-9">
        {{ Form::select('roles', $roles, null, ['class' => 'form-control', 'placeholder' => 'Seleccione role']) }}
    </div>
</div>
@else 
    {{ Form::hidden('roles', $user->roles[0]->id)}}
@endif
