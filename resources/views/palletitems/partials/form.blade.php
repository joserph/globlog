<div class="row">
    <div class="col-md-12 form-group">
        {{ Form::label('id_farm', 'Finca', ['class' => 'control-label']) }}
        <div class="input-group mb-12">
            <select class="form-control" name="id_farm" id="farmsList_{{ $item->id }}">
                <option value="">Seleccione finca</option>
                @foreach($farmsList as $itemFarm)
                  <option value="{{ $itemFarm->id }}">{{ $itemFarm->name }} {{ $itemFarm->tradename }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-12 form-group">
        {{ Form::label('id_client', 'Cliente', ['class' => 'control-label']) }}
        <div class="input-group mb-12">
            <select class="form-control" name="id_client" id="clientsList_{{ $item->id }}">
                <option value="">Seleccione cliente</option>
                @foreach($clientsList as $itemClient)
                  <option value="{{ $itemClient->id }}">{{ str_replace('SAG-', '', $itemClient->name) }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col form-group">
        {{ Form::label('hb', 'HB', ['class' => 'control-label']) }}
        <div class="input-group mb-12">
            <input type="number" name="hb" id="hb_{{ $item->id }}" value="0" class="form-control grupo">
        </div>
    </div>
    <div class="col form-group">
        {{ Form::label('qb', 'QB', ['class' => 'control-label']) }}
        <div class="input-group mb-12">
            <input type="number" name="qb" id="qb_{{ $item->id }}" value="0" class="form-control grupo">
        </div>
    </div>
</div>
<div class="row">
    <div class="col form-group">
        {{ Form::label('eb', 'EB', ['class' => 'control-label']) }}
        <div class="input-group mb-12">
            <input type="number" name="eb" id="eb_{{ $item->id }}" value="0" class="form-control grupo">
        </div>
    </div>
    <div class="col form-group">
        {{ Form::label('quantity', 'Total', ['class' => 'control-label']) }}
        <div class="input-group mb-12">
            <input type="number" name="quantity" id="total_{{ $item->id }}" value="0" class="form-control grupo" readonly>
        </div>
    </div>
</div>
<div class="row">
    <div class="col form-group">
        {{ Form::label('piso', 'Piso', ['class' => 'control-label']) }}
        <div class="input-group mb-12">
            {{ Form::checkbox('piso', 'value', false) }}
        </div>
    </div>
</div>




