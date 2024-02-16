@extends('layout.plantilla')

@section('titulo', 'Historias Clinicas')

@section('contenido')

    <!-- Main content -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Listado de Pacientes</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('persons.create') }}">
                                <button type="button" class="btn btn-success btn-sm"><i class='bx bx-user-plus'></i> Agregar</button>
                            </a>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 250px; height: 2px;">
                                    <input type="text" name="table_search" class="form-control float-right" placeholder="Buscar">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Nro. Historia</th>
                                        <th class="text-center">Paciente</th>
                                        <th class="text-center">Edad</th>
                                        <th class="text-center">Teléfono</th>
                                        <th class="text-center">Editar</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datos as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->id }}</td>
                                        <td class="text-center">{{ $item->number }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td class="text-center">{{ $item->age }} años</td>
                                        <td class="text-center">{{ $item->telephone }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('persons.edit', $item->id) }}" method="GET">
                                                <button class="btn">
                                                    <i class='bx bx-edit bx-sm' style="color: #EFAA0B"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="btn">
                                                <i class='bx bx-folder-plus bx-sm' style="color: #138623"></i>
                                            </a>
                                            <a href="#" class="btn">
                                                <i class='bx bx-folder-open bx-sm' style="color: #C10814"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
