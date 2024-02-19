@extends('layout.plantilla')

@section('titulo', 'Historias Clinicas')

@section('contenido')

    <!-- Main content -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Nueva Historia Clínica</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <!-- general form elements -->
                    <div class="card">
                        <!-- form start -->
                        <form action="{{ route('persons.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="card card-primary card-outline card-outline-tabs">
                                    <div class="card-header p-0 pt-1 border-bottom-0">
                                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="enfermedad-tab" data-toggle="pill" href="#enfermedad" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Enfermedades</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="antecedentes-tab" data-toggle="pill" href="#antecedentes" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Antecedentes</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="examenes-tab" data-toggle="pill" href="#examenes" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">Ex. Físico</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="diagnosticos-tab" data-toggle="pill" href="#diagnosticos" role="tab" aria-controls="custom-tabs-three-settings" aria-selected="false">Diagnósticos</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="planes-tab" data-toggle="pill" href="#planes" role="tab" aria-controls="custom-tabs-three-settings" aria-selected="false">Planes</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="tratamientos-tab" data-toggle="pill" href="#tratamientos" role="tab" aria-controls="custom-tabs-three-settings" aria-selected="false">Tratamientos</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="observaciones-tab" data-toggle="pill" href="#observaciones" role="tab" aria-controls="custom-tabs-three-settings" aria-selected="false">Observaciones</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content" id="custom-tabs-three-tabContent">
                                            <div class="tab-pane fade show active" id="enfermedad" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                                <div class="row g-3">
                                                    <div class="col-md-2 mb-2">
                                                        <label for="numero" class="form-label">T. Enfermedad</label>
                                                        <input type="text" class="form-control" id="numero" name="numero">
                                                        <input type="hidden" class="form-control" id="person_id" name="person_id" value="{{ $person->id }}">
                                                    </div>

                                                    <div class="col-md-3 mb-2">
                                                        <label for="tiempo" class="form-label">&nbsp;</label><br>
                                                        <select class="custom-select rounded-0" id="tiempo" name="tiempo">
                                                            <option value="0" selected>--Seleccione--</option>
                                                            <option value="1">Horas</option>
                                                            <option value="2">Dias</option>
                                                            <option value="3">Meses</option>
                                                            <option value="4">Años</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-7 mb-2">
                                                        <label for="motivo_consulta" class="form-label">Motivo de Consulta</label>
                                                        <input type="text" class="form-control" id="motivo_consulta" name="motivo_consulta">
                                                    </div>

                                                    <div class="col-md-12 mb-2">
                                                        <label for="sintomas_principales" class="form-label">Signos y Síntomas principales</label>
                                                        <textarea class="form-control" id="sintomas_principales" name="sintomas_principales" rows="3"></textarea>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="sed" class="form-label">Sed</label>
                                                        <select class="custom-select rounded-0" id="sed" name="sed">
                                                            <option value="0" selected>--Seleccione--</option>
                                                            <option value="1">Disminuido</option>
                                                            <option value="2">Normal</option>
                                                            <option value="3">Aumentado</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="apetito" class="form-label">Apetito</label>
                                                        <select class="custom-select rounded-0" id="apetito" name="apetito">
                                                            <option value="0" selected>--Seleccione--</option>
                                                            <option value="1">Disminuido</option>
                                                            <option value="2">Normal</option>
                                                            <option value="3">Aumentado</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="sueño" class="form-label">Sueño</label>
                                                        <select class="custom-select rounded-0" id="sueño" name="sueño">
                                                            <option value="0" selected>--Seleccione--</option>
                                                            <option value="1">Disminuido</option>
                                                            <option value="2">Normal</option>
                                                            <option value="3">Aumentado</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="ritmo_urinario" class="form-label">Ritmo Urinario</label>
                                                        <select class="custom-select rounded-0" id="ritmo_urinario" name="ritmo_urinario">
                                                            <option value="0" selected>--Seleccione--</option>
                                                            <option value="1">Disminuido</option>
                                                            <option value="2">Normal</option>
                                                            <option value="3">Aumentado</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="ritmo_evacuatorio" class="form-label">Ritmo Evacuatorio</label>
                                                        <select class="custom-select rounded-0" id="ritmo_evacuatorio" name="ritmo_evacuatorio">
                                                            <option value="0" selected>--Seleccione--</option>
                                                            <option value="1">Disminuido</option>
                                                            <option value="2">Normal</option>
                                                            <option value="3">Aumentado</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="antecedentes" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                                                <div class="row g-3">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="antecedentes_personales" class="form-label">Antecedentes Personales</label>
                                                        <textarea class="form-control" id="antecedentes_personales" name="antecedentes_personales" rows="3">{{ $personHistory->personal_history }}</textarea>
                                                    </div>

                                                    <div class="col-md-12 mb-3">
                                                        <label for="antecedentes_alergias" class="form-label">Antecedentes de Alergias</label>
                                                        <textarea class="form-control" id="antecedentes_alergias" name="antecedentes_alergias" rows="3">{{ $personHistory->allergies_history }}</textarea>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label for="antecedentes_familiares" class="form-label">Antecedentes Familiares</label>
                                                        <textarea class="form-control" id="antecedentes_familiares" name="antecedentes_familiares" rows="3">{{ $personHistory->family_history }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="examenes" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">
                                                <div class="row g-3">
                                                    <div class="col-md-4 mb-2">
                                                        <label for="frecuencia_cardiaca" class="form-label">Frec. Cardiaca (por minuto)</label>
                                                        <input type="text" class="form-control" id="frecuencia_cardiaca" name="frecuencia_cardiaca">
                                                    </div>

                                                    <div class="col-md-4 mb-2">
                                                        <label for="frecuencia_respiratoria" class="form-label">Frec. Respiratoria (por minuto)</label>
                                                        <input type="text" class="form-control" id="frecuencia_respiratoria" name="frecuencia_respiratoria">
                                                    </div>

                                                    <div class="col-md-4 mb-2">
                                                        <label for="presion_arterial" class="form-label">Presion Arterial (mmHg)</label>
                                                        <input type="text" class="form-control" id="presion_arterial" name="presion_arterial">
                                                    </div>

                                                    <div class="col-md-4 mb-2">
                                                        <label for="temperatura" class="form-label">Temperatura (°C)</label>
                                                        <input type="text" class="form-control" id="temperatura" name="temperatura">
                                                    </div>

                                                    <div class="col-md-2 mb-2">
                                                        <label for="peso" class="form-label">Peso (Kg)</label>
                                                        <input type="text" class="form-control" id="peso" name="peso">
                                                    </div>

                                                    <div class="col-md-2 mb-2">
                                                        <label for="talla" class="form-label">Talla (m)</label>
                                                        <input type="text" class="form-control" id="talla" name="talla">
                                                    </div>

                                                    <div class="col-md-4 mb-2">
                                                        <label for="imc" class="form-label">IMC</label>
                                                        <input type="text" class="form-control" id="imc" name="imc">
                                                    </div>

                                                    <div class="col-md-12 mb-2">
                                                        <label for="examen_general" class="form-label">Examen General</label>
                                                        <input type="HIDDEN" class="form-control" id="lotep" name="lotep" value="1">
                                                        <input type="HIDDEN" class="form-control" id="aparente" name="aparente" value="1">
                                                        <textarea class="form-control" id="examen_general" name="examen_general" rows="3"></textarea>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label for="examen_preferencial" class="form-label">Examen Preferencial</label>
                                                        <textarea class="form-control" id="examen_preferencial" name="examen_preferencial" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="diagnosticos" role="tabpanel" aria-labelledby="custom-tabs-three-settings-tab">
                                                <h5>Diagnosticos Presuntivos</h5>
                                                <input type="text" class="form-control" id="diagnostico_p">

                                                <div class="row" id="diagnosticos_presuntivos"></div>

                                                <br>
                                                <hr>

                                                <h5>Diagnosticos Definitivos</h5>
                                                <div id="rowd_1" class="row">
                                                    <div class="col-md-11">
                                                        <input type="text" class="form-control input_dd" name="nom_diagnosticod[]" id="nom_diagnosticod_1" placeholder="Diágnostico">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-success col-md-12" id="btn_add2"><i class="fa-solid fa-plus"></i></button>
                                                    </div>
                                                </div>
                                                <div class="row-fluid" id="diagnosticos_definitivos"></div>

                                                <br>
                                            </div>

                                            <div class="tab-pane fade" id="planes" role="tabpanel" aria-labelledby="custom-tabs-three-settings-tab">
                                                <div class="row g-3">
                                                    <div class="col-6 mb-3">
                                                        <h5>Exámenes de Laboratorio</h5>
                                                        <div id="rowl_1" class="row">
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="laboratorio[]" id="laboratorio_1">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button" class="btn btn-success col-md-12" id="btn_add3"><i class="fa-solid fa-plus"></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="row-fluid" id="laboratorio"></div>
                                                    </div>

                                                    <div class="col-6 mb-3">
                                                        <h5>Exámenes Radiológicos</h5>
                                                        <div id="rowr_1" class="row">
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="radiologia[]" id="radiologia_1">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button" class="btn btn-success col-md-12" id="btn_add4"><i class="fa-solid fa-plus"></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="row-fluid" id="radiologia"></div>
                                                    </div>

                                                    <div class="col-6">
                                                        <h5>Procedimientos Especiales</h5>
                                                        <div id="rowe_1" class="row">
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="procedimientos[]" id="procedimientos_1">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button" class="btn btn-success col-md-12" id="btn_add5"><i class="fa-solid fa-plus"></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="row-fluid" id="procedimiento"></div>
                                                    </div>

                                                    <div class="col-6">
                                                        <h5>Interconsultas</h5>
                                                        <div id="rowi_1" class="row">
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="interconsultas[]" id="interconsultas_1">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button" class="btn btn-success col-md-12" id="btn_add6"><i class="fa-solid fa-plus"></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="row-fluid" id="interconsulta"></div>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>

                                            <div class="tab-pane fade" id="tratamientos" role="tabpanel" aria-labelledby="custom-tabs-three-settings-tab">
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <div id="rowm_1" class="row">
                                                            <div class="col-8"><input type="text" class="form-control" name="nombre_medicamento[]" id="nombre_medicamento_1" placeholder="Nombre del Medicamento"></div>
                                                            <div class="col-4"><input type="text" class="form-control" name="forma[]" id="forma_1" placeholder="Forma"></div>
                                                            <div class="col-8"><input type="text" class="form-control" name="dosis[]" id="dosis_1" placeholder="Dosis"></div>
                                                            <div class="col-4"><input type="text" class="form-control" name="cantidad[]" id="cantidad_1" placeholder="Cantidad"></div>
                                                            <div class="col-8"></div>
                                                            <div class="col-4"><button type="button" class="btn btn-success col-md-12" id="btn_add7"><i class="fa-solid fa-plus"></i> AGREGAR MEDICAMENTO</button></div>
                                                        </div>
                                                        <div id="tratamientos"></div>
                                                        <br>
                                                    </div>

                                                    <div class="col-12">
                                                        <label for="medidas_higienica" class="form-label">Recomendaciones</label>
                                                        <textarea class="form-control" id="medidas_higienica" name="medidas_higienica" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="observaciones" role="tabpanel" aria-labelledby="custom-tabs-three-settings-tab">
                                                <div class="row g-3">
                                                    <div class="col-12 mb-2">
                                                        <label for="observaciones" class="form-label">Observaciones</label>
                                                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="proxima_cita" class="form-label">Próxima Cita</label>
                                                        <input type="date" class="form-control" id="proxima_cita" name="proxima_cita">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card -->
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success"><i class='bx bx-save'></i> Guardar</button>
                                <a href="{{ route('persons.index') }}">
                                    <button type="button" class="btn btn-default"><i class='bx bx-chevrons-left'></i> Cancelar</button>
                                </a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-md-3">
                    <!-- general form elements -->
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Datos del Paciente</h4>
                            <br>
                            <p class="card-text mt-0">
                                <div class="mb-3">
                                    <label for="num_hc" class="form-label">N° HC</label>
                                    <input type="text" class="form-control" id="num_hc" value="{{ $person->number }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="nombre_paciente" class="form-label">Apellidos y Nombres</label>
                                    <input type="text" class="form-control" id="nombre_paciente" value="{{ $person->name }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="edad" class="form-label">Edad</label>
                                    <input type="text" class="form-control" id="edad" value="{{ $person->age }} AÑOS" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="telefono" value="{{ $person->telephone }}" readonly>
                                </div>
                            </p>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

@section('js')

    <script>
        var diagnosticos_presuntivos = [];

        $('#diagnostico_p').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('search.autocomplete_dp') }}",
                    dataType: 'json',
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            minLength: 3, // Número mínimo de caracteres antes de que comience la autocompletar
            select: function(event, ui) {
                // Acción a realizar cuando se selecciona un elemento del autocompletado
                console.log(ui.item.id);
                // Ejemplo de acción: redirigir a una página con el valor seleccionado
                //window.location.href = "/detalle/" + selectedValue;
            }
        });

        function agregar_dp(){
            
        }
    </script>

@endsection