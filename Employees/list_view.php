<?php
include("../../../utils/cabecera.php");
?>
<div class="card-header-actions">
    <h2 class="card-header bg-cyan-soft text-black">
        Lista Empleados
        <div class="float-right">
            <a href="index.php?event=01" class="btn btn-outline-black  btn-sm"
               data-toggle="tooltip" data-placement="top"
               title="Nuevo Registro Erocion Compactacion ">
                <i data-feather="list"></i>&nbsp;Nuevo </a>
        </div>
    </h2>
</div>
<div class="card-body">
    <table id="dataTables" class="table table-striped table-bordered"
           style="width: 100%;">
        <thead>
        <tr>
            <th>NUM. Empleado</th>
            <th>Nombre</th>
            <th>RFC</th>
            <th>NSS</th>
            <th>Salario Diario</th>
            <th>Cuenta</th>
            <th>Cuadrilla</th>
            <th>Vacaciones Pendientes</th>
            <th>Vacaciones Tomadas</th>
            <th>Estatus</th>
            <th class="td-actions text-right">Opciones</th>
        </tr>
        </thead>
    </table>
</div>
<?php include("../../../utils/piePagina.php"); ?>

<script src="js/list.js"></script>


