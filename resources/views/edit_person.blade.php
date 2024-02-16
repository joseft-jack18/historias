@extends('layout.plantilla')

@section('titulo', 'Historias Clinicas')

@section('contenido')

    <!-- Main content -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Editar Paciente</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card">
                        <!-- form start -->
                        <form action="{{ route('persons.update', $person->id) }}" method="POST">
                            @csrf
                            @method("PUT")
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="id">Id Paciente</label>
                                            <input type="text" class="form-control" id="id" name="id" value="{{ $person->id }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="identity_document_type_id">Tipo Documento</label>
                                            <select class="form-control" id="identity_document_type_id" name="identity_document_type_id">
                                                @foreach ($document_types as $type)
                                                <option value="{{ $type->id }}" @if($type->id == $person->identity_document_type_id) selected @endif>{{ $type->description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="number">Nro Documento</label>
                                            <input type="text" class="form-control" id="number" name="number" value="{{ $person->number }}" placeholder="Ingrese el número de documento" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Apellidos y Nombres</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ $person->name }}" placeholder="Ingrese los nombres completos" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="birthdate">Fecha de Nacimiento</label>
                                            <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ $person->birthdate }}" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="email">Correo Electrónico</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ $person->email }}" placeholder="Ingrese el correo del paciente">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="telephone">Celular</label>
                                            <input type="text" class="form-control" id="telephone" name="telephone" value="{{ $person->telephone }}" placeholder="Ingrese el celular del paciente" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="country_id">País</label>
                                            <select class="form-control" id="country_id" name="country_id">
                                                @foreach ($countries as $country)
                                                <option value="{{ $country->id }}" @if($country->id == $person->country_id) selected @endif>{{ $country->description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>                                    
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label for="address">Dirección</label>
                                            <input type="text" class="form-control" id="address" name="address" value="{{ $person->address }}" placeholder="Ingrese la dirección del paciente" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success"><i class='bx bx-save'></i> Editar</button>
                                <a href="{{ route('persons.index') }}">
                                    <button type="button" class="btn btn-default"><i class='bx bx-chevrons-left'></i> Cancelar</button>
                                </a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->  
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection