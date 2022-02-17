<?php
global  $db;
$db->debug = 0;
$dataResult='';

$dataFotos=$db->Execute("select fm.*, th.title as tipohallazgo from fotos_monitoreo fm inner join tipos_hallazgo th on fm.id_tipohallazgo = th.id where fm.id_monitoreo=".$ar_data['id_monitoreo'])->getRows();
$dataResult.='<div class="row">FECHA : '.$dataFotos[0]['fechacaptura'].'</div><br>';

$dataResult.='<div class="row">';
foreach ($dataFotos  as $keyF => $dataF){
    $dataResult.='<div class="col-md-6">
<h5>'.$dataF['tipohallazgo'].'</h5>
<iframe 
    title=""
    width="300"
    height="200"
    src="foto/'.$dataF['foto'].'">
</iframe></div>';
}
$dataResult.='</div>';

echo $dataResult;