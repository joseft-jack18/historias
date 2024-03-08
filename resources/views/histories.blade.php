@extends('layout.plantilla')

@section('titulo', 'Historias Clinicas')

@section('contenido')

    <!-- Main content -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Listado de Historias Clínicas</h1>
                    <input type="hidden" name="mensaje" id="mensaje" value="{{ Session::get('success') }}">
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">F. Consulta</th>
                                        <th class="text-center">Motivo</th>
                                        <th class="text-center">Observaciones</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($histories as $history)
                                    <tr>
                                        <td class="text-center">{{ $history->id }}</td>
                                        <td class="text-center">{{ $history->created_at }}</td>
                                        <td>{{ $history->reason_consultation }}</td>
                                        <td>{{ $history->observations }}</td>
                                        <td class="text-center">
                                            <a href="#" target="_blank" class="btn">
                                                <i class='bx bx-edit bx-sm' style="color: #E3AF0C"></i>
                                            </a>

                                            <a href="{{ route('history.pdf_history', $history->id) }}" target="_blank" class="btn">
                                                <i class="bx bxs-file-pdf bx-sm" style="color: #D11111"></i>
                                            </a>
                                            <a href="{{ route('history.pdf_procedure', $history->id) }}" target="_blank" class="btn">
                                                <i class='bx bx-list-ol bx-sm' style="color: #46B8B6"></i>
                                            </a>
                                            <a href="{{ route('history.pdf_medical', $history->id) }}" target="_blank" class="btn">
                                                <i class='bx bx-receipt bx-sm' style="color: #0A2F92"></i>
                                            </a>

                                            <a href="#" class="btn">
                                                <i class="bx bx-archive-in bx-sm" style="color: #158A12"></i>
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

@section('js')

    <script>
        let mensaje = $('#mensaje').val();
        if(mensaje != ''){
            toastr.success(mensaje)
        }
    </script>

@endsection
