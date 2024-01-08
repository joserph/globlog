<div class="row">
    <div class="col-md-5 form-group">
        {{ Form::label('name', 'Nonbre de Marcación', ['class' => 'control-label']) }}
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" wire:model="name">
    </div>
    <div class="col-md-2 form-group">
        {{ Form::label('phone', 'Teléfono', ['class' => 'control-label']) }}
        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" wire:model="phone">
    </div>
    <div class="col-md-3 form-group">
        {{ Form::label('email', 'Correo', ['class' => 'control-label']) }}
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" wire:model="email">
    </div>
    <div class="col-md-2 form-group">
        {{ Form::label('zip_code', 'Zip code', ['class' => 'control-label']) }}
        <input type="text" name="zip_code" class="form-control @error('zip_code') is-invalid @enderror" wire:model="zip_code">
    </div>
    <div class="col-md-2 form-group">
        {{ Form::label('state', 'Estado', ['class' => 'control-label']) }}
        <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" wire:model="state">
    </div>
    <div class="col-md-2 form-group">
        {{ Form::label('city', 'Ciudad', ['class' => 'control-label']) }}
        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" wire:model="city">
    </div>
    <div class="col-md-6 form-group">
        {{ Form::label('address', 'Dirección', ['class' => 'control-label']) }}
        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" wire:model="address">
    </div>
    
    <div class="col-md-2 form-group">
        {{ Form::label('country', 'País', ['class' => 'control-label']) }}
        <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" wire:model="country">
    </div>
    <div class="col-md-4 form-group">
        {{ Form::label('owner', 'Propieatrio', ['class' => 'control-label']) }}
        <input type="text" name="owner" class="form-control @error('owner') is-invalid @enderror" wire:model="owner">
    </div>
    <div class="col-md-4 form-group">
        {{ Form::label('sub_owner', 'Sub Propieatrio', ['class' => 'control-label']) }}
        <input type="text" name="sub_owner" class="form-control @error('sub_owner') is-invalid @enderror" wire:model="sub_owner">
    </div>
    <div class="col-md-2 form-group">
        {{ Form::label('sub_owner_phone', 'Teléfono Sub Propieatrio', ['class' => 'control-label']) }}
        <input type="text" name="sub_owner_phone" class="form-control @error('sub_owner_phone') is-invalid @enderror" wire:model="sub_owner_phone">
    </div>
    <div class="col-md-6 form-group">
        {{ Form::label('related_names', 'Nombres Relacionados', ['class' => 'control-label']) }}
        <input type="text" name="related_names" class="form-control @error('related_names') is-invalid @enderror" wire:model="related_names">
    </div>
    <div class="col-md-4 form-group">
        {{ Form::label('buyer', 'Broker/Comprador', ['class' => 'control-label']) }}
        <input type="text" name="buyer" class="form-control @error('buyer') is-invalid @enderror" wire:model="buyer">
    </div>
    <div class="col-md-3 form-group">
        {{ Form::label('type_load', 'Tipo de Carga', ['class' => 'control-label']) }}
        <select name="type_load" id="type_load" class="custom-select  @error('type_load') is-invalid @enderror" wire:model="type_load">
            <option value="">Seleccione Tipo de Carga</option>
            <option value="AEREO">AÉREO</option>
            <option value="MARITIMO">MARÍTIMO</option>
            <option value="AEREO/MARITIMO">AÉREO/MARÍTIMO</option>
        </select>
    </div>
    <div class="col-md-3 form-group">
        {{ Form::label('delivery', 'Delivery/Pick Up', ['class' => 'control-label']) }}
        <select name="delivery" id="delivery" class="custom-select  @error('delivery') is-invalid @enderror" wire:model="delivery">
            <option value="">Seleccione Delivery/Pick Up</option>
            <option value="BODEGA LOS ANGELES">BODEGA LOS ANGELES</option>
            <option value="EDG LOGISTIC">EDG LOGISTIC</option>
            <option value="DIRECTO CLIENTE">DIRECTO CLIENTE</option>
            <option value="POMONA">POMONA</option>
        </select>
    </div>
    <div class="col-md-3 form-group">
        {{ Form::label('method_payment', 'Forma de Pago', ['class' => 'control-label']) }}
        <select name="method_payment" id="method_payment" class="custom-select  @error('method_payment') is-invalid @enderror" wire:model="method_payment">
            <option value="">Seleccione Forma de Pago</option>
            <option value="EFECTIVO">EFECTIVO</option>
            <option value="CHEQUE">CHEQUE</option>
            <option value="ZELLER">ZELLER</option>
        </select>
    </div>
    <div class="col-md-12 form-group">
        {{ Form::label('poa', 'POA', ['class' => 'control-label']) }}
    </div>
    <div class="col-md-2 form-group">
        <div class="form-check form-check-inline">
            <input class="form-check-input @error('poa') is-invalid @enderror" type="radio" name="poa" id="yes" wire:model="poa" value="yes">
            <label class="form-check-label" for="yes">Si</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input @error('poa') is-invalid @enderror" type="radio" name="poa" id="no" wire:model="poa" value="no">
            <label class="form-check-label" for="no">No</label>
        </div>
    </div>
</div>
