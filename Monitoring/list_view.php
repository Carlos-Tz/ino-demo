<?php
include("../../../utils/cabecera.php");
?>
<div class="card-header-actions">
    <h2 class="card-header bg-cyan-soft text-black">
        Lista Monitoreos
    </h2>
</div>
<div class="card-body">
    <div class="row py-2  px-2" style="background-color: #e3e6ec">
        <div class="col-md-4">
            <div class="form-group">
                <label for="sub">Fecha Inicio :</label>
                <input type="date" class="form-control" required name="fechaInicio" id="fechaInicio"
                       value="<?= (empty($_SESSION['monitoreoFechaInicio'])) ? date("Y-m-d", strtotime(date('Y-m-d') . "- 28 days")) : $_SESSION['ViajeFechaInicio'] ?>">
            </div>
        </div>
        <div class="col-md-4 ">
            <div class="form-group ">
                <label for="sub">Fecha Fin:</label>
                <input type="date" class="form-control" required name="fechaFin" id="fechaFin"
                       value="<?= (empty($_SESSION['monitoreoFechaFin'])) ? date("Y-m-d") : $_SESSION['monitoreoFechaFin'] ?>">
            </div>
        </div>
        <div class="col-md-2 mt-4">
            <button class="btn btn-outline-success" id="btn-search"><i data-feather="search"></i> &nbsp;BUSCAR</button>
        </div>
        <div class="col-md-2 mt-4">
            <button class="btn btn-outline-primary" id="export" name="export"><i data-feather="download"></i> &nbsp; EXCEL</button>
        </div>
    </div>
    <div class="dataTable_wrapper table-responsive custom-scrollbar">
        <div id="message"></div>
        <table class="table table-striped table-bordered table-hover"
               id="dataTables-monitoreos" width="100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Responsable</th>
                <th>Subrancho</th>
                <th>Sector</th>
                <th>Túnel</th>
                <th>Opciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<!--Modal for monitoring details-->
<div id="monitoreoModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Datos del Monitoreo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="data_monitoreo">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label><b>Fecha de Monitoreo</b></label>
                            <input type="text" class="form-control" id="fecha_monitoreo"
                                   style="color:#000000;font-style: italic;" ;>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label><b>Subrancho:</b></label>
                            <input type="text" class="form-control" id="subrancho"
                                   style="color:#000000;font-style: italic;" ; disabled>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label><b>Sector</b></label>
                            <input type="text" class="form-control" id="sector"
                                   style="color:#000000;font-style: italic;" ; disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label><b>Túnel</b></label>
                            <input type="text" class="form-control" id="tunel"
                                   style="color:#000000;font-style: italic;" ; disabled>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label><b>Plantas Evaluadas</b></label>
                            <input type="text" class="form-control" id="plantas"
                                   style="color:#000000;font-style: italic;" ; disabled>
                        </div>
                    </div>
                </div>
                <div>
                    <b>Nota:</b> Las plantas en las que no se hayan registrado hallazgos se omiten
                    de la lista. <br><br>
                    <table class="table table-striped table-bordered table-hover"
                           id="dataTables-lecturasM" width="100%">
                        <thead>
                        <tr>
                            <th># Planta</th>
                            <th>Cantidad</th>
                            <th>Hallazgo</th>
                            <th>Tipo</th>
                            <th>Comentario</th>
                            <th>Respuesta</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for res-->
<div id="respuestaCom" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title">Respuesta </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                                    <textarea class="form-control" rows="3" name="respuestaComentario"
                                              title="Escribi respuesta a para la Lectura."
                                              id="respuestaComentario"></textarea>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="idLectura" name="idLectura">
                <button type="button" id="guardarRespuesta" class="btn btn-block btn-danger"><i
                            class="fas fa-save"></i>&nbsp; GUARDAR
                </button>
            </div>
        </div>
    </div>
</div>

<div id="monitoreoModalFotos" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Fotos del Monitoreo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="data_monitoreo_fotos">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>

<?php include("../../../utils/piePagina.php"); ?>

<script src="js/list.js"></script>

