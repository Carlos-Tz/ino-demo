<?php
header('Content-Type: application/json; charset=utf-8');
$oSubRancho = new SubRancho;
$data_subrancho = $oSubRancho->Find('');
    if (is_array($data_subrancho) && !empty($data_subrancho)) {
        foreach ($data_subrancho as $key => $subrancho) {
            $arJson[$key]['id'] = $subrancho->num_subrancho;
            $arJson[$key]['label'] = $subrancho->nombre;
        }
    } 
ob_start('ob_gzhandler');
echo json_encode($arJson);
ob_end_flush();
