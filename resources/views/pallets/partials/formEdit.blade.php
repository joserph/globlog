<div class="row">
    {!! Form::hidden('update_user', \Auth::user()->id) !!}
    <input type="hidden" name="id_load" value="{{ $item->id_load }}">
    <input type="hidden" name="id" value="{{ $item->id }}">
    {!! Form::hidden('edit_pallet', 1) !!}
 
    <div class="col-md-4 form-group">
       {{ Form::label('number', 'Número', ['class' => 'control-label']) }}
       <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">{{ $load->shipment }} -</span>
          <input type="number" name="number1" class="form-control" readonly value="{{ $item->counter }}">
            <input type="hidden" name="counter" value="{{ $item->counter }}">
          <input type="hidden" name="number" value="{{ $item->number }}">
       </div>
    </div>
    <div class="col-md-12 form-group">
       {{ Form::label('usda', 'USDA', ['class' => 'control-label']) }}
       <div class="col-sm-2">
          <input type="checkbox" name="usda" @if($item->usda) checked @endif>
       </div>
    </div>
 </div>
                             
                  