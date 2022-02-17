<?php
include("../../../utils/cabecera.php");
?>
</div>
<div class="col-sm">
    <div class="jumbotron jumbotron-fluid py-1">
        <div class="container-fluid">
            <div class="date">
                <span id="weekDay" class="weekDay"></span>,
                <span id="day" class="day"></span> de
                <span id="month" class="month"></span> del
                <span id="year" class="year"></span>
            </div>
            <div class="clock">
                <span id="hours" class="hours"></span> :
                <span id="minutes" class="minutes"></span> :
                <span id="seconds" class="seconds"></span>
            </div>
            <div id="num_sem">
                Semana # <span class="badge badge-primary">
                            <?= date('W', strtotime(date('Y-m-d'))); ?>
                        </span>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header-actions">
        <h2 class="card-header bg-cyan-soft text-black">
            Nuevo Monitoreo
            <div class="float-right">
                <a href="index.php?event=1" class="btn btn-outline-black  btn-sm"
                   data-original-title="Agregar Nuevo Usuario">&nbsp;Lista De Monitoreos</a>
            </div>
        </h2>
    </div>
    <div class="card-body">
        <form id="new_monitoring">
            <div id="message"></div>
            <input type="hidden" name="id_monitoreo" id="id_monitoreo" value="0">
            <div class="row">
                <div class="col-sm  my-2" id="subrancho">
                    <label for="subrancho">Selecciona un subrancho:</label>
                    <select class="custom-select" id="num_subrancho" name="num_subrancho"
                            required>
                    </select>
                </div>
                <div class="col-sm d-none my-2" id="clima">
                    <label for="subrancho">Condición Meteorológica:</label>
                    <select class="custom-select" id="cond_met" name="cond_met" required>
                        <option value="">Seleccione una opción</option>
                    </select>
                </div>
                <div class="col-sm d-none my-2" id="fenologia">
                    <label for="etapa_fen">Etapa Fenológica:</label>
                    <select class="custom-select" id="etapa_fen" name="etapa_fen" required>
                        <option value="">Seleccione una opción</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm d-none my-2" id="sector">
                    <label for="sector">Selecciona un sector:</label>
                    <select class="custom-select" id="id_sector" name="id_sector" required>
                        <option value="">Seleccione una opción</option>
                    </select>
                </div>
                <div class="col-sm d-none my-2" id="tunel">
                    <label for="sector">Selecciona un túnel:</label>
                    <select class="custom-select" id="id_tunel" name="id_tunel" required>
                        <option value="">Seleccione una opción</option>
                    </select>
                </div>
                <div class="col-sm d-none my-2" id="plantas">
                    <label for="sector">Num de Plantas:</label>
                    <input type="number" class="form-control" min="1" value="1" id="num_plantas"
                           max="500" name="num_plantas"
                           required/>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <button type="button" id="btn-cambiar-tun"
                        class="btn btn-lg btn-danger d-none my-2 mr-2"><i
                            class="fas fa-exchange-alt"></i> Cambiar Tunel
                </button>
                <button type="button" id="btn-capturar-foto" data-toggle="modal" data-target="#exampleModal"
                        class="btn btn-lg btn-info d-none my-2 mr-2"><i
                            class="fas fa-camera"></i> Capturar Foto
                </button>
                <button type="submit" id="btn-save" class="btn btn-lg btn-success d-none my-2">
                    <i class="far fa-play-circle"></i> Iniciar Monitoreo
                </button>
            </div>
        </form>
        <hr>
        <div id="conteo_lecturas" class="d-flex justify-content-center"></div>
        <br>
        <form id="data_monitoring" hidden="hidden">
            <input type="hidden" name="id_lectura_m" id="id_lectura_m" value="0">
            <hr>
            <div class="row">
                <div class="col-lg">
                    <label for="planta">Planta #:</label>
                    <input type="number" class="form-control" name="num_planta" id="num_planta"
                           required/>
                </div>
                <div class="col-lg">
                    <label for="tipo_hallazgo">Tipo de Hallazgo:</label>
                    <select class="form-control" id="id_tipo_hallazgo" name="id_tipo_hallazgo">
                    </select>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg">
                    <table class="table" id="listaHallazgos">
                        <thead>
                        <tr>
                            <th>
                                Hallazgo
                            </th>
                            <th>
                                Cantidad
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg">
                    <button type="button" class="btn btn-primary btn-block"
                            name="guarda_lectura"
                            id="guarda_lectura"><span class="fas fa-bug"></span> Confirmar
                        Hallazgos
                    </button>
                </div>
            </div>
            <br>
            <div class="row">
                <label>Comentario: </label>
                <textarea class="form-control"
                          placeholder="Escribir el comentario para los hallazgos de la planta actual"
                          name="comentarios" id="comentarios" rows="3"></textarea>
            </div>
            <br>
            <div class="d-flex justify-content-center">
                <button type="submit" id="btn-save-2" class="btn btn-lg btn-success">Siguiente
                    Planta/Concluir <i
                            class="fas fa-arrow-alt-circle-right"></i></button>
            </div>
            <br>
            <hr>
        </form>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Subir Fotos
                        &nbsp;&nbsp;&nbsp;<?= date('Y-m-d') ?></h5>
                </div>
                <form>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="tipo_hallazgo">Tipo de Hallazgo:</label>
                            <select class="form-control" id="id_tipoHallazgoFoto" name="id_tipohallazgo"
                                    required>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div id="my_camera"></div>
                    </div>
                    <br>
                    <div class="row">
                        <input type="hidden" class="form-control" name="fechacaptura"
                               value="<?= date('Y-m-d H:m:s') ?>" required readonly>
                    </div>
                    <div class="row"><div id="results" ></div><h4 id="estado"></h4></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cerrarModal" data-dismiss="modal">CERRAR
                    </button>

                    <input class="btn btn-warning" type="button" value="Dar Acceso a la Cámara" onClick="setup(); $(this).hide().next().show();">
                    <button id="boton" type="button" class="btn btn-success" onClick="take_snapshot()" style="display:none">TOMAR FOTO</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <?php include("../../../utils/piePagina.php"); ?>

    <script src="js/monitoring.js"></script>
    <script src="js/clock.js"></script>
    <script src="js/script.js?v=12.2"></script>
    <script src="js/camara.js"></script>
