<?php
header('Content-Type: application/json; charset=utf-8');
$oCatalog = new $catalog;
if($catalog == "Tipos_Hallazgos"){
    $data_catalog = $oCatalog->Find('status_id = 1');
}else{
    $data_catalog = $oCatalog->Find('id_estatus = 1');
}
if($tipo != false){
    $data_catalog = $oCatalog->Find("id_tipo = '$tipo' AND estatus = 1");
}
if (is_array($data_catalog) && !empty($data_catalog)) {
    foreach ($data_catalog as $key => $catalog) {
        $arJson[$key]['id']    = $catalog->id;
        $arJson[$key]['label'] = $catalog->title;
    }
} 
ob_start('ob_gzhandler');
echo json_encode($arJson);
ob_end_flush();
