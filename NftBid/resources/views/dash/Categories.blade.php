@extends('dash.layouts.main')

@section('contenido')
    <div class="Container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Categorias</h1>
            <a href="#" data-toggle="modal" data-target="#modalAdd" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-upload fa-sm text-white-50"></i> Agregar Categoria</a>
        </div>
            <!--Eroro-->
            @if ($message = Session::get('ErrorInsert'))
                <div class="row alert-ganger alert-dismissable fade show" role="alert">
                    <h5>Error:{{$message}}</h5>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <!-- SUCCESO -->
                @if ($mensaje = Session::get('Listo'))
                    <div class="row alert alert-success fade show">
                        <h5 class="col-12"><i class="fa fa-check"></i>Alerta</h5>
                        <br>
                        <br>
                        <p>{{ $mensaje}}</p>
                    </div>
                @endif       
                <!-- Print Categories -->
                <div class="row col-12">
                    @foreach ($cates as $c)
                    <div class="card col-3">
                        <img class="card-img-top" src="{{ asset('/categories/'.$c->img)}}" alt="Card image cap">
                        <div class="card-body">
                          <h5 class="card-title">{{$c->category}}</h5>
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </div>
                      </div>
                    </div>
                @endforeach
            </div>

            <!-- MODAL AGREGAR -->
            <div class="modal" tabindex="-1" role="dialog" id="modalAdd">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">Agregar Categorias</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>


                    <form action="/admin/categorias" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Nombre</label>
                            <input type="text" class="form-control" placeholder="Categoria" name="name" value="{{ old ('name') }}">
                                
                        </div>
                        <div class="form-group">
                            <label for="">Imagen</label>
                            <input type="file" class="form-control" name="img" value="{{ old('img') }}">
                        </div> 
                    </div>

                    
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-save"></i> Guardar</button>
                    </div>
                    </form>
                </div>
                </div>
            </div>
    </div>
@endsection



