<div class="row">
    <div class="col-md-6 form-group">
        {{ Form::label('name', 'Nombre de la Empresa', ['class' => 'control-label']) }}
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" wire:model="name">
    </div>
    <div class="col-md-2 form-group">
        {{ Form::label('ruc', 'RUC', ['class' => 'control-label']) }}
        <input type="text" name="ruc" class="form-control @error('ruc') is-invalid @enderror" wire:model="ruc">
    </div>
    <div class="col-md-4 form-group">
        {{ Form::label('phone', 'Teléfono', ['class' => 'control-label']) }}
        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" wire:model="phone">
    </div>
    <div class="col-md-6 form-group">
        {{ Form::label('address', 'Dirección', ['class' => 'control-label']) }}
        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" wire:model="address">
    </div>
    <div class="col-md-2 form-group">
        {{ Form::label('state', 'Estado', ['class' => 'control-label']) }}
        <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" wire:model="state">
    </div>
    <div class="col-md-2 form-group">
        {{ Form::label('city', 'Ciudad', ['class' => 'control-label']) }}
        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" wire:model="city">
    </div>
    <div class="col-md-2 form-group">
        {{ Form::label('country', 'País', ['class' => 'control-label']) }}
        <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" wire:model="country">
    </div>
    
    <div class="col-md-4 form-group">
        {{ Form::label('active', 'Cargamos actualmente', ['class' => 'control-label']) }}

        <div class="form-check">
            <input class="form-check-input" type="radio" name="active" wire:model="active" value="no" checked>
            <label class="form-check-label @error('active') is-invalid @enderror" for="active1">
              No
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="active" wire:model="active" value="yes">
            <label class="form-check-label @error('active') is-invalid @enderror" for="active2">
              Si
            </label>
          </div>
    </div>
</div>
