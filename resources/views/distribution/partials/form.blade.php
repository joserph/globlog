<div class="row">
    <div class="col-md-4 form-group">
        {{ Form::label('id_farm', 'Finca', ['class' => 'control-label']) }}
        {{-- {{ Form::select('id_farm', $farms, null, ['class' => 'form-control select-farm', 'placeholder' => 'Seleccione finca']) }} --}}
        <select class="form-control select-farm" name="id_farm" id="id_farm">
            <option value="">Seleccione finca</option>
            @foreach($farmsList as $itemFarm)
              <option value="{{ $itemFarm->id }}">{{ $itemFarm->name }} {{ $itemFarm->tradename }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 form-group">
        {{ Form::label('id_client', 'Cliente', ['class' => 'control-label']) }}
        {{-- {{ Form::select('id_client', $clients, null, ['class' => 'form-control select-client', 'placeholder' => 'Seleccione cliente']) }} --}}
        <select class="form-control select-client" name="id_client" id="id_client">
            <option value="">Seleccione cliente</option>
            @foreach($clientsList as $itemClient)
              <option value="{{ $itemClient->id }}">{{ str_replace('SAG-', '', $itemClient->name) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 form-group">
        {{ Form::label('variety_id', 'Variedad', ['class' => 'control-label']) }}
        {{ Form::select('variety_id', $varieties, null, ['class' => 'form-control select-product', 'placeholder' => 'Seleccione tipo']) }}
    </div>
    <div class="col-sm-2">
        
        @if($flight->type_awb == 'own')
            {{-- {{ Form::text('hawb', $hawb_format, ['class' => 'form-control', 'readonly']) }} --}}
        @else
            {{ Form::label('hawb', 'HAWB', ['class' => 'control-label']) }}
            {{ Form::text('hawb', null, ['class' => 'form-control']) }}
        @endif
    </div>
    <h5 class="col-sm-12">
        <p class="lead">Coordinado</p>
        <hr>
    </h5>
    <div class="col-sm-2">
        {{ Form::label('hb', 'HB Coordinado', ['class' => 'control-label']) }}
        {{ Form::number('hb', 0, ['class' => 'form-control']) }}
    </div>
    <div class="col-sm-2">
        {{ Form::label('qb', 'QB Coordinado', ['class' => 'control-label']) }}
        {{ Form::number('qb', 0, ['class' => 'form-control']) }}
    </div>
    <div class="col-sm-2">
        {{ Form::label('eb', 'EB Coordinado', ['class' => 'control-label']) }}
        {{ Form::number('eb', 0, ['class' => 'form-control']) }}
    </div>
    <h5 class="col-sm-12">
        <br>
        <p class="lead">Recibido</p>
        <hr>
    </h5>
    <h5 class="col-sm-12">Recibidos</h5>
    <div class="col-sm-2">
        {{ Form::label('hb_r', 'HB Recibido', ['class' => 'control-label']) }}
        {{ Form::number('hb_r', 0, ['class' => 'form-control']) }}
    </div>
    <div class="col-sm-2">
        {{ Form::label('qb_r', 'QB Recibido', ['class' => 'control-label']) }}
        {{ Form::number('qb_r', 0, ['class' => 'form-control']) }}
    </div>
    <div class="col-sm-2">
        {{ Form::label('eb_r', 'EB Recibido', ['class' => 'control-label']) }}
        {{ Form::number('eb_r', 0, ['class' => 'form-control']) }}
    </div>

    <div class="col-sm-2">
        {{ Form::label('returns', 'Devolución', ['class' => 'control-label']) }}
        {{ Form::number('returns', 0, ['class' => 'form-control']) }}
    </div>
    <div class="col-sm-4">
        {{ Form::label('observation', 'Observación', ['class' => 'control-label']) }}
        {{ Form::textarea('observation', null, ['class' => 'form-control', 'rows' => '4', 'cols' => '50']) }}
    </div>
    <div class="col-md-5 form-group">
        {{ Form::label('id_marketer', 'Comercializadora', ['class' => 'control-label']) }}
        {{ Form::select('id_marketer', $marketers, null, ['class' => 'form-control', 'placeholder' => 'Seleccione Comercializadora']) }}
    </div>
    <div class="col-sm-4 form-check">
        <input type="checkbox" class="form-check-input" name="duplicate" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Es una Guía duplicada</label>
    </div>
    
    
    {{ Form::hidden('id_user', Auth::user()->id, ['id' => 'id_user']) }}
    {{ Form::hidden('update_user', Auth::user()->id, ['id' => 'update_user']) }}
    {{ Form::hidden('id_flight', $flight->id, ['id' => 'id_flight']) }}
    
</div>

