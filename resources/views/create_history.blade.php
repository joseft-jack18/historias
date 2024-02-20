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
                                                        <label for="quantity" class="form-label">T. Enfermedad</label>
                                                        <input type="text" class="form-control" id="quantity" name="quantity">
                                                        <input type="hidden" class="form-control" id="person_id" name="person_id" value="{{ $person->id }}">
                                                    </div>

                                                    <div class="col-md-3 mb-2">
                                                        <label for="time" class="form-label">&nbsp;</label><br>
                                                        <select class="custom-select rounded-0" id="time" name="time">
                                                            <option value="0" selected>--Seleccione--</option>
                                                            <option value="1">Horas</option>
                                                            <option value="2">Dias</option>
                                                            <option value="3">Meses</option>
                                                            <option value="4">Años</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-7 mb-2">
                                                        <label for="reason_consultation" class="form-label">Motivo de Consulta</label>
                                                        <input type="text" class="form-control" id="reason_consultation" name="reason_consultation">
                                                    </div>

                                                    <div class="col-md-12 mb-2">
                                                        <label for="main_symptoms" class="form-label">Signos y Síntomas principales</label>
                                                        <textarea class="form-control" id="main_symptoms" name="main_symptoms" rows="3"></textarea>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="thirst" class="form-label">Sed</label>
                                                        <select class="custom-select rounded-0" id="thirst" name="thirst">
                                                            <option value="0" selected>--Seleccione--</option>
                                                            <option value="1">Disminuido</option>
                                                            <option value="2">Normal</option>
                                                            <option value="3">Aumentado</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="appetite" class="form-label">Apetito</label>
                                                        <select class="custom-select rounded-0" id="appetite" name="appetite">
                                                            <option value="0" selected>--Seleccione--</option>
                                                            <option value="1">Disminuido</option>
                                                            <option value="2">Normal</option>
                                                            <option value="3">Aumentado</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="dream" class="form-label">Sueño</label>
                                                        <select class="custom-select rounded-0" id="dream" name="dream">
                                                            <option value="0" selected>--Seleccione--</option>
                                                            <option value="1">Disminuido</option>
                                                            <option value="2">Normal</option>
                                                            <option value="3">Aumentado</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="urinary_rhythm" class="form-label">Ritmo Urinario</label>
                                                        <select class="custom-select rounded-0" id="urinary_rhythm" name="urinary_rhythm">
                                                            <option value="0" selected>--Seleccione--</option>
                                                            <option value="1">Disminuido</option>
                                                            <option value="2">Normal</option>
                                                            <option value="3">Aumentado</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="evacuation_rhythm" class="form-label">Ritmo Evacuatorio</label>
                                                        <select class="custom-select rounded-0" id="evacuation_rhythm" name="evacuation_rhythm">
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
                                                        <label for="personal_history" class="form-label">Antecedentes Personales</label>
                                                        <textarea class="form-control" id="personal_history" name="personal_history" rows="3">{{ $personHistory->personal_history }}</textarea>
                                                    </div>

                                                    <div class="col-md-12 mb-3">
                                                        <label for="allergies_history" class="form-label">Antecedentes de Alergias</label>
                                                        <textarea class="form-control" id="allergies_history" name="allergies_history" rows="3">{{ $personHistory->allergies_history }}</textarea>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label for="family_history" class="form-label">Antecedentes Familiares</label>
                                                        <textarea class="form-control" id="family_history" name="family_history" rows="3">{{ $personHistory->family_history }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="examenes" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">
                                                <div class="row g-3">
                                                    <div class="col-md-4 mb-2">
                                                        <label for="heart_rate" class="form-label">Frec. Cardiaca (por minuto)</label>
                                                        <input type="text" class="form-control" id="heart_rate" name="heart_rate">
                                                    </div>

                                                    <div class="col-md-4 mb-2">
                                                        <label for="breathing_frequency" class="form-label">Frec. Respiratoria (por minuto)</label>
                                                        <input type="text" class="form-control" id="breathing_frequency" name="breathing_frequency">
                                                    </div>

                                                    <div class="col-md-4 mb-2">
                                                        <label for="blood_pressure" class="form-label">Presion Arterial (mmHg)</label>
                                                        <input type="text" class="form-control" id="blood_pressure" name="blood_pressure">
                                                    </div>

                                                    <div class="col-md-4 mb-2">
                                                        <label for="temperature" class="form-label">Temperatura (°C)</label>
                                                        <input type="text" class="form-control" id="temperature" name="temperature">
                                                    </div>

                                                    <div class="col-md-2 mb-2">
                                                        <label for="weight" class="form-label">Peso (Kg)</label>
                                                        <input type="text" class="form-control" id="weight" name="weight">
                                                    </div>

                                                    <div class="col-md-2 mb-2">
                                                        <label for="size" class="form-label">Talla (m)</label>
                                                        <input type="text" class="form-control" id="size" name="size">
                                                    </div>

                                                    <div class="col-md-4 mb-2">
                                                        <label for="imc" class="form-label">IMC</label>
                                                        <input type="text" class="form-control" id="imc" name="imc" >
                                                    </div>

                                                    <div class="col-md-12 mb-2">
                                                        <label for="general_exam" class="form-label">Examen General</label>
                                                        <textarea class="form-control" id="general_exam" name="general_exam" rows="3"></textarea>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label for="preferential_exam" class="form-label">Examen Preferencial</label>
                                                        <textarea class="form-control" id="preferential_exam" name="preferential_exam" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="diagnosticos" role="tabpanel" aria-labelledby="custom-tabs-three-settings-tab">
                                                <div class="row g-3">
                                                    <div class="col-md-12 mb-2">
                                                        <h5>Diagnosticos Presuntivos</h5>
                                                        <table style="width: 100%">
                                                            <tr>
                                                                <td style="width: 100%" colspan="2"><input type="text" class="form-control" id="diagnostico_p"></td>
                                                            </tr>
                                                            <div id="diagnosticos_presuntivos"></div>
                                                        </table>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="row g-3">
                                                    <div class="col-md-12 mb-2">
                                                        <h5>Diagnosticos Definitivos</h5>
                                                        <table style="width: 100%">
                                                            <tr>
                                                                <td style="width: 100%" colspan="2"><input type="text" class="form-control" id="diagnostico_d"></td>
                                                            </tr>
                                                            <div id="diagnosticos_definitivos"></div>
                                                        </table>
                                                    </div>
                                                </div>
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
                                                        <label for="hygienic_measures" class="form-label">Recomendaciones</label>
                                                        <textarea class="form-control" id="hygienic_measures" name="hygienic_measures" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="observaciones" role="tabpanel" aria-labelledby="custom-tabs-three-settings-tab">
                                                <div class="row g-3">
                                                    <div class="col-12 mb-2">
                                                        <label for="observations" class="form-label">Observaciones</label>
                                                        <textarea class="form-control" id="observations" name="observations" rows="3"></textarea>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="next_attention" class="form-label">Próxima Cita</label>
                                                        <input type="date" class="form-control" id="next_attention" name="next_attention">
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
        var diagnosticos_definitivos = [];
        var dp_texto = "";
        var dd_texto = "";

        //DIAGNOSTICOS PRESUNTIVOS------------------------------------------------------------------------------------------------
        $('#diagnostico_p').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('search.autocomplete_diagnosticos') }}",
                    dataType: 'json',
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            minLength: 3,
            select: function(event, ui) {
                agregar_dp(ui.item);
                $(this).val('');
                return false;
            }
        });

        function agregar_dp(diagnostico_p){
            let diagnostico = {};
            dp_texto = "";

            diagnostico = {
                id: diagnostico_p.id,
                text: diagnostico_p.label,
            }

            if(!diagnosticos_presuntivos.find(x=>x.id === diagnostico_p.id)){
                diagnosticos_presuntivos.push(diagnostico);
            }

            diagnosticos_presuntivos.forEach(function(diagnostico) {
                dp_texto += '<tr><td style="width: 95%"><input type="text" class="form-control" value="'+diagnostico.text+
                            '" readonly></td><td style="width: 5%"><button type="button" class="btn btn-danger col-md-12" onclick="eliminar_dp('
                            +diagnostico.id+')"><i class="bx bx-x"></i></button></td></tr>';
            });

            $('#diagnosticos_presuntivos').html(dp_texto);
        }

        function eliminar_dp(id){
            dp_texto = "";
            let indiceEliminar = diagnosticos_presuntivos.findIndex(objeto => objeto.id === id);

            if (indiceEliminar !== -1) {
                diagnosticos_presuntivos.splice(indiceEliminar, 1);
            }

            diagnosticos_presuntivos.forEach(function(diagnostico_presuntivo) {
                dp_texto += '<tr><td style="width: 95%"><input type="text" class="form-control" value="'+diagnostico_presuntivo.text+
                            '" readonly></td><td style="width: 5%"><button type="button" class="btn btn-danger col-md-12" onclick="eliminar_dp('
                            +diagnostico_presuntivo.id+')"><i class="bx bx-x"></i></button></td></tr>';
            });
            $('#diagnosticos_presuntivos').html(dp_texto);
        }

        //DIAGNOSTICOS DEFINITIVOS------------------------------------------------------------------------------------------------
        $('#diagnostico_d').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('search.autocomplete_diagnosticos') }}",
                    dataType: 'json',
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            minLength: 3,
            select: function(event, ui) {
                agregar_dd(ui.item);
                $(this).val('');
                return false;
            }
        });

        function agregar_dd(diagnostico_d){
            let diagnostico = {};
            dd_texto = "";

            diagnostico = {
                id: diagnostico_d.id,
                text: diagnostico_d.label,
            }

            if(!diagnosticos_definitivos.find(x=>x.id === diagnostico_d.id)){
                diagnosticos_definitivos.push(diagnostico);
            }

            diagnosticos_definitivos.forEach(function(diagnostico) {
                dd_texto += '<tr><td style="width: 95%"><input type="text" class="form-control" value="'+diagnostico.text+
                            '" readonly></td><td style="width: 5%"><button type="button" class="btn btn-danger col-md-12" onclick="eliminar_dd('
                            +diagnostico.id+')"><i class="bx bx-x"></i></button></td></tr>';
            });

            $('#diagnosticos_definitivos').html(dd_texto);
        }

        function eliminar_dd(id){
            dd_texto = "";
            let indiceEliminar = diagnosticos_definitivos.findIndex(objeto => objeto.id === id);

            if (indiceEliminar !== -1) {
                diagnosticos_definitivos.splice(indiceEliminar, 1);
            }

            diagnosticos_definitivos.forEach(function(diagnostico) {
                dd_texto += '<tr><td style="width: 95%"><input type="text" class="form-control" value="'+diagnostico.text+
                            '" readonly></td><td style="width: 5%"><button type="button" class="btn btn-danger col-md-12" onclick="eliminar_dd('
                            +diagnostico.id+')"><i class="bx bx-x"></i></button></td></tr>';
            });
            $('#diagnosticos_definitivos').html(dd_texto);
        }

    </script>

@endsection
