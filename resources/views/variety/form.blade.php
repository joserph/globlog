<div class="row">
    <div class="col-md-6 form-group">
        {{ Form::label('name', 'Variedad', ['class' => 'control-label']) }}
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" wire:model="name">
    </div>

    <div class="col-md-6 form-group">
        {{ Form::label('scientific_name', 'Nombre Cientifico', ['class' => 'control-label']) }}
        <input type="text" name="scientific_name" class="form-control @error('scientific_name') is-invalid @enderror" wire:model="scientific_name">
    </div>
</div>

