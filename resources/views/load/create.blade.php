@extends('layouts.principal')

@section('title') Crear Maritimo | Sistema de Carguera v1.1 @stop

@section('content')
<section class="content-header">
    <div class="container-fluid">
       <div class="row mb-2">
          <div class="col-sm-6">
             <h1>Crear Maritimo
                
             </h1>
          </div>
          <div class="col-sm-6">
             <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('load.index') }}">Maritimos</a></li>
                <li class="breadcrumb-item active">Crear Maritimo</li>
             </ol>
          </div>
       </div>
    </div><!-- /.container-fluid -->
 </section>



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Crear Maritimo
                </div>

                <div class="card-body">
                    
                   @include('custom.message')

                     {{ Form::open(['route' => 'load.store', 'class' => 'form-horizontal']) }}
                        @include('load.partials.form')
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
      let num_pallet = document.getElementById('hide')
      num_pallet.style.display = 'none'
      let piso = document.getElementById('floor')
      let pallet = document.getElementById('num_pallets')

      piso.addEventListener('change', (e) => {
         if(piso.value === 'si')
         {
            num_pallet.style.display = 'block'
         }else{
            num_pallet.style.display = 'none'
            pallet.value = 0
         }
      });
      
   </script>
@endsection
