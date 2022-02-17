<?php
header('Content-Type: application/json; charset=utf-8');
$db->debug = 0;
$table_view = "sys_listEmpleados_view";
$db->Execute('DROP view IF EXISTS '.$table_view);
$query = "CREATE view $table_view as  SELECT em.id_emp, em.noEmpleado, em.nom_emp, em.rfc, em.nss, em.salario_diario, em.cuenta,  cu.nom_cuadrilla, em.diasVacacionesAnio, '-' as vacacionesPendientes,
       IF(1=em.status,'Activo','Inactivo') estatus,
       CONCAT
           ('<div class=\"d-flex justify-content-center\">
                <a href=\"index.php?event=01&id_item=',em.id_emp,'\">
                    <i class=\"fa fa-edit\"></i>
                </a>
            </div>
        ') opciones
FROM empleado em inner  join  cuadrilla cu on em.cuadrilla_emp= cu.id_cuadrilla";
$rs = $db->Execute($query)or trigger_error($db->ErrorMsg(), E_USER_ERROR);

$table = $table_view;
$primaryKey = 'id_emp';
$columns = array(
    array('db' => 'noEmpleado', 'dt' => 0),
    array('db' => 'nom_emp', 'dt' => 1),
    array('db' => 'rfc', 'dt' => 2),
    array('db' => 'nss', 'dt' => 3),
    array('db' => 'salario_diario', 'dt' => 4),
    array('db' => 'cuenta', 'dt' => 5),
    array('db' => 'nom_cuadrilla', 'dt' => 6),
    array('db' => 'diasVacacionesAnio', 'dt' => 7),
    array('db' => 'vacacionesPendientes', 'dt' => 8),
    array('db' => 'estatus', 'dt' => 9),
    array('db' => 'opciones', 'dt' => 10)
);
include DIR_PATH . '/core/config.php';
$sql_details = array(
    'user' => serverUname,
    'pass' => serverPass,
    'db' => serverDB,
    'host' => serverHost
);
include DIR_PATH . '/classes/Web/ssp.class.php';
echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);