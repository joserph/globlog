<div class="row">
    <div class="col-md-4 form-group">
       {{ Form::label('', 'N° Carga', ['class' => 'control-label']) }}
       <input type="text" class="form-control" value="{{ $load->shipment }}" readonly>
       <input type="hidden" name="id_load" class="form-control" value="{{ $load->id }}">
    </div>
    <div class="col-md-4 form-group">
       {{ Form::label('', 'BL', ['class' => 'control-label']) }}
       <input type="text" class="form-control" name="bl" value="{{ $load->bl }}" readonly>
    </div>
    <div class="col-md-4 form-group">
       {{ Form::label('', 'Mi Empresa', ['class' => 'control-label']) }}
       <input type="text" name="" class="form-control" value="{{ $company->name }}" readonly>
       <input type="hidden" class="form-control" value="{{ $company->id }}" name="id_company">
    </div>
    <div class="col-md-4 form-group">
       {{ Form::label('id_logistics_company', 'Empresa de Logística', ['class' => 'control-label']) }}
       @isset($load->logistic_company->name)
         <input type="text" name="" class="form-control" value="{{ $load->logistic_company->name }}" readonly>
         <input type="hidden" class="form-control" value="{{ $load->id_logistic_company }}" name="id_logistics_company">
      @else
         <input type="text" name="" class="form-control" value="{{ $lc_active->name }}" readonly>
         <input type="hidden" class="form-control" value="{{ $lc_active->id }}" name="id_logistics_company">
      @endisset
    </div>
    <div class="col-md-4 form-group">
       {{ Form::label('invoice', 'N° de Factura', ['class' => 'control-label']) }}
       <input type="text" name="invoice" value="{{ $invoiceheaders->invoice }}" class="form-control @error('invoice') is-invalid @enderror" name="invoice">
    </div>
    <div class="col-md-4 form-group">
       {{ Form::label('date', 'Fecha', ['class' => 'control-label']) }}
       <input type="date" name="date" value="{{ $invoiceheaders->date }}" class="form-control @error('date') is-invalid @enderror" name="date">
    </div>
    {{ Form::hidden('update_user', Auth::user()->id )}}
    {{ Form::hidden('carrier', $load->carrier )}}
 </div>