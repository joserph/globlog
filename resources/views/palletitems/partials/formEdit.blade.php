<div class="row">
    <div class="col-md-12 form-group">
        {{ Form::label('id_farm', 'Finca', ['class' => 'control-label']) }}
        <div class="input-group mb-12">
            <select class="form-control" name="id_farm" id="edit_farmsList_{{ $item2->id }}">
                <option value="">Seleccione finca</option>
                @foreach($farmsList as $itemFarm)
                    <option value="{{ $itemFarm->id }}" {{ $itemFarm->id == $item2->id_farm ? 'selected' : '' }}>{{ $itemFarm->name }} {{ $itemFarm->tradename }}</option>
                @endforeach
            </select>
        </div>
        
    </div>

    <div class="col-md-12 form-group">
        {{ Form::label('id_client', 'Cliente', ['class' => 'control-label']) }}
        <div class="input-group mb-12">
            <div class="input-group mb-12">
                <select class="form-control" name="id_client" id="edit_clientsList_{{ $item2->id }}">
                    <option value="">Seleccione cliente</option>
                    @foreach($clientsList as $itemClient)
                        <option value="{{ $itemClient->id }}" {{ $itemClient->id == $item2->id_client ? 'selected' : '' }} >{{ str_replace('SAG-', '',  $itemClient->name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col form-group">
            {{ Form::label('hb', 'HB', ['class' => 'control-label']) }}
            <div class="input-group mb-12">
                <input type="number" value="{{ $item2->hb }}" name="hb" id="edit_hb_{{ $item2->id }}" value="0" class="form-control grupo">
            </div>
        </div>
        <div class="col form-group">
            {{ Form::label('qb', 'QB', ['class' => 'control-label']) }}
            <div class="input-group mb-12">
                <input type="number" value="{{ $item2->qb }}" name="qb" id="edit_qb_{{ $item2->id }}" value="0" class="form-control grupo">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col form-group">
            {{ Form::label('eb', 'EB', ['class' => 'control-label']) }}
            <div class="input-group mb-12">
                <input type="number" value="{{ $item2->eb }}" name="eb" id="edit_eb_{{ $item2->id }}" value="0" class="form-control grupo">
            </div>
        </div>
        <div class="col form-group">
            {{ Form::label('quantity', 'Total', ['class' => 'control-label']) }}
            <div class="input-group mb-12">
                <input type="number" value="{{ $item2->quantity }}" name="quantity" id="edit_total_{{ $item2->id }}" value="0" class="form-control grupo" readonly>
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



