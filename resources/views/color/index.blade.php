@extends('layouts.principal')

@section('title') Colores | Sistema de Carguera v1.1 @stop

@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Colores
               @can('haveaccess', 'color.create')
                  <a href="{{ route('color.create') }}" class="btn btn-outline-primary"><i class="fas fa-plus-circle"></i></a>
               @endcan
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item active">Colores</li>
            </ol>
         </div>
      </div>
   </div><!-- /.container-fluid -->
</section>

<section class="content">
   <div class="container-fluid">
      <div class="row">
         <!-- /.col -->
         <div class="col-md-12">
            @can('haveaccess', 'color.index')
               <div class="card">
                  <div class="card-header">
                     <h3 class="card-title">Lista de Colores</h3>
                     <div class="card-tools">
                        {{ $colors->links() }}
                     </div>
                  </div>
   
                  @include('custom.message') 
   
                  <!-- /.card-header -->
                  <div class="card-body table-responsive p-0">
                     <table class="table table-sm">
                        <thead class="thead-dark">
                           <tr>
                              <th scope="col">Tipo</th>
                              <th scope="col">Nombre</th>
                              <th scope="col">Color</th>
                              <th scope="col">Etiqueta</th>
                              <th scope="col">Tipo de Carga</th>
                              <th class="text-center" width="80px" colspan="2">@can('haveaccess', 'color.edit')Editar @endcan @can('haveaccess', 'color.destroy')Eliminar @endcan</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($colors as $color)
                              <tr>
                                 <td>
                                    @if ($color->type == 'client')
                                       Cliente
                                    @else 
                                       Finca
                                    @endif
                                 </td>
                                 <td>
                                    @if ($color->type == 'client')
                                       @foreach ($clients as $item)
                                          @if ($color->id_type == $item->id)
                                             {{ $item->name }}
                                          @endif
                                       @endforeach
                                    @else
                                       @foreach ($farms as $farm)
                                          @if ($color->id_type == $farm->id)
                                             {{ $farm->name }}
                                          @endif
                                       @endforeach
                                    @endif
                                 </td>
                                 <td>
                                    <svg width="20" height="20">
                                       <circle cx="15" cy="15" r="25" stroke="black" stroke-width="4" fill="{{ $color->color }}" />
                                       Sorry, your browser does not support inline SVG.
                                    </svg>
                                 </td>
                                 <td>
                                    @if ($color->label == 'square')
                                       <h5><span class="badge badge-success">Cuadrado</span></h5>
                                    @else 
                                       <h5><span class="badge badge-warning">Punto</span></h5>
                                    @endif
                                 </td>
                                 <td>
                                    @if ($color->load_type == 'aereo')
                                       <span class="badge badge-info">AÉREO</span>
                                    @elseif($color->load_type == 'maritimo')
                                       <span class="badge badge-dark">MARÍTIMO</span>
                                    @endif
                                    
                                    
                                 </td>
                                 <td width="45px" class="text-center">
                                    @can('haveaccess', 'color.edit')
                                       <a href="{{ route('color.edit', $color->id) }}" class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    @endcan
                                 </td>
                                 <td width="45px" class="text-center">
                                    @can('haveaccess', 'color.destroy')
                                       {{ Form::open(['route' => ['color.destroy', $color->id], 'method' => 'DELETE']) }}
                                          {{ Form::button('<i class="fas fa-trash-alt"></i> ' . '', ['type' => 'submit', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Eliminar Vuelo', 'class' => 'btn btn-sm btn-outline-danger', 'onclick' => 'return confirm("¿Seguro de eliminar el color?")']) }}
                                       {{ Form::close() }}
                                    @endcan
                                 </td>
                              </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
                  <!-- /.card-body -->
               </div>
            @endcan
            <!-- /.card -->
         </div>
      </div>
   </div>
</section>
@endsection
