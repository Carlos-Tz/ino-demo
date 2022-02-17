<?php
header('Content-Type: application/json; charset=utf-8');
global $db;
$db->debug=0;
$arJson = array();
$queryBase = "SELECT m.id_monitoreo, t.nombre as tunel, CONCAT(m.fecha,' ',m.hora) fecha, 
            sr.nombre as subrancho, s.nombre as sector, cl.comentarios as comentarios,
            m.cant_plantas_eval as plantas 
            FROM `monitoreo` as m 
            INNER JOIN lectura_monitoreo as lm ON lm.id_monitoreo = m.id_monitoreo 
            INNER JOIN subrancho sr ON m.id_up = sr.num_subrancho 
            INNER JOIN sector as s ON s.id_sector = m.id_tabla
            INNER JOIN tuneles as t ON t.id_tunel = m.id_tunel 
            LEFT JOIN comentarios_lecturas as cl ON cl.id_lectura = lm.id 
            WHERE m.id_monitoreo = '$id_monitoreo'";
$res = $db->Execute($queryBase)or trigger_error($db->ErrorMsg(), E_USER_ERROR);
$arJson = $res->getRows();
echo json_encode($arJson);