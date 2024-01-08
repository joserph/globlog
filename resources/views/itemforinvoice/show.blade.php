@extends('layouts.principal')

@section('title') Comercializadoras | Sistema de Carguera v1.1 @stop

@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Finca {{ $farm->name }}
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item active">Finca {{ $farm->name }}</li>
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
                @can('haveaccess', 'farm.show')
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Finca {{ $farm->name }}</h4>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col">
                                    <h2 class="text-center">MARÍTIMO</h2>
                                    <div class="timeline">
                                        @foreach ($farmInPallet as $item)
                                        <div class="time-label">
                                            <span class="bg-red">{{ $item->load_date }}</span>
                                        </div>
                                        <div>
                                            <i class="fas fa-envelope bg-blue"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="fas fa-clock"></i>-</span>
                                                <h3 class="timeline-header"><a href="#">{{ $item->bl }}</a> sent you an email</h3>
                                                <div class="timeline-body">
                                                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                                weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                                jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                                quora plaxo ideeli hulu weebly balihoo...
                                                </div>
                                                <div class="timeline-footer">
                                                    <a class="btn btn-primary btn-sm">Read more</a>
                                                    <a class="btn btn-danger btn-sm">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="time-label">
                                            <span class="bg-green">3 Jan. 2014</span>
                                        </div>
                                        
                                        <div>
                                            <i class="fas fa-clock bg-gray"></i>
                                        </div>
                                        @endforeach
                                        
                                    </div>
                                </div>
                                <div class="col">
                                    <h2 class="text-center">AÉREO</h2>
                                </div>
                            </div>
                        </div>
   
                  <!-- /.card-header -->
                  {{-- <div class="card-body table-responsive p-0">
                     <table class="table table-sm">
                        <thead class="thead-dark">
                           <tr>
                              <th scope="col">Nombre</th>
                              <th scope="col">Clientes</th>
                              <th class="text-center" width="80px" colspan="2">@can('haveaccess', 'marketer.edit')Editar @endcan @can('haveaccess', 'marketer.destroy')Eliminar @endcan</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($marketers as $marketer)
                              <tr>
                                 <td>{{ $marketer->name }}</td>
                                 <td>{{ $marketer->clients }}</td>
                                 <td width="45px" class="text-center">
                                    @can('haveaccess', 'marketer.edit')
                                       <a href="{{ route('marketer.edit', $marketer->id) }}" class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    @endcan
                                 </td>
                                 <td width="45px" class="text-center">
                                    @can('haveaccess', 'marketer.destroy')
                                       {{ Form::open(['route' => ['marketer.destroy', $marketer->id], 'method' => 'DELETE']) }}
                                          {{ Form::button('<i class="fas fa-trash-alt"></i> ' . '', ['type' => 'submit', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Eliminar Comercializadora', 'class' => 'btn btn-sm btn-outline-danger', 'onclick' => 'return confirm("¿Seguro de eliminar la comercializadora?")']) }}
                                       {{ Form::close() }}
                                    @endcan
                                 </td>
                              </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div> --}}
                  <!-- /.card-body -->
                    </div>
                @endcan
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>
@endsection
