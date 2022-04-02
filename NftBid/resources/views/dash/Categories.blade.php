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
                          <h5 class="card-title">{{ $c->category }}</h5>
                          <button class="btn btn-primary btn-sm btnEdit" 
                            data-id="{{$c-id}}"
                            data-category="{{ $c->category}}"
                            data-target="#modaUpdate" 
                            data-toggle="modal">
                              <i class="fa fa-edit"></i></button>
                          <form action="{{ url('/admin/Categorias',['id'=>$c->id]) }}"
                            method="POST" id="formDelete_{{$c->id}}">
                              @csrf
                              <input type="hidden" value="{{$c->id}}" name="id">
                              <input type="hidden" name="_method" value="delete">
                          </form>
                        <button class="btn btn-sm btn-danger btnEliminar" data-id="{{ $c->id }}" 
                            data-target="#modalDelete" 
                            data-toggle="modal">
                            <i class="fa fa-trash"></i></button>
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


                    <form action="/admin/Categorias" method="POST" enctype="multipart/form-data">
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

            <!--Modal Eliminar-->
            <div class="modal" tabindex="-1" role="dialog" id="modalDelete">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Eliminar Reguistro</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p>Deseas eliminar el Reguistro?.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Canselar</button>  
                      <button type="button" class="btn btn-danger" id="doEliminar">Eliminar</button
                    </div>
                  </div>
                </div>
              </div>
    
            </div>

            <!-- MODAL UpDate -->
            <div class="modal" tabindex="-1" role="dialog" id="modalUpdate">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">Agregar Categorias</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>


                    <form action="/admin/Categorias/update" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="id" id="idEdit">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Nombre</label>
                            <input id="nameEdit" type="text" class="form-control" placeholder="Categoria" name="name" value="{{ old ('name') }}">
                                
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
@endsection

@section('scripts')
    <script>
        var idEliminar=0;
        $(document).ready(function(){
            $(".btnEliminar").click(function(){
                var id= $(this).data('id');
                idEliminar = id;
            });
            $("#doEliminar").click(function(){
                $("#formDelete_"+idEliminar).submit();
            });
            $(".btnEdit").click(function(){
                var id = $(this).data('id');
                var cate = $(this).data('category');
                $("nameEdit").val(cate);
                $("#idEdit").val(id);
            });
        });
    </script>
@endsection

