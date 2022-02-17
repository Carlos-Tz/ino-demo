<?php
include_once('../../core/config.php');
set_time_limit(1200);
include('../../classes/PHPExcel/Classes/PHPExcel.php');
$db->debug = 0;
$id_monitoreo = $_GET['id_monitoreo'];
$objPHPExcel = new    PHPExcel();


$result = $db->Execute("SELECT m.id_up as id_subrancho, sr.nombre as subrancho, sr.logo 
FROM monitoreo m INNER JOIN subrancho sr ON m.id_up = sr.num_subrancho 
INNER JOIN lectura_monitoreo lm on lm.id_monitoreo= m.id_monitoreo 
INNER JOIN lectura_hallazgos lh on lh.id_lectura=lm.id where m.status_id=1  and m.fecha between '".$ar_data['fechaInicio']."' and '".$ar_data['fechaFin']."'
group by sr.num_subrancho")->getRows() or die(mysql_error());

$array_subranchos = array();
foreach ($result as $data) {
    $array_subranchos[$data['id_subrancho']]['id_subrancho'] = $data['id_subrancho'];
    $array_subranchos[$data['id_subrancho']]['subrancho'] = $data['subrancho'];
    $array_subranchos[$data['id_subrancho']]['logo'] = $data['logo'];
}

$index = 0;
$style = array( //array of styles for cells
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
    ''
);
$styleArray = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    )
);

$styleArrayCabeceraUno = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM
        )
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
    'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '4db6ac'))

);

$styleArrayCabeceraDos = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM
        )
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
    'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '80cbc4'))
);

$styleArrayCabeceraTres = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM
        )
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
    'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '81c784'))
);


