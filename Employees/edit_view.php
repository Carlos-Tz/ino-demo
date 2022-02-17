<?php
include("../../../utils/cabecera.php");
?>
<div class="card-header-actions">
    <h2 class="card-header bg-cyan-soft text-black">
        EMPLEADOS
        <div class="float-right">
            <a href="index.php?event=010" class="btn btn-outline-black  btn-sm"
               data-toggle="tooltip" data-placement="top" title="Lista de Compactacion Erocion">
                <i data-feather="list"></i> Lista</a>
        </div>
    </h2>
</div>
<div class="card-body">
    <form action="" method="post" id="formEmployees" name="form" autocomplete="off">
        <div class="card-body">
            <div id="message" class="col-xs"><?= $msg; ?></div>
            <input type="hidden" id="id_emp" name="id_emp"
                   value="<?= $id_emp ?: 0 ?>">
            <input type="hidden" id="id_cuadrilla" name="id_cuadrilla"
                   value="<?= $cuadrilla_emp ?: 0 ?>">
            <input type="hidden" id="fecha_registro" name="fecha_registro"
                   value="<?= date('Y-m-d H:i:s') ?>">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs">
                    <div class="form-group">
                        <label>Nombre *</label>
                        <input class="form-control" type="text" name="nom_emp" value="<?= $nom_emp ?>" required>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs">
                    <div class="form-group">
                        <label for="usuario">Fecha Ingreso * </label>
                        <input type="date" class="form-control" max="<?= date('Y-m-d') ?>" name="fecha_ingreso"
                               value="<?= $fecha_ingreso ?>" required>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs">
                    <div class="form-group">
                        <label for="">Fecha Nacimiento</label>
                        <input class="form-control" type="date" max="<?= date('Y-m-d') ?>" name="fecha_nac"
                               value="<?= $fecha_nac ?>">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs">
                    <label for="realiza">CURP</label>
                    <input class="form-control" type="text" name="curp" value="<?= $curp ?>">
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs">
                    <div class="form-group">
                        <label for="frecuencia">RFC</label>
                        <input type="text" class="form-control" name="rfc" value="<?= $rfc ?>">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs">
                    <div class="form-group">
                        <label for="usuario">NSS</label>
                        <input type="text" class="form-control" name="nss" value="<?= $nss ?>">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs">
                    <div class="form-group">
                        <label for="">calle</label>
                        <input type="text" class="form-control" name="calle" value="<?= $calle ?>">
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 col-xs">
                    <div class="form-group">
                        <label for="usuario">Numero </label>
                        <input type="text" class="form-control" name="no" value="<?= $no ?>">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs">
                    <div class="form-group">
                        <label for="usuario">Colonia </label>
                        <input type="text" class="form-control" name="colonia" value="<?= $colonia ?>">
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 col-xs">
                    <div class="form-group">
                        <label for="usuario">CP </label>
                        <input type="number" class="form-control" name="cp" value="<?= $cp ?>">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs">
                    <div class="form-group">
                        <label for="usuario">Municipio </label>
                        <input type="text" class="form-control" name="municipio" value="<?= $municipio ?>">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs">
                    <div class="form-group">
                        <label for="usuario">Entidad </label>
                        <input type="text" class="form-control" name="entidad" value="<?= $entidad ?>">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs">
                    <div class="form-group">
                        <label for="usuario">Movil </label>
                        <input type="text" class="form-control" name="movil" value="<?= $movil ?>">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs">
                    <div class="form-group">
                        <label for="">Correo </label>
                        <input type="email" class="form-control" name="correo" value="<?= $correo ?>">
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 col-xs">
                    <div class="form-group">
                        <label for="">Salario Diario *</label>
                        <input type="number" step="any" min="0" class="form-control" name="salario_diario"
                               id="salario_diario" value="<?= $salario_diario ?>" required>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 col-xs">
                    <div class="form-group">
                        <label for="">Salario Hora </label>
                        <input type="number" class="form-control" name="salariohora" id="salariohora" readonly
                               value="<?= $salariohora ?>">
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 col-xs">
                    <div class="form-group">
                        <label for="">Vacaciones</label>
                        <input type="number" class="form-control" name="diasVacacionesAnio"
                               title="Vacaciones Pendientes" value="<?= $diasVacacionesAnio ?>">
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 col-xs">
                    <div class="form-group">
                        <label for="">Num. Empleado *</label>
                        <input type="text" class="form-control" name="noempleado" value="<?= $noempleado ?>" required>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs">
                    <div class="form-group">
                        <label for="">Cuadrilla *</label>
                        <select name="cuadrilla_emp" id="cuadrilla_emp" class="form-control" required>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs">
                    <div class="form-group">
                        <label for="">Cuenta </label>
                        <input name="cuenta" id="" class="form-control" value="<?= $cuenta ?>">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs">
                    <div class="form-group">
                        <label for="">Estatus </label>
                        <select name="status" class="form-control">
                            <option value="1" <?= ($status == 1) ? 'selected' : '' ?> >Activo</option>
                            <option value="2" <?= ($status == 2) ? 'selected' : '' ?> >Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row float-right">
                    <div class="col-xs">
                        <a type="button" href="index.php?event=10" class="btn btn-secondary btn-sm">Cancelar</a>
                        <button type="submit" id="btn-save" name="saveButton"
                                class="btn btn-primary btn-sm">Guardar
                        </button>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </form>
</div>
<?php include("../../../utils/piePagina.php"); ?>

<script src="js/edit.js"></script>
