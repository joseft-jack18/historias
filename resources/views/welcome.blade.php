@extends('layout.plantilla')

@section('titulo', 'Historias Clinicas')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css">
@endsection

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
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="display" id="example" style="width:100%">
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
                                            <a href="{{ route('history.create', $item->id) }}" class="btn">
                                                <i class='bx bx-folder-plus bx-sm' style="color: #138623"></i>
                                            </a>
                                            <a href="{{ route('history.index', $item->id) }}" class="btn">
                                                <i class='bx bx-folder-open bx-sm' style="color: #C10814"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="clearfix mt-2">
                                <ul class="pagination pagination-sm m-0 float-right">
                                    {{ $datos->links() }}
                                </ul>
                            </div>
                        </div>

                        <!-- /.card-body -->

                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>

    <script>
        $('#example').DataTable({
            "scrollX": true,
            "info": false,
            "lengthChange": false,
            "pageLength": 5,
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });
    </script>
@endsection