foreach ($array_subranchos as $subrancho) {
    //echo "SUB RANCHO: ".$subrancho['id_subrancho'];
    //echo "<br><br>";
    $data_PEB = $db->Execute("SELECT * FROM `lectura_monitoreo` lm INNER JOIN monitoreo m ON m.id_monitoreo = lm.id_monitoreo
                            inner  join lectura_hallazgos lh on lm.id = lh.id_lectura where m.id_up = " . $subrancho['id_subrancho']);
    $array_plagas = array();
    $array_letras = array();
    $array_idsPlagas = array();
    //$db->debug=1;
    $array_idHallazgos = array();
    $array_datosHallazgos = array();
    $data_hallazgos = $db->Execute("SELECT ti.* from tipos_hallazgo ti
                                    INNER JOIN hallazgos ha on ti.id= ha.id_tipo INNER JOIN lectura_hallazgos le on le.id_hallazgo= ha.id
                                    inner join lectura_monitoreo lm on le.id_lectura = lm.id inner join monitoreo m on lm.id_monitoreo = m.id_monitoreo
                                    where m.id_up=" . $subrancho['id_subrancho'] . " GROUP by ti.id");
    foreach ($data_hallazgos as $data_h) {
        //echo "TIPO HALLAZ: ".$data_h['title'];
        //echo "<br><br>";
        foreach ($data_PEB as $data) { //get the names of pests, diseases and beneficial
            $data_plaga = $db->Execute("select * from hallazgos where id= " . $data['id_hallazgo'] . " and id_tipo=" . $data_h['id']);
            if ($data_plaga->fields['title'] != null) {
                $nombre_plaga = $data_plaga->fields['title'];
                if (!in_array($nombre_plaga, $array_plagas)) {
                    // echo "HALLAZGO : ".$data_plaga->fields['title'];
                    //echo "<br><br>";
                    $array_plagas[] = $nombre_plaga;
                    $array_idsPlagas[] = $data_plaga->fields['id'];
                }
            }
        }
        //$array_idHallazgos[$data_h['title']] = $array_idsPlagas;
        $array_datosHallazgos[$data_h['title']]['plagas'] = $array_plagas;
        $array_datosHallazgos[$data_h['title']]['tipoCalculo'] = $data_h['tipoMedicion'];
        // $array_idsPlagas = [];
        $array_plagas = [];
    }
    //echo "<br><hr><br>";


    $objPHPExcel->createSheet();
    $sheet = $objPHPExcel->getActiveSheet();
    //__OBJETO PARA IMAGEN
    $sheet = $objPHPExcel->setActiveSheetIndex($index);
    $sheet->mergeCells('B2:C3');
    $sheet->getRowDimension('2')->setRowHeight(25);
    $sheet->getColumnDimension('B')->setWidth(100);
    if (!empty($subrancho['logo'])) {

        if (__DIR__ . '/../../assets/img/' . $subrancho['logo']) {
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Logo');
            $objDrawing->setDescription('Logo');
            $logo = __DIR__ . '/../../assets/img/' . $subrancho['logo']; // Provide path to your logo file
            $objDrawing->setPath($logo);
            $objDrawing->setOffsetX(2);  // setOffsetX works properly
            $objDrawing->setOffsetY(2);  //setOffsetY has no effect
            $objDrawing->setCoordinates('B2');
            $objDrawing->setResizeProportional(true); // logo height
            $objDrawing->setHeight(220); // logo height
            $objDrawing->setWidth(120); // logo height
            $objDrawing->setWorksheet($sheet);
        } else {
            $sheet->SetCellValue('B2', 'IMAGEN NO ENCONTRADA');
        }
    } else {
        $sheet->SetCellValue('B2', 'SIN REGISTRO');
    }
    $objPHPExcel->getActiveSheet($index)->setTitle($subrancho['subrancho']);
    $sheet->SetCellValue('A1', 'REPORTE DE MONITOREOS DEL RANCHO: ' . strtoupper($subrancho['subrancho']));
    $sheet->SetCellValue('A4', 'SECTOR');
    $sheet->getStyle('A4')->applyFromArray($styleArrayCabeceraTres);
    $sheet->SetCellValue('B4', 'TUNEL');
    $sheet->getStyle('B4')->applyFromArray($styleArrayCabeceraTres);
    $sheet->SetCellValue('C4', 'FECHA');
    $sheet->getStyle('C4')->applyFromArray($styleArrayCabeceraTres);
    $letras = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",
        "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ",
        "BA", "BB", "BC", "BD", "BE", "BF", "BG", "BH", "BI", "BJ", "BK", "BL", "BM", "BN", "BO", "BP", "BQ", "BR", "BS", "BT", "BU", "BV", "BW", "BX", "BY", "BZ",
        "CA", "CB", "CC", "CD", "CE", "CF", "CG", "CH", "CI", "CJ", "CK", "CL", "CM", "CN", "CO", "CP", "CQ", "CR", "CS", "CT", "CU", "CV", "CW", "CX", "CY", "CZ");
    $x = 3;
    $ix = 3;
    $contTres = 3;
    $palabras = array(3 => 'Numero de Insectos', 4 => 'Numero de Plantas', 5 => 'Promedio');
    // print_r($array_datosHallazgos);

    foreach ($array_datosHallazgos as $dataTiposHall => $arrayNombreHall) {
        // echo "<br>";
        //print_r($arrayNombreHall['tipoCalculo'][0]);
        //echo "TIPO HALLAZGO: ".$dataTiposHall;
        //echo "<br><br>";
        foreach ($arrayNombreHall['plagas'] as $dataNombr) {
            // echo "NOMBRE HALLAZGO: ".$dataNombr;
            $letra = $letras[$x] . "3";
            $array_letras[$dataNombr] = $letras[$x];
            $sheet->mergeCells($letras[$x] . "3:" . $letras[$x + 2] . "3");
            $sheet->SetCellValue($letra, $dataNombr);
            $sheet->getStyle($letras[0] . "3:" . $letras[$x + 2] . "3")->applyFromArray($styleArrayCabeceraTres);
            for ($xd = 3; $xd < 6; $xd++) { //lectura de los tres datos por cada una de las plagas/insectos/ enfermedades
                if ($arrayNombreHall['tipoCalculo'][0] == 2 && $xd == 5) {
                    $pal = 'Unidad';
                } else {
                    $pal = $palabras[$xd];
                }
                $letraDos = $letras[$contTres] . "4";
                $sheet->SetCellValue($letraDos, $pal);
                $sheet->getStyle($letraDos)->applyFromArray($styleArrayCabeceraTres);
                $sheet->getStyle($letraDos)->getAlignment()->setWrapText(true);
                $contTres++;
            }
            $x = $x + 3;
            // echo "<br>";
        }
        $iy = $x - 1;
        $objPHPExcel->setActiveSheetIndex($index)->mergeCells($letras[$ix] . "2:" . $letras[$iy] . "2");
        $sheet->SetCellValue($letras[$ix] . "2", $dataTiposHall);
        $sheet->getStyle($letras[0] . "2:" . $letras[$iy] . "2")->applyFromArray($styleArrayCabeceraDos);
        //echo "<br><br><hr><br>";
        $ix = $x;
    }
    $x++;

    //$sheet->mergeCells($letras[$ix] . "2:" . $letras[$ix] . "4");
    $sheet->SetCellValue($letras[$ix] . "4", 'Condición Meteorológica');
    $sheet->getStyle($letras[$ix] . "2:" . $letras[$ix] . "4")->applyFromArray($styleArrayCabeceraTres);
    $sheet->getStyle($letras[$ix] . "2")->getAlignment()->setWrapText(true);
    //$sheet->mergeCells($letras[++$ix] . "2:" . $letras[$ix] . "4");
    $sheet->SetCellValue($letras[++$ix] . "4", 'Etapa Fenológica');
    $sheet->getStyle($letras[$ix] . "2:" . $letras[$ix] . "4")->applyFromArray($styleArrayCabeceraTres);
    $sheet->getStyle($letras[$ix] . "2")->getAlignment()->setWrapText(true);
    //$sheet->mergeCells($letras[++$ix] . "2:" . $letras[$ix] . "4");
    $sheet->SetCellValue($letras[++$ix] . "4", 'Comentario');
    $sheet->getStyle($letras[$ix] . "2:" . $letras[$ix] . "4")->applyFromArray($styleArrayCabeceraTres);
    $sheet->getStyle($letras[$ix] . "2")->getAlignment()->setWrapText(true);
    //$sheet->mergeCells($letras[++$ix] . "2:" . $letras[$ix] . "4");
    $sheet->SetCellValue($letras[++$ix] . "4", 'Respuesta');
    $sheet->getStyle($letras[$ix] . "2:" . $letras[$ix] . "4")->applyFromArray($styleArrayCabeceraTres);
    $sheet->getStyle($letras[$ix] . "2")->getAlignment()->setWrapText(true);

    $objPHPExcel->getActiveSheet()->getStyle("A2:" . $letras[$ix] . "3")->getFont()->setBold(true);
    $objPHPExcel->setActiveSheetIndex($index)->mergeCells("A1:" . $letras[$ix] . "1");
    $objPHPExcel->getActiveSheet()->getStyle("A1:" . $letras[$ix] . "1")->applyFromArray($styleArrayCabeceraUno);

    //LLENADO
    $data_Mo = $db->Execute("
select mo.id_monitoreo, mo.fecha, se.nombre as nombreSec, t.nombre as nombreTun, me.title as clima, ps.title as fenologia, lh.id, cl.comentarios, cl.respuestaComentario
from monitoreo mo inner  join sector se on mo.id_tabla= se.id_sector
                  inner  join lectura_monitoreo lm on mo.id_monitoreo = lm.id_monitoreo
                  inner join  lectura_hallazgos lh on lm.id = lh.id_lectura
                  inner  join tuneles t on mo.id_tunel = t.id_tunel
                  inner  join meteorological_conditions me on mo.id_clima= me.id
                  inner join phenological_stage ps on mo.id_fenologia = ps.id
                left join comentarios_lecturas cl on lh.id_lectura = cl.id_lectura
                  where mo.id_up=" . $subrancho['id_subrancho'] . " and mo.status_id=1 and mo.fecha between '".$ar_data['fechaInicio']."' and '".$ar_data['fechaFin']."'   order by se.id_sector, mo.fecha desc")->getRows();
    $rowCount = 5;
    $arraySectoresPromedios = array();
    foreach ($data_Mo as $keyM => $data_M) {
        //print_r($data_M);
        $sheet->SetCellValue($letras[0] . $rowCount, mb_strtoupper($data_M['nombreSec'], 'UTF-8'));
        $sheet->SetCellValue($letras[1] . $rowCount, mb_strtoupper($data_M['nombreTun'], 'UTF-8'));
        $sheet->SetCellValue($letras[2] . $rowCount, mb_strtoupper($data_M['fecha'], 'UTF-8'));
        $posLetra = 3;
        foreach ($array_idsPlagas as $key => $valor) {

            $plaga = $db->Execute("select mo.cant_plantas_eval, lh.cantidad from monitoreo mo
                                    inner  join  lectura_monitoreo lm on mo.id_monitoreo = lm.id_monitoreo
                                    inner  join lectura_hallazgos lh on lm.id = lh.id_lectura
                                    where lh.id_hallazgo=" . $valor . " AND lh.id =" . $data_M['id']);
            //echo $letras[$posLetra]. $rowCount."<BR>";
            $sheet->SetCellValue($letras[$posLetra] . $rowCount, mb_strtoupper($plaga->fields['cantidad'], 'UTF-8'));
            $posLetra++;
            //echo $letras[$posLetra]. $rowCount."<br>";
            $sheet->SetCellValue($letras[$posLetra] . $rowCount, mb_strtoupper($plaga->fields['cant_plantas_eval'], 'UTF-8'));
            $posLetra++;
            // echo $letras[$posLetra]. $rowCount."<br>";
            //LLENADO DE LOS ARRAYS PARA LOS PROMEDIOS POR PLAGA POR SECTOR
            $arraySectoresPromedios[$data_M['nombreSec']][$data_M['fecha']][$letras[$posLetra]]['celdas'][] = $rowCount;
            $arraySectoresPromedios[$data_M['nombreSec']][$data_M['fecha']][$letras[$posLetra]]['cantidadPlagas'][] = $plaga->fields['cantidad'];
            $arraySectoresPromedios[$data_M['nombreSec']][$data_M['fecha']][$letras[$posLetra]]['cantidadPlantas'][] = $plaga->fields['cant_plantas_eval'];
            $posLetra++;
        }
        $sheet->SetCellValue($letras[$posLetra] . $rowCount, mb_strtoupper($data_M['clima'], 'UTF-8'));
        $posLetra++;
        $sheet->SetCellValue($letras[$posLetra] . $rowCount, mb_strtoupper($data_M['fenologia'], 'UTF-8'));
        $posLetra++;
        $sheet->SetCellValue($letras[$posLetra] . $rowCount, mb_strtoupper($data_M['comentarios'], 'UTF-8'));
        $posLetra++;
        $sheet->SetCellValue($letras[$posLetra] . $rowCount, mb_strtoupper($data_M['respuestaComentario'], 'UTF-8'));
        //echo "<br><br><hr><br>";
        $rowCount++;
    }
    // var_dump($arraySectoresPromedios);
    foreach ($arraySectoresPromedios as $KeySector => $arrayFecha) {
        //echo "<br><br><br><hr>".$KeySector."<br><br>";
        foreach ($arrayFecha as $KeyLetra => $arrayLetra) {
            //echo "<br><br>FECHA <br>";
            foreach ($arrayLetra as $keyLetra => $arrayDatos) {
                //DATOS DE MERGE LETRAS
                //echo "<BR>DATOS DE LA LETRA :".$keyLetra."&nbsp;&nbsp; : &nbsp;";
                $posIni = reset($arrayDatos['celdas']);
                $posFin = end($arrayDatos['celdas']);
                //echo "MERGE: ".$keyLetra.$posIni.":".$keyLetra.$posFin."&nbsp; &nbsp; ||";
                $objPHPExcel->setActiveSheetIndex($index)->mergeCells($keyLetra . $posIni . ":" . $keyLetra . $posFin);
                //DATOS DE PROMEDIOS
                $cantidadPlaga = 0;
                $cantidadPlanta = 0;
                foreach ($arrayDatos['cantidadPlagas'] as $cantidadPla) {
                    //echo " ".$promedio."&nbsp;";
                    $cantidadPlaga += floatval($cantidadPla);
                }
                foreach ($arrayDatos['cantidadPlantas'] as $cantidadPlan) {
                    //echo " ".$promedio."&nbsp;";
                    $cantidadPlanta += floatval($cantidadPlan);
                }
                if ($cantidadPlaga != 0) {
                    $promedioTotal = $cantidadPlaga / $cantidadPlanta;
                } else {
                    $promedioTotal = 0;
                }
                $valorCelda = $sheet->getCell($keyLetra . '4')->getValue();
                //echo "valor de la celda: " . $keyLetra . " VALOR: " . $valorCelda . "<BR>";
                if ($valorCelda == 'Unidad') {
                    if ($cantidadPlaga == 0) {
                        $valorcCeldaFinal = '';
                    } else {
                        $valorcCeldaFinal = $cantidadPlaga;
                    }
                    $cantidadPlaga = 0;
                } else {
                    if ($promedioTotal == 0) {
                        $valorcCeldaFinal = '';
                    } else {
                        $valorcCeldaFinal = round($promedioTotal, 2);
                    }
                }
                // ECHO "&nbps; &nbps; PROMEDIO GEN: ".$promedioTotal;
                //echo "<br>";
                $sheet->SetCellValue($keyLetra . $posIni, mb_strtoupper($valorcCeldaFinal, 'UTF-8'));
                $sheet->getStyle($keyLetra . $posIni)->applyFromArray($style);
            }
        }
    }

    //auto size de las culumnas

    foreach (range('0', $ix) as $columnID) {
        // echo $letras[$columnID]."<br>";
        $objPHPExcel->getActiveSheet()->getColumnDimension($letras[$columnID])->setAutoSize(true);
    }

    $index++;
}


header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=\"Reporte_Monitoreo-" . $id_monitoreo . date('His')."_2021.xlsx\"");
header('Cache-Control: max-age=0');
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header ('Cache-Control: cache, must-revalidate');
header ('Pragma: public');


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_end_clean();
$objWriter->save('php://output');

/*
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename=); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');*/

?>
