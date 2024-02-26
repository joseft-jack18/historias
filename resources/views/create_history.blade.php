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
                        <form action="{{ route('history.store') }}" method="POST">
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
                                                        <input type="text" class="form-control" id="imc" name="imc" readonly>
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
                                                    <div class="col-12 mb-2">
                                                        <h5>Diagnosticos Presuntivos</h5>
                                                        <input type="hidden" class="form-control" id="diagnosticosPresuntivos" name="diagnosticosPresuntivos" readonly>
                                                        <table style="width: 100%">
                                                            <tr>
                                                                <td style="width: 100%" colspan="2"><input type="text" class="form-control" id="diagnostico_p"></td>
                                                            </tr>
                                                        </table>
                                                        <table style="width: 100%" id="diagnosticos_presuntivos"></table>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="row g-3">
                                                    <div class="col-12 mb-2">
                                                        <h5>Diagnosticos Definitivos</h5>
                                                        <input type="hidden" class="form-control" id="diagnosticosDefinitivos" name="diagnosticosDefinitivos" readonly>
                                                        <table style="width: 100%">
                                                            <tr>
                                                                <td style="width: 100%" colspan="2"><input type="text" class="form-control" id="diagnostico_d"></td>
                                                            </tr>
                                                        </table>
                                                        <table style="width: 100%" id="diagnosticos_definitivos"></table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="planes" role="tabpanel" aria-labelledby="custom-tabs-three-settings-tab">
                                                <div class="row g-3">
                                                    <div class="col-6 mb-2">
                                                        <h5>Exámenes de Laboratorio</h5>
                                                        <input type="text" class="form-control" id="examenesLaboratorio" name="examenesLaboratorio" readonly>
                                                        <table style="width: 100%">
                                                            <tr>
                                                                <td style="width: 100%" colspan="2"><input type="text" class="form-control" id="laboratorio"></td>
                                                            </tr>
                                                        </table>
                                                        <table style="width: 100%" id="examenes_laboratorio"></table>
                                                    </div>

                                                    <div class="col-6 mb-2">
                                                        <h5>Exámenes Radiológicos</h5>
                                                        <input type="text" class="form-control" id="examenesRadiologicos" name="examenesRadiologicos" readonly>
                                                        <table style="width: 100%">
                                                            <tr>
                                                                <td style="width: 100%" colspan="2"><input type="text" class="form-control" id="radiologicos"></td>
                                                            </tr>
                                                        </table>
                                                        <table style="width: 100%" id="examenes_radiologicos"></table>
                                                    </div>

                                                    <div class="col-6 mb-2">
                                                        <h5>Procedimientos Especiales</h5>
                                                        <input type="text" class="form-control" id="procedimientosEspeciales" name="procedimientosEspeciales" readonly>
                                                        <table style="width: 100%">
                                                            <tr>
                                                                <td style="width: 95%"><input type="text" class="form-control" id="procedimientos"></td>
                                                                <td style="width: 5%">
                                                                    <button type="button" class="btn btn-success col-md-12" onclick="agregar_pe()"><i class="bx bx-plus"></i></button>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table style="width: 100%" id="procedimientos_especiales"></table>
                                                    </div>

                                                    <div class="col-6 mb-2">
                                                        <h5>Interconsultas</h5>
                                                        <input type="text" class="form-control" id="interconsultasMedicas" name="interconsultasMedicas" readonly>
                                                        <table style="width: 100%">
                                                            <tr>
                                                                <td style="width: 100%" colspan="2"><input type="text" class="form-control" id="interconsultas"></td>
                                                            </tr>
                                                        </table>
                                                        <table style="width: 100%" id="interconsultas_medicas"></table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="tratamientos" role="tabpanel" aria-labelledby="custom-tabs-three-settings-tab">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <input type="hidden" class="form-control" id="arrayTratamientos" name="arrayTratamientos" readonly>
                                                        <table style="width: 100%">
                                                            <tr>
                                                                <td style="width: 70%"><input type="text" class="form-control" id="medicamento" placeholder="Nombre del Medicamento"></td>
                                                                <td style="width: 30%"><input type="text" class="form-control" id="forma" placeholder="Forma"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 70%"><input type="text" class="form-control" id="dosis" placeholder="Dosis"></td>
                                                                <td style="width: 30%"><input type="text" class="form-control" id="cantidad" placeholder="Cantidad"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 70%"></td>
                                                                <td style="width: 30%"><button type="button" class="btn btn-success btn-block" onclick="agregar_tratamiento()"><i class="bx bx-plus"></i> Agregar</button></td>
                                                            </tr>
                                                        </table>
                                                        <table style="width: 100%" id="a_tratamientos"></table>
                                                    </div>

                                                    <div class="col-12 mt-4">
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
        let diagnosticos_presuntivos = [];
        let datos_dp = JSON.stringify(diagnosticos_presuntivos);
        document.getElementById('diagnosticosPresuntivos').value = datos_dp;

        let diagnosticos_definitivos = [];
        let datos_dd = JSON.stringify(diagnosticos_definitivos);
        document.getElementById('diagnosticosDefinitivos').value = datos_dd;

        let examenes_laboratorio = [];
        let datos_el = JSON.stringify(examenes_laboratorio);
        document.getElementById('examenesLaboratorio').value = datos_el;

        let procedimientos_especiales = [];
        let datos_pe = JSON.stringify(procedimientos_especiales);
        document.getElementById('procedimientosEspeciales').value = datos_pe;

        let examenes_radiologicos = [];
        let datos_er = JSON.stringify(examenes_radiologicos);
        document.getElementById('examenesRadiologicos').value = datos_er;

        let interconsultas_medicas = [];
        let datos_im = JSON.stringify(interconsultas_medicas);
        document.getElementById('interconsultasMedicas').value = datos_im;

        let tratamientos = [];
        let datos_tr = JSON.stringify(tratamientos);
        document.getElementById('arrayTratamientos').value = datos_tr;

        let dp_texto = "";
        let dd_texto = "";
        let lb_texto = "";
        let rx_texto = "";
        let pe_texto = "";
        let in_texto = "";
        let tr_texto = "";

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
            let datosJSON = JSON.stringify(diagnosticos_presuntivos);
            document.getElementById('diagnosticosPresuntivos').value = datosJSON;
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
            let datosJSON = JSON.stringify(diagnosticos_presuntivos);
            document.getElementById('diagnosticosPresuntivos').value = datosJSON;
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
            let datosJSON = JSON.stringify(diagnosticos_definitivos);
            document.getElementById('diagnosticosDefinitivos').value = datosJSON;
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
            let datosJSON = JSON.stringify(diagnosticos_definitivos);
            document.getElementById('diagnosticosDefinitivos').value = datosJSON;
        }

        //EXAMENES DE LABORATORIO-------------------------------------------------------------------------------------------------
        $('#laboratorio').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('search.autocomplete_laboratorios') }}",
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
                agregar_lb(ui.item);
                $(this).val('');
                return false;
            }
        });

        function agregar_lb(laboratorios){
            let examen_laboratorio = {};
            lb_texto = "";

            examen_laboratorio = {
                id: laboratorios.id,
                text: laboratorios.label,
            }

            if(!examenes_laboratorio.find(x=>x.id === laboratorios.id)){
                examenes_laboratorio.push(examen_laboratorio);
            }

            examenes_laboratorio.forEach(function(laboratorio) {
                lb_texto += '<tr><td style="width: 95%"><input type="text" class="form-control" value="'+laboratorio.text+
                            '" readonly></td><td style="width: 5%"><button type="button" class="btn btn-danger col-md-12" onclick="eliminar_lb('
                            +laboratorio.id+')"><i class="bx bx-x"></i></button></td></tr>';
            });

            $('#examenes_laboratorio').html(lb_texto);
            let datosJSON = JSON.stringify(examenes_laboratorio);
            document.getElementById('examenesLaboratorio').value = datosJSON;
        }

        function eliminar_lb(id){
            lb_texto = "";
            let indiceEliminar = examenes_laboratorio.findIndex(objeto => objeto.id === id);

            if (indiceEliminar !== -1) {
                examenes_laboratorio.splice(indiceEliminar, 1);
            }

            examenes_laboratorio.forEach(function(laboratorio) {
                lb_texto += '<tr><td style="width: 95%"><input type="text" class="form-control" value="'+laboratorio.text+
                            '" readonly></td><td style="width: 5%"><button type="button" class="btn btn-danger col-md-12" onclick="eliminar_lb('
                            +laboratorio.id+')"><i class="bx bx-x"></i></button></td></tr>';
            });

            $('#examenes_laboratorio').html(lb_texto);
            let datosJSON = JSON.stringify(examenes_laboratorio);
            document.getElementById('examenesLaboratorio').value = datosJSON;
        }

        //EXAMENES RADIOLOGICOS---------------------------------------------------------------------------------------------------
        $('#radiologicos').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('search.autocomplete_radiologicos') }}",
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
                agregar_rx(ui.item);
                $(this).val('');
                return false;
            }
        });

        function agregar_rx(radiologicos){
            let examen_radiologico = {};
            rx_texto = "";

            examen_radiologico = {
                id: radiologicos.id,
                text: radiologicos.label,
            }

            if(!examenes_radiologicos.find(x=>x.id === radiologicos.id)){
                examenes_radiologicos.push(examen_radiologico);
            }

            examenes_radiologicos.forEach(function(radiologico) {
                rx_texto += '<tr><td style="width: 95%"><input type="text" class="form-control" value="'+radiologico.text+
                            '" readonly></td><td style="width: 5%"><button type="button" class="btn btn-danger col-md-12" onclick="eliminar_rx('
                            +radiologico.id+')"><i class="bx bx-x"></i></button></td></tr>';
            });

            $('#examenes_radiologicos').html(rx_texto);
            let datosJSON = JSON.stringify(examenes_radiologicos);
            document.getElementById('examenesRadiologicos').value = datosJSON;
        }

        function eliminar_rx(id){
            rx_texto = "";
            let indiceEliminar = examenes_radiologicos.findIndex(objeto => objeto.id === id);

            if (indiceEliminar !== -1) {
                examenes_radiologicos.splice(indiceEliminar, 1);
            }

            examenes_radiologicos.forEach(function(radiologico) {
                rx_texto += '<tr><td style="width: 95%"><input type="text" class="form-control" value="'+radiologico.text+
                            '" readonly></td><td style="width: 5%"><button type="button" class="btn btn-danger col-md-12" onclick="eliminar_rx('
                            +radiologico.id+')"><i class="bx bx-x"></i></button></td></tr>';
            });

            $('#examenes_radiologicos').html(rx_texto);
            let datosJSON = JSON.stringify(examenes_radiologicos);
            document.getElementById('examenesRadiologicos').value = datosJSON;
        }

        //PROCEDIMIENTOS ESPECIALES-----------------------------------------------------------------------------------------------
        function agregar_pe(){
            let procedimiento_especial = {};
            pe_texto = "";

            let procedimiento = $('#procedimientos').val();

            procedimiento_especial = {
                text: procedimiento,
            }

            if(!procedimientos_especiales.find(x=>x.id === procedimiento.id)){
                procedimientos_especiales.push(procedimiento_especial);
            }

            procedimientos_especiales.forEach(function(procedimiento) {
                pe_texto += '<tr><td style="width: 95%"><input type="text" class="form-control" value="'+procedimiento.text+
                            '" readonly></td><td style="width: 5%"><button type="button" class="btn btn-danger col-md-12" onclick="eliminar_pe('${procedimiento.text}')"><i class="bx bx-x"></i></button></td></tr>';
            });

            $('#procedimientos_especiales').html(pe_texto);
            let datosJSON = JSON.stringify(procedimientos_especiales);
            document.getElementById('procedimientosEspeciales').value = datosJSON;
        }

        function eliminar_pe(procedimiento){
            pe_texto = "";
            let indiceEliminar = procedimientos_especiales.findIndex(objeto => objeto.text === procedimiento);

            if (indiceEliminar !== -1) {
                procedimientos_especiales.splice(indiceEliminar, 1);
            }

            procedimientos_especiales.forEach(function(procedimiento) {
                pe_texto += '<tr><td style="width: 95%"><input type="text" class="form-control" value="'+procedimiento.text+
                            '" readonly></td><td style="width: 5%"><button type="button" class="btn btn-danger col-md-12" onclick="eliminar_pe('${procedimiento.text}')"><i class="bx bx-x"></i></button></td></tr>';
            });

            $('#procedimientos_especiales').html(pe_texto);
            let datosJSON = JSON.stringify(procedimientos_especiales);
            document.getElementById('procedimientosEspeciales').value = datosJSON;
        }

        //INTERCONSULTAS MEDICAS--------------------------------------------------------------------------------------------------
        $('#interconsultas').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('search.autocomplete_interconsultas') }}",
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
                agregar_in(ui.item);
                $(this).val('');
                return false;
            }
        });

        function agregar_in(interconsulta){
            let interconsulta_medica = {};
            in_texto = "";

            interconsulta_medica = {
                id: interconsulta.id,
                text: interconsulta.label,
            }

            if(!interconsultas_medicas.find(x=>x.id === interconsulta.id)){
                interconsultas_medicas.push(interconsulta_medica);
            }

            interconsultas_medicas.forEach(function(interconsulta) {
                in_texto += '<tr><td style="width: 95%"><input type="text" class="form-control" value="'+interconsulta.text+
                            '" readonly></td><td style="width: 5%"><button type="button" class="btn btn-danger col-md-12" onclick="eliminar_in('
                            +interconsulta.id+')"><i class="bx bx-x"></i></button></td></tr>';
            });

            $('#interconsultas_medicas').html(in_texto);
            let datosJSON = JSON.stringify(interconsultas_medicas);
            document.getElementById('interconsultasMedicas').value = datosJSON;
        }

        function eliminar_in(id){
            in_texto = "";
            let indiceEliminar = interconsultas_medicas.findIndex(objeto => objeto.id === id);

            if (indiceEliminar !== -1) {
                interconsultas_medicas.splice(indiceEliminar, 1);
            }

            interconsultas_medicas.forEach(function(interconsulta) {
                in_texto += '<tr><td style="width: 95%"><input type="text" class="form-control" value="'+interconsulta.text+
                            '" readonly></td><td style="width: 5%"><button type="button" class="btn btn-danger col-md-12" onclick="eliminar_in('
                            +interconsulta.id+')"><i class="bx bx-x"></i></button></td></tr>';
            });

            $('#interconsultas_medicas').html(in_texto);
            let datosJSON = JSON.stringify(interconsultas_medicas);
            document.getElementById('interconsultasMedicas').value = datosJSON;
        }


        //MEDICAMENTOS------------------------------------------------------------------------------------------------------------
        $('#medicamento').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('search.autocomplete_medicamentos') }}",
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
        });

        function agregar_tratamiento(){
            let tratamiento = {};
            tr_texto = "";

            let medicamento = $('#medicamento').val();
            let forma = $('#forma').val();
            let dosis = $('#dosis').val();
            let cantidad = $('#cantidad').val();

            tratamiento = {
                medicine: medicamento,
                shape: forma,
                dose: dosis,
                quantity: cantidad,
            }

            tratamientos.push(tratamiento);

            tratamientos.forEach(function(tratamiento) {
                tr_texto += '<tr>';
                tr_texto += '<td style="width: 70%"><input type="text" class="form-control" readonly value="'+ tratamiento.medicine +'"></td>';
                tr_texto += '<td style="width: 30%"><input type="text" class="form-control" readonly value="'+ tratamiento.shape +'"></td>';
                tr_texto += '</tr>';
                tr_texto += '<tr>';
                tr_texto += '<td style="width: 70%"><input type="text" class="form-control" readonly value="'+ tratamiento.dose +'"></td>';
                tr_texto += '<td style="width: 30%"><input type="text" class="form-control" readonly value="'+ tratamiento.quantity +'"></td>';
                tr_texto += '</tr>';
                tr_texto += '<tr>';
                tr_texto += '<td style="width: 70%"></td>';
                tr_texto += `<td style="width: 30%"><button type="button" class="btn btn-danger btn-block" onclick="eliminar_tratamiento('${tratamiento.medicine}')"><i class="bx bx-x"></i> Eliminar</button></td>`;
                tr_texto += '</tr>';
            });

            $('#a_tratamientos').html(tr_texto);
            let datosJSON = JSON.stringify(tratamientos);
            document.getElementById('arrayTratamientos').value = datosJSON;
            limpiar();
        }

        function eliminar_tratamiento(name){
            tr_texto = "";
            let indiceEliminar = tratamientos.findIndex(objeto => objeto.medicine === name);

            if (indiceEliminar !== -1) {
                tratamientos.splice(indiceEliminar, 1);
            }

            tratamientos.forEach(function(tratamiento) {
                tr_texto += '<tr>';
                tr_texto += '<td style="width: 70%"><input type="text" class="form-control" readonly value="'+ tratamiento.medicine +'"></td>';
                tr_texto += '<td style="width: 30%"><input type="text" class="form-control" readonly value="'+ tratamiento.shape +'"></td>';
                tr_texto += '</tr>';
                tr_texto += '<tr>';
                tr_texto += '<td style="width: 70%"><input type="text" class="form-control" readonly value="'+ tratamiento.dose +'"></td>';
                tr_texto += '<td style="width: 30%"><input type="text" class="form-control" readonly value="'+ tratamiento.quantity +'"></td>';
                tr_texto += '</tr>';
                tr_texto += '<tr>';
                tr_texto += '<td style="width: 70%"></td>';
                tr_texto += `<td style="width: 30%"><button type="button" class="btn btn-danger btn-block" onclick="eliminar_tratamiento('${tratamiento.medicine}')"><i class="bx bx-x"></i> Eliminar</button></td>`;
                tr_texto += '</tr>';
            });

            $('#a_tratamientos').html(tr_texto);
            let datosJSON = JSON.stringify(tratamientos);
            document.getElementById('arrayTratamientos').value = datosJSON;
        }

        function limpiar(){
            $('#medicamento').val("");
            $('#forma').val("");
            $('#dosis').val("");
            $('#cantidad').val("");
            $('#medicamento').focus();
        }

        //CALCULAR IMC------------------------------------------------------------------------------------------------------------
        let input1 = document.getElementById("weight");
        let input2 = document.getElementById("size");

        function calcularSuma() {
            // Obtener los valores de los inputs y asegurarse de que sean números válidos
            let valor1 = parseFloat(input1.value) || 0;
            let valor2 = parseFloat(input2.value) || 0;

            // Calcular la suma
            let imc = valor1 / (valor2 * valor2);

            // Mostrar el resultado
            $('#imc').val(imc.toFixed(2));
        }

        // Agregar eventos input a ambos inputs
        input1.addEventListener("input", calcularSuma);
        input2.addEventListener("input", calcularSuma);
    </script>

@endsection
