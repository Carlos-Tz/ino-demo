<?php
header('Content-Type: application/json; charset=utf-8');
$oTunel = new Tuneles;
$data_tunel = $oTunel->Find('id_sector = '.$id_sector);
    if (is_array($data_tunel) && !empty($data_tunel)) {
        foreach ($data_tunel as $key => $tunel) {
            $arJson[$key]['id'] = $tunel->id_tunel;
            $arJson[$key]['label'] = $tunel->nombre;
        }
    } 
ob_start('ob_gzhandler');
echo json_encode($arJson);
ob_end_flush();
