<?php
$event = filter_input(INPUT_GET, 'event', FILTER_SANITIZE_STRING);
if (empty($event)) {
    $event = filter_input(INPUT_POST, 'event', FILTER_SANITIZE_STRING);
}
if (true == is_numeric($event)) {
    $event = bindec($event);
} else {
    $event = $event;
}
handler($event);
function handler($event)
{
    $ar_data = helper_data();
    global $db;
    $oEmpleado = get_obj();
    switch ($event) {
        case 1:
            if(isset($ar_data['id_item']) && !empty($ar_data['id_item'])){
                $ID = $ar_data['id_item'];
                $result = $oEmpleado->Load(' id_emp ='.$ID);
                if (true == $result) {
                    $arAttibutes = $oEmpleado->getAttributeNames();
                    foreach ($arAttibutes as $attribute) {
                        //echo "title : ".$attribute. " = ";
                           $$attribute = $oEmpleado->$attribute;
                        //echo "<br><br>";
                    }
                } else {
                    $rs = filter_var($oEmpleado->ErrorMsg(), FILTER_SANITIZE_SPECIAL_CHARS);
                    echo $rs;
                }
            }
            include 'edit_view.php';
            break;
        case 2:
            include 'list_view.php';
            break;
        case 4:
            include 'jsons/list.php';
            break;
        case 6: //nuevo || editar
            $db->debug = 0;
            header('Content-Type: application/json; charset=utf-8');
            $arAttibutes = $oEmpleado->getAttributeNames();
            if (is_array($arAttibutes)) {
                $ID = $ar_data['id_emp'];
                foreach ($arAttibutes as $attribute) {
                    $oEmpleado->$attribute = $ar_data[$attribute];
                }
                if (empty($ID)) {
                    $rs = $oEmpleado->Save();
                    $arRes[2] = 'El Empleado guardó con éxito';
                } else {
                    $rs = $oEmpleado->Update();
                    $arRes[2] = 'La información se actualizó con éxito';
                }
                if (false == $rs  ) {
                    $err = filter_var($oEmpleado->ErrorMsg());
                    $arRes[0] = true;
                    $arRes[1] = 'Hubo un Error';
                    $arRes[2] = $err;
                } else {
                    $arRes[0] = false;
                    $arRes[1] = '¡Excelente!';
                }

            }
            echo json_encode($arRes);
            break;
        case 8:
            include 'jsons/load_cuadrillas.php';
            break;
        default:
            include 'list_view.php';
    }
}

function helper_data()
{
    $ar_data = filter_input_array(INPUT_POST);
    if (empty($ar_data)) {
        $ar_data = filter_input_array(INPUT_GET);
    }
    return $ar_data;
}
function get_obj()
{
    $obj = new CompactacionErosion();
    return $obj;
}