@extends('layouts.principal')

@section('title') Crear Vuelo | Sistema de Carguera v1.1 @stop

@section('content')
<section class="content-header">
    <div class="container-fluid">
       <div class="row mb-2">
          <div class="col-sm-6">
             <h1>Crear Vuelo
                
             </h1>
          </div>
          <div class="col-sm-6">
             <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('flight.index') }}">Vuelos</a></li>
                <li class="breadcrumb-item active">Crear Vuelo</li>
             </ol>
          </div>
       </div>
    </div><!-- /.container-fluid -->
 </section>



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Crear Vuelo
                </div>

                <div class="card-body">
                    
                   @include('custom.message')

                     {{ Form::open(['route' => 'flight.store', 'class' => 'form-horizontal']) }}
                        @include('flight.partials.form')
                        <hr>
                        <div class="form-group row">
                           <div class="col-sm-12">
                              <button type="submit" class="btn btn-outline-primary"><i class="fas fa-plus-circle"></i></button>
                           </div>
                        </div>
                     {{ Form::close() }}
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
   <script>
      let awb = document.getElementById('awb')
      awb.addEventListener('blur', (e) => {
         let awb_value = e.target.value
         awb.value = awb_value.replace(/-/gi, ' ')
         // Reempalzar AWB
         let = new_awb = awb.value
         awb.value = new_awb.replace('AWB ', '')
      })
   </script>
@endsection