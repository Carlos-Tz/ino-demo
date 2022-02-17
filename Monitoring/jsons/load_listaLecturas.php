<?php
header('Content-Type: application/json; charset=utf-8');
$db->debug = 0;
$db->Execute('DROP view IF EXISTS `lista_lecturas_monitoreos`') or trigger_error($db->ErrorMsg(), E_USER_ERROR);

$queryBase = "CREATE view lista_lecturas_monitoreos as 
            SELECT lm.id as id_lectura, lm.num_planta, lh.id_hallazgo, lh.cantidad, h.title as hallazgo, th.title as tipo_de_hallazgo, 
            cl.comentarios, if(length(cl.comentarios)>=1 and (isnull(cl.respuestaComentario) or length(cl.respuestaComentario)=0), concat('<button type=\"button\" class=\"btn btn-success respuestaCome\" onclick=\"loadId(',lm.id,')\"  data-toggle=\"modal\" data-target=\"#respuestaCom\" title=\"Agregar Respuesta al Comentario\"  value=\"',lm.id,'\" ><i class=\"fas fa-plus-square\"></i></button>'),cl.respuestaComentario) as respuestaComentario FROM `lectura_monitoreo` lm 
            INNER JOIN lectura_hallazgos lh ON lm.id = lh.id_lectura 
            LEFT JOIN comentarios_lecturas cl ON cl.id_lectura = lm.id
            LEFT JOIN hallazgos h ON lh.id_hallazgo = h.id 
            LEFT JOIN tipos_hallazgo th ON h.id_tipo = th.id 
            WHERE id_monitoreo = ".$id_monitoreo;
$db->Execute($queryBase)or trigger_error($db->ErrorMsg(), E_USER_ERROR);
$table = 'lista_lecturas_monitoreos';
$primaryKey = 'id_lectura';
$columns = array(
    array('db' => 'num_planta', 'dt' => 0),
    array('db' => 'cantidad', 'dt' => 1),
    array('db' => 'hallazgo', 'dt' => 2),
    array('db' => 'tipo_de_hallazgo', 'dt' => 3),
    array('db' => 'comentarios', 'dt' => 4),
    array('db' => 'respuestaComentario', 'dt' => 5)
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