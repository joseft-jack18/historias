@extends('layout.plantilla')

@section('titulo', 'Historias Clinicas')

@section('contenido')

    <!-- Main content -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Nueva Historia</h1>
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
                                <h4 class="card-title text-center">Nueva Historia Clínica</h4>
                                <br>
                                <p class="card-text">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <button class="nav-link active" id="enfermedad-tab" data-bs-toggle="tab" data-bs-target="#enfermedad" type="button" role="tab" aria-controls="enfermedad" aria-selected="true">ENFERMEDAD</button>
                                            <button class="nav-link" id="antecedentes-tab" data-bs-toggle="tab" data-bs-target="#antecedentes" type="button" role="tab" aria-controls="antecedentes" aria-selected="false">ANTECEDENTE</button>
                                            <button class="nav-link" id="fisico-tab" data-bs-toggle="tab" data-bs-target="#fisico" type="button" role="tab" aria-controls="fisico" aria-selected="false">EX. FISICO</button>
                                            <button class="nav-link" id="diagnostico-tab" data-bs-toggle="tab" data-bs-target="#diagnostico" type="button" role="tab" aria-controls="diagnostico" aria-selected="false">DIAGNÓSTICO</button>
                                            <button class="nav-link" id="trabajo-tab" data-bs-toggle="tab" data-bs-target="#trabajo" type="button" role="tab" aria-controls="trabajo" aria-selected="false">PLAN</button>
                                            <button class="nav-link" id="tratamiento-tab" data-bs-toggle="tab" data-bs-target="#tratamiento" type="button" role="tab" aria-controls="tratamiento" aria-selected="false">TRATAMIENTO</button>
                                            <button class="nav-link" id="observacion-tab" data-bs-toggle="tab" data-bs-target="#observacion" type="button" role="tab" aria-controls="observacion" aria-selected="false">OBSERVACION</button>
                                        </div>
                                    </nav>
                                </p>

                                <br>

                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="enfermedad" role="tabpanel" aria-labelledby="enfermedad-tab">
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <label for="numero" class="form-label">Tiempo de Enfermedad</label>
                                                <input type="text" class="form-control" id="numero" name="numero">
                                                <input type="hidden" class="form-control" id="person_id" name="person_id" value="{{ $person->id }}">
                                            </div>

                                            <div class="col-md-2">
                                                <label for="tiempo" class="form-label">&nbsp;</label><br>
                                                <select class="form-select" id="tiempo" name="tiempo">
                                                    <option value="0" selected>--Seleccione--</option>
                                                    <option value="1">Horas</option>
                                                    <option value="2">Dias</option>
                                                    <option value="3">Meses</option>
                                                    <option value="4">Años</option>
                                                </select>
                                            </div>

                                            <div class="col-md-7">
                                                <label for="motivo_consulta" class="form-label">Motivo de Consulta</label>
                                                <input type="text" class="form-control" id="motivo_consulta" name="motivo_consulta">
                                            </div>

                                            <div class="col-md-12">
                                                <label for="sintomas_principales" class="form-label">Signos y Síntomas principales</label>
                                                <textarea class="form-control" id="sintomas_principales" name="sintomas_principales" rows="3"></textarea>
                                            </div>

                                            <div class="col-md-2">
                                                <label for="sed" class="form-label">Sed</label>
                                                <select class="form-select" id="sed" name="sed">
                                                    <option value="0" selected>--Seleccione--</option>
                                                    <option value="1">Disminuido</option>
                                                    <option value="2">Normal</option>
                                                    <option value="3">Aumentado</option>
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <label for="apetito" class="form-label">Apetito</label>
                                                <select class="form-select" id="apetito" name="apetito">
                                                    <option value="0" selected>--Seleccione--</option>
                                                    <option value="1">Disminuido</option>
                                                    <option value="2">Normal</option>
                                                    <option value="3">Aumentado</option>
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <label for="sueño" class="form-label">Sueño</label>
                                                <select class="form-select" id="sueño" name="sueño">
                                                    <option value="0" selected>--Seleccione--</option>
                                                    <option value="1">Disminuido</option>
                                                    <option value="2">Normal</option>
                                                    <option value="3">Aumentado</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="ritmo_urinario" class="form-label">Ritmo Urinario</label>
                                                <select class="form-select" id="ritmo_urinario" name="ritmo_urinario">
                                                    <option value="0" selected>--Seleccione--</option>
                                                    <option value="1">Disminuido</option>
                                                    <option value="2">Normal</option>
                                                    <option value="3">Aumentado</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="ritmo_evacuatorio" class="form-label">Ritmo Evacuatorio</label>
                                                <select class="form-select" id="ritmo_evacuatorio" name="ritmo_evacuatorio">
                                                    <option value="0" selected>--Seleccione--</option>
                                                    <option value="1">Disminuido</option>
                                                    <option value="2">Normal</option>
                                                    <option value="3">Aumentado</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="antecedentes" role="tabpanel" aria-labelledby="antecedentes-tab">
                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <label for="antecedentes_personales" class="form-label">Antecedentes Personales</label>
                                                <textarea class="form-control" id="antecedentes_personales" name="antecedentes_personales" rows="3"></textarea>
                                            </div>

                                            <div class="col-md-12">
                                                <label for="antecedentes_alergias" class="form-label">Antecedentes de Alergias</label>
                                                <textarea class="form-control" id="antecedentes_alergias" name="antecedentes_alergias" rows="3"></textarea>
                                            </div>

                                            <div class="col-md-12">
                                                <label for="antecedentes_familiares" class="form-label">Antecedentes Familiares</label>
                                                <textarea class="form-control" id="antecedentes_familiares" name="antecedentes_familiares" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="fisico" role="tabpanel" aria-labelledby="fisico-tab">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label for="frecuencia_cardiaca" class="form-label">Frecuencia Cardiaca (por minuto)</label>
                                                <input type="text" class="form-control" id="frecuencia_cardiaca" name="frecuencia_cardiaca">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="frecuencia_respiratoria" class="form-label">Frecuencia Respiratoria (por minuto)</label>
                                                <input type="text" class="form-control" id="frecuencia_respiratoria" name="frecuencia_respiratoria">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="presion_arterial" class="form-label">Presion Arterial (mmHg)</label>
                                                <input type="text" class="form-control" id="presion_arterial" name="presion_arterial">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="temperatura" class="form-label">Temperatura (°C)</label>
                                                <input type="text" class="form-control" id="temperatura" name="temperatura">
                                            </div>

                                            <div class="col-md-2">
                                                <label for="peso" class="form-label">Peso (Kg)</label>
                                                <input type="text" class="form-control" id="peso" name="peso">
                                            </div>

                                            <div class="col-md-2">
                                                <label for="talla" class="form-label">Talla (m)</label>
                                                <input type="text" class="form-control" id="talla" name="talla">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="imc" class="form-label">IMC</label>
                                                <input type="text" class="form-control" id="imc" name="imc">
                                            </div>

                                            <div class="col-md-12">
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

                                    <div class="tab-pane fade" id="diagnostico" role="tabpanel" aria-labelledby="diagnostico-tab">
                                        <h5>Diagnosticos Presuntivos</h5>
                                        <div id="rowp_1" class="row">
                                            <div class="col-md-11">
                                                <input type="text" class="form-control input_dp" name="nom_diagnosticop[]" id="nom_diagnosticop_1" placeholder="Diágnostico">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-success col-md-12" id="btn_add1"><i class="fa-solid fa-plus"></i></button>
                                            </div>
                                        </div>
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

                                    <div class="tab-pane fade" id="trabajo" role="tabpanel" aria-labelledby="trabajo-tab">
                                        <div class="row g-3">
                                            <div class="col-6">
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

                                            <div class="col-6">
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

                                    <div class="tab-pane fade" id="tratamiento" role="tabpanel" aria-labelledby="tratamiento-tab">
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

                                    <div class="tab-pane fade" id="observacion" role="tabpanel" aria-labelledby="observacion-tab">
                                        <div class="row g-3">
                                            <div class="col-12">
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
