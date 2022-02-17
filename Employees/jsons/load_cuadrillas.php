<?php
header('Content-Type: application/json; charset=utf-8');
global $db;
$db->debug = 0;
$array_ = $db->Execute('select * from cuadrilla where status=1')->getRows();
if (is_array($array_) && !empty($array_)) {
    foreach ($array_ as $key => $group) {
        $arJson[$key]['id'] = $group['id_cuadrilla'];
        $arJson[$key]['label'] = $group['nom_cuadrilla'];
    }
}
ob_start('ob_gzhandler');
echo json_encode($arJson);
ob_end_flush();
