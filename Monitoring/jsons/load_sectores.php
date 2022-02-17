<?php
header('Content-Type: application/json; charset=utf-8');
$oSector = new Sector;
$data_sector = $oSector->Find("num_subrancho = ".$num_subrancho." AND status = 'Activo'");
    if (is_array($data_sector) && !empty($data_sector)) {
        foreach ($data_sector as $key => $sector) {
            $arJson[$key]['id']    = $sector->id_sector;
            $arJson[$key]['label'] = $sector->nombre;
        }
    } 
ob_start('ob_gzhandler');
echo json_encode($arJson);
ob_end_flush();
?>