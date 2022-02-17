<?php
header('Content-Type: application/json; charset=utf-8');
$db->debug=0;
$monitoring_id = $ar_data['id']; 
$to_update = $db->Execute("UPDATE monitoreo SET status_id = '1' where id_monitoreo = ".$monitoring_id)or trigger_error($db->ErrorMsg(), E_USER_ERROR);
if($to_update == true){
    $data_return[0]              = false;
    $data_return[1]              = '¡Excelente!';
    $data_return[2]              = 'Se actualizó correctamente el status del monitoreo';
}else{
    $data_return[0]              = true;
    $data_return[1]              = '¡Hubo un error!';
    $data_return[2]              = 'No se pudo actualizar el status del monitoreo por: '.$db->ErrorMsg();
}
echo json_encode($data_return);
?>