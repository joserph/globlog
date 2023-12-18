<div class="row">
    <div class="col-md-3 form-group">
        {{ Form::label('id_client', 'Cliente', ['class' => 'control-label']) }}
        @isset ($distribution)
            <select class="form-control" name="id_client" id="id_clientEdit">
                <option value="">Seleccione cliente</option>
                @foreach($clientsList as $itemClient)
                <option value="{{ $itemClient->id }}" {{ $itemClient->id == $distribution->id_client ? 'selected' : '' }}>{{ str_replace('SAG-', '', $itemClient->name) }}</option>
                @endforeach
            </select>
        @else
            <select class="form-control select-client" name="id_client" id="id_client">
                <option value="">Seleccione cliente</option>
                @foreach($clientsList as $itemClient)
                <option value="{{ $itemClient->id }}">{{ $itemClient->name }}</option>
                @endforeach
            </select>
        @endisset
        
    </div>
    <div class="col-md-3 form-group">
        {{ Form::label('variety_id', 'Variedad', ['class' => 'control-label']) }}
        {{ Form::select('variety_id', $varieties, null, ['class' => 'form-control select-product', 'placeholder' => 'Seleccione tipo']) }}
    </div>
    <div class="col-md-6 form-group">
        {{ Form::label('id_flight', 'Seleccione Vuelo', ['class' => 'control-label']) }}
        @isset($distribution)
            <select class="form-control select-client" name="id_flight" id="id_flight">
                <option value="">Seleccione Vuelo</option>
                @foreach($flights_opens as $itemFlight)
                <option value="{{ $itemFlight->id }}" {{ $itemFlight->id == $distribution->id_flight ? 'selected' : '' }}>{{ $itemFlight->origin_city }} - {{ $itemFlight->destination_city }} ({{ $itemFlight->destination_country }}) {{ date('d/m/Y', strtotime($itemFlight->date)) }} - {{ Str::upper($itemFlight->airline->name) }}</option>
                @endforeach
            </select>
        @else
            <select class="form-control select-client" name="id_flight" id="id_flight">
                <option value="">Seleccione Vuelo</option>
                @foreach($flights_opens as $itemFlight)
                <option value="{{ $itemFlight->id }}">{{ $itemFlight->origin_city }} - {{ $itemFlight->destination_city }} ({{ $itemFlight->destination_country }}) {{ date('d/m/Y', strtotime($itemFlight->date)) }} - {{ Str::upper($itemFlight->airline->name) }}</option>
                @endforeach
            </select>
        @endisset
        
    </div>
    
    <h5 class="col-sm-12">
        <p class="lead">Coordinado</p>
        <hr>
    </h5>
    <div class="col-sm-2">
        {{ Form::label('hb', 'HB Coordinado', ['class' => 'control-label']) }}
        @isset($distribution)
        {{ Form::number('hb', null, ['class' => 'form-control']) }}
        @else
        {{ Form::number('hb', 0, ['class' => 'form-control']) }}
        @endisset
        
    </div>
    <div class="col-sm-2">
        {{ Form::label('qb', 'QB Coordinado', ['class' => 'control-label']) }}
        @isset($distribution)
        {{ Form::number('qb', null, ['class' => 'form-control']) }}
        @else
        {{ Form::number('qb', 0, ['class' => 'form-control']) }}
        @endisset
    </div>
    <div class="col-sm-2">
        {{ Form::label('eb', 'EB Coordinado', ['class' => 'control-label']) }}
        @isset($distribution)
        {{ Form::number('eb', null, ['class' => 'form-control']) }}
        @else
        {{ Form::number('eb', 0, ['class' => 'form-control']) }}
        @endisset
        
    </div>

    {{ Form::hidden('id_farm', Auth::user()->id_farm, ['id' => 'id_farm']) }}
    {{ Form::hidden('hb_r', 0, ['id' => 'hb_r']) }}
    {{ Form::hidden('qb_r', 0, ['id' => 'qb_r']) }}
    {{ Form::hidden('eb_r', 0, ['id' => 'eb_r']) }}
    {{ Form::hidden('returns', 0, ['id' => 'returns']) }}
    {{ Form::hidden('observation', null, ['id' => 'observation']) }}
    {{ Form::hidden('id_marketer', null, ['id' => 'id_marketer']) }}
    {{ Form::hidden('duplicate', 'no', ['id' => 'duplicate']) }}
    {{ Form::hidden('id_user', Auth::user()->id, ['id' => 'id_user']) }}
    {{ Form::hidden('update_user', Auth::user()->id, ['id' => 'update_user']) }}
    
</div>

