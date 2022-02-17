<?php
global  $db;
$db->debug = 0;
$_SESSION['monitoreoFechaInicio']=$ar_data['fechaInicio'];
$_SESSION['monitoreoFechaFin']=$ar_data['fechaFin'];

header('Content-Type: application/json; charset=utf-8');
$today = date("Y-m-d");
$result = $db->Execute("SELECT * FROM monitoreo WHERE status_id = 2 and fecha < '$today'")or trigger_error($db->ErrorMsg(), E_USER_ERROR);
if($result){
    $db->startTrans();
    while ($r = $result->fetchRow()){
        $m_id = $r['id_monitoreo'];

        $look_for_readings = $db->Execute("SELECT id FROM `lectura_monitoreo` where id_monitoreo = ".$m_id)or trigger_error($db->ErrorMsg(), E_USER_ERROR);
        $data = $look_for_readings->getRows();
        foreach ($data as $d){
            $reading_id = $d['id'];
            $to_delete_lh = $db->Execute("DELETE FROM `lectura_hallazgos` where id_lectura = ".$reading_id)or trigger_error($db->ErrorMsg(), E_USER_ERROR);
            $to_delete_cm = $db->Execute("DELETE FROM `comentarios_lecturas` where id_lectura = ".$reading_id)or trigger_error($db->ErrorMsg(), E_USER_ERROR);
            $to_delete_lm = $db->Execute("DELETE FROM `lectura_monitoreo` where id = ".$reading_id)or trigger_error($db->ErrorMsg(), E_USER_ERROR);
        }
        $to_delete_m = $db->Execute("DELETE FROM `monitoreo` where id_monitoreo = ".$m_id)or trigger_error($db->ErrorMsg(), E_USER_ERROR);
    }
    if (!$to_delete_m){
        $db->rollbackTrans();
    } else {
        $db->commitTrans();
    }
}
$queryBase = "
            SELECT m.id_monitoreo as idM ,if(!ISNULL(cl.comentarios),concat( m.id_monitoreo,' <i class=\"fas fa-comment-dots \" style=\"color: #5bb75b\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Comentarios\"></i>'),m.id_monitoreo)as id_monitoreo, 
             CONCAT(m.fecha,' ',m.hora) as  fecha, CONCAT('RESPONSABLE')  responsable,
            sr.nombre as subrancho,
            s.nombre as sector,  t.nombre as tunel,CONCAT('<center><a class=\"btn btn-primary btn-social-icon\"
            title=\"Reporte\" href=\"#\" onclick=\"loadDetailMonitoreo(',m.id_monitoreo,')\"><i class=\"fa fa-search\" ></i></a></center> ') as opciones , cl.comentarios FROM `monitoreo` as m
            INNER JOIN lectura_monitoreo as lm ON lm.id_monitoreo = m.id_monitoreo
            INNER JOIN subrancho sr ON m.id_up = sr.num_subrancho 
            INNER JOIN sector as s ON s.id_sector = m.id_tabla
            INNER JOIN tuneles as t ON t.id_tunel = m.id_tunel
            left JOIN comentarios_lecturas cl on cl.id_lectura=lm.id
            WHERE m.status_id = 1 and m.fecha between '".$ar_data['fechaInicio']."' and '".$ar_data['fechaFin']."'
            GROUP BY m.id_monitoreo";
$rs= $db->Execute($queryBase)or trigger_error($db->ErrorMsg(), E_USER_ERROR);

$params = $columns = $totalRecords = $data = array();
$params = $request;
$columns = array(0=>'id',1=> 'fecha', 2 => 'subrancho', 3 => 'numero', 4 => 'cultivo',5=>'datos_eti', 6=>'viajes', 7=>'opciones');

$i = 0;
if ($rs->recordCount() > 0) {
    foreach ($rs as $key => $val) {
        $btnFotos='';
       $busquedaF= $db->Execute("select * from fotos_monitoreo where  id_monitoreo=".$val['idM']." ")->numRows();
       if($busquedaF >=1){
           $btnFotos='<center><button class="btn btn-success mostrar-fotos" data-idmon="'.$val['idM'].'"  data-toggle="modal" data-target="#monitoreoModalFotos"><i class="fas fa-camera"></i></button></center>';
       }

        $data[$i][] = $val['id_monitoreo'];
        $data[$i][] = $val['fecha'];
        $data[$i][] = $val['responsable'];
        $data[$i][] = $val['subrancho'];
        $data[$i][] = $val['sector'];
        $data[$i][] = $val['tunel'];
        $data[$i][] = $val['opciones'].' '.$btnFotos;
        $i++;
    }
}
$totalRecords = $i;

$json_data = array(
    "draw" => intval($params['draw']),
    "recordsTotal" => intval($totalRecords),
    "recordsFiltered" => intval($totalRecords),
    "data" => $data
);
ob_start('ob_gzhandler');
echo json_encode($json_data);
ob_end_flush();

