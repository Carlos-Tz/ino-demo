<?php

if (isset($_GET['event'])) {
    $input_type = INPUT_GET;
} else {
    $input_type = INPUT_POST;
}
$event = filter_input($input_type, 'event', FILTER_SANITIZE_STRING);
if (true == is_numeric($event)) {
    $evento = bindec($event);
} else {
    $evento = $event;
}
handler($evento);

function handler($event)
{
    $ar_data = helper_data();
    global $db;
    switch ($event) {
        case 1:
            include 'list_view.php';
            break;
        case 2:
            include 'jsons/load_subranchos.php';
            break;
        case 3:
            $num_subrancho = $ar_data['subrancho'];
            include 'jsons/load_sectores.php';
            break;
        case 4:
            $id_sector = $ar_data['id_sector'];
            include 'jsons/load_tuneles.php';
            break;
        case 5:
            $tipo = $ar_data['id_tipo'] ?: 0;
            $catalog = $ar_data['catalog'];
            include 'jsons/load_catalogs.php';
            break;
        case 6:
            $db->debug = 0;
            $oMonitoreo = New Monitoreo();
            $id_monitoreo = $ar_data['id_monitoreo'];
            if ($id_monitoreo == 0) {
                $oMonitoreo->fecha = date('Y-m-d');
                $oMonitoreo->hora = date('H:i:s');
                $oMonitoreo->id_tunel = $ar_data['id_tunel'];
                $oMonitoreo->id_tabla = $ar_data['id_sector'];
                $oMonitoreo->id_up = $ar_data['num_subrancho'];
                $oMonitoreo->id_clima = $ar_data['cond_met'];
                $oMonitoreo->id_fenologia = $ar_data['etapa_fen'];
                $oMonitoreo->cant_plantas_eval = $ar_data['num_plantas'];
                $oMonitoreo->status_id = 2; //procesing
                $save_result = $oMonitoreo->save();
                if ($save_result == true) {
                    $num_plantas = $ar_data['num_plantas'];
                    $id_monitoreo = $db->Insert_ID();
                    $oLecturaMonitoreo = new Lectura_Monitoreo();
                    $res_consult_lm = $db->Execute("SELECT * FROM lectura_monitoreo WHERE id_monitoreo = " . $id_monitoreo);
                    $recordCount = $res_consult_lm->recordCount();
                    if ($recordCount == 0) {
                        $oLecturaMonitoreo->id = NULL;
                        $oLecturaMonitoreo->id_monitoreo = $id_monitoreo;
                        $oLecturaMonitoreo->num_planta = 1;
                        $lm_save = $oLecturaMonitoreo->save();
                        $id_lectura = $db->Insert_ID();
                    }
                    $data_message = "El monitoreo se generó con éxito";
                    $data_return['id_lectura_m'] = $id_lectura;
                    $data_return['id_monitoreo'] = $id_monitoreo;
                    $data_return['num_lm'] = $recordCount; //numero de lecturas por monitoreo
                    $data_return['num_plantas'] = $num_plantas;
                    $data_return[0] = false;
                    $data_return[1] = '¡Excelente!';
                    $data_return[2] = $data_message;
                } else {
                    $error = "No se pudo generar el monitoreo, revise la siguiente información: [" . filter_var($oMonitoreo->ErrorMsg() . "]");
                    $data_return[0] = true;
                    $data_return[1] = '¡Ocurrió un error!';
                    $data_return[2] = $error;
                }
            } else {
                $res_consult = $oMonitoreo->Load("id_monitoreo = '$id_monitoreo'");
                if ($res_consult == true) {
                    $num_plantas = $oMonitoreo->cant_plantas_eval;
                    $save_result = $oMonitoreo->update();
                    if ($save_result == true) {
                        $data_message = "El monitoreo se actualizó con éxito";
                        $data_return['id_monitoreo'] = $id_monitoreo;
                        $data_return['num_plantas'] = $num_plantas;
                        $data_return[0] = false;
                        $data_return[1] = '¡Excelente!';
                        $data_return[2] = $data_message;
                    } else {
                        $error = "No se pudo actualizar el monitoreo, revise la siguiente información: [" . filter_var($oMonitoreo->ErrorMsg() . "]");
                        $data_return[0] = true;
                        $data_return[1] = '¡Ocurrió un error!';
                        $data_return[2] = $error;
                    }
                } else {
                    $error = "El identificador de monitoreo es incorrecto";
                    $data_return[0] = true;
                    $data_return[1] = '¡Ocurrió un error!';
                    $data_return[2] = $error;
                }
            }
            echo json_encode($data_return);
            break;
        case 7:
            $db->debug = 0;
            $oMonitoreo = New Monitoreo();
            $id_monitoreo = $ar_data['id_monitoreo'];
            if ($id_monitoreo != 0 && $ar_data['num_planta'] != 0) {
                if ($ar_data['num_planta'] == $ar_data['num_plantas']) {
                    $data_message = "La lectura se guardó con éxito";
                    if (!empty($ar_data['comentarios'])) {
                        $oComentarios = new Comentarios();
                        $oComentarios->id_lectura = $ar_data['id_lectura_m'];
                        $oComentarios->comentarios = $ar_data['comentarios'];
                        $save_com = $oComentarios->save();
                        if ($save_com == false) {
                            $data_message .= "No se pudo guardar el comentario de la lectura";
                        }
                    }
                    $data_return[0] = false;
                    $data_return[1] = '¡Excelente!';
                    $data_return[2] = $data_message;
                    $data_return['num_lm'] = $ar_data['num_planta'] + 1;
                    $data_return['num_plantas'] = $ar_data['num_plantas'];
                    $data_return['id_monitoreo'] = $id_monitoreo;
                    echo json_encode($data_return);
                    exit;
                }
                $load_result = $oMonitoreo->load('id_monitoreo = ' . $id_monitoreo);
                if ($load_result == true) {
                    $oLecturaMonitoreo = new Lectura_Monitoreo();
                    $oLecturaMonitoreo->id = NULL;
                    $oLecturaMonitoreo->id_monitoreo = $id_monitoreo;
                    $oLecturaMonitoreo->num_planta = $ar_data['num_planta'] + 1;

                    $lm_save = $oLecturaMonitoreo->save();
                    $id_lectura = $db->Insert_ID();

                    if ($lm_save == true) {
                        $error_com = "";
                        if (!empty($ar_data['comentarios'])) {
                            $oComentarios = new Comentarios();
                            $oComentarios->id_lectura = $ar_data['id_lectura_m'];
                            $oComentarios->comentarios = $ar_data['comentarios'];
                            $save_com = $oComentarios->save();
                            if ($save_com == false) {
                                $error_com = "No se pudo guardar el comentario de la lectura";
                            }
                        }

                        $data_message = "La lectura se guardó con éxito";
                        $data_return['id_lectura_m'] = $id_lectura;
                        $data_return['id_monitoreo'] = $id_monitoreo;
                        $data_return['num_lm'] = $ar_data['num_planta'] + 1;
                        $data_return['num_plantas'] = $ar_data['num_plantas'];
                        $data_return[0] = false;
                        $data_return[1] = '¡Excelente!';
                        if (!empty($error_com)) {
                            $data_return[2] = $data_message . "[" . $error_com . "]";
                        } else {
                            $data_return[2] = $data_message;
                        }
                    } else {
                        $error = "No se pudo guardar la lectura, revise la siguiente información: [" . filter_var($oLecturaMonitoreo->ErrorMsg() . "]");
                        $data_return[0] = true;
                        $data_return[1] = '¡Ocurrió un error!';
                        $data_return[2] = $error;
                    }
                } else {
                    $error = "No se pudo guardar la lectura, el identificador de monitoreo es incorrecto";
                    $data_return[0] = true;
                    $data_return[1] = '¡Ocurrió un error!';
                    $data_return[2] = $error;
                }
            } else {
                $error = "El identificador de monitoreo es incorrecto o no hay más plantas por evaluar";
                $data_return[0] = true;
                $data_return[1] = '¡Ocurrió un error!';
                $data_return[2] = $error;
            }
            echo json_encode($data_return);
            break;
        case 8:
            include 'jsons/load_monitoreos.php';
            break;
        case    9:
            include 'principal_view.php';
            break;
        case 10:
            include 'export.php';
            break;
        case 11:
            $id_monitoreo = $_GET['id_monitoreo'];
            include 'jsons/detalle_monitoreo.php';
            break;
        case 12:
            //print_r($ar_data);
            $db->debug = 0;
            $oLM = New Lectura_Monitoreo();
            $id_lectura = $ar_data['id_lectura_m'];
            if ($id_lectura != 0) {
                $load_result = $oLM->load('id = ' . $id_lectura);
                if ($load_result == true) {
                    foreach ($ar_data['cantidad'] as $key => $valor) {
                        if ($valor >= 1) {
                            $oLecturaHallazgos = new Lectura_Hallazgos();
                            $oLecturaHallazgos->id = NULL;
                            $oLecturaHallazgos->id_lectura = $id_lectura;
                            $oLecturaHallazgos->id_hallazgo = $key;
                            $oLecturaHallazgos->cantidad = $valor;
                            $lh_save = $oLecturaHallazgos->save();
                            if ($lh_save == true) {
                                $data_return[0] = false;
                                $data_return[1] = '¡Excelente!';
                                $data_return[2] = "El hallazgo se registró con éxito";
                            } else {
                                $error = "No se pudo guardar el hallazgo, revise la siguiente información: [" . filter_var($oLecturaHallazgos->ErrorMsg() . "]");
                                $data_return[0] = true;
                                $data_return[1] = '¡Ocurrió un error!';
                                $data_return[2] = $error;
                                break;
                            }
                        }
                    }
                } else {
                    $error = "No se pudo guardar el hallazgo, el identificador de lectura es incorrecto";
                    $data_return[0] = true;
                    $data_return[1] = '¡Ocurrió un error!';
                    $data_return[2] = $error;
                }
            } else {
                $error = "El identificador de lectura es incorrecto o no hay más plantas por evaluar";
                $data_return[0] = true;
                $data_return[1] = '¡Ocurrió un error!';
                $data_return[2] = $error;
            }
            echo json_encode($data_return);
            break;
        case 13:
            $id_monitoreo = $_GET['id_monitoreo'];
            include 'jsons/load_listaLecturas.php';
            break;
        case 14:
            include 'jsons/load_monitoring_status.php';
            break;
        case 15:
            $msRe = "XD21";
            if (!empty($ar_data['idLectura'])) {
                $busquedaReg = $db->Execute("select * from comentarios_lecturas where id_lectura=" . $ar_data['idLectura'])->getRows();
                if (!empty($busquedaReg)) {
                    $db->Execute("update comentarios_lecturas set respuestaComentario='" . $ar_data['respuestaComentario'] . "' where id=" . $busquedaReg[0]['id']);
                    $msRe = "XD11";
                } else {
                    $db->Execute("insert  into comentarios_lecturas (id_lectura, comentarios, respuestaComentario)  
                                    values(" . $ar_data['idLectura'] . ", '','" . $ar_data['respuestaComentario'] . "')");
                    $msRe = "XD11";
                }
            } else {
                $msRe = "XD21";
            }
            echo $msRe;
            break;
        case 16: //load de tipos de hallazgo
            include 'jsons/load_tipoHallazFoto.php';
            break;
        case 17:
            $db->startTrans();
            $db->debug = 0;
            $rs = false;
            $res2 = true;
            if ( !empty($_GET['id'])) {
                $key = 0;
                $idM = $_GET['id'];
                $fechaCaptura= date('Y-m-d H:m:s');
                $rs = $db->Execute("insert into fotos_monitoreo (id_monitoreo, id_tipohallazgo,fechacaptura)
                                       values(" . $idM . "," . $_GET['id_TipoHallaz'] . ",'" . $fechaCaptura . "')");
                $idFo = $db->Insert_ID();

                $imagenCodificada = file_get_contents("php://input"); //Obtener la imagen

                if (strlen($imagenCodificada) <= 0) $res2=false;
                //La imagen traerá al inicio data:image/png;base64, cosa que debemos remover
                $imagenCodificadaLimpia = str_replace("data:image/jpeg;base64,", "", $imagenCodificada);
                //Venía en base64 pero sólo la codificamos así para que viajara por la red, ahora la decodificamos y
                /*todo el contenido lo guardamos en un archivo*/
                $imagenDecodificada = base64_decode($imagenCodificadaLimpia);
               // print_r($imagenDecodificada);

                //Calcular un nombre único
                $fechaI= date('Ymd_Hms');
                $nombreImagenGuardada = "foto_1_" . $fechaI . ".jpeg";

                //Escribir el archivo
                file_put_contents("foto/$nombreImagenGuardada", $imagenDecodificada);


                $rs = $db->Execute("update fotos_monitoreo set foto='" . $nombreImagenGuardada . "' where id=" . $idFo);

            }
            if (false == $rs && $res2 ==false) {
                $resPuesta[0]= false;
                $resPuesta[1] = '¡Error!';
                $resPuesta[2]= 'Error el guardar';
            } else {
                $db->completeTrans();
                $resPuesta[0]=true;
                $resPuesta[1] = '¡Excelente!';
                $resPuesta[2]='La Foto se guardo correctemente';
            }
            echo json_encode($resPuesta);
            break;
        case 18:
            include 'jsons/data_fotos.php';
            break;
        default:
            break;
    }
}

function get_obj()
{
    $obj = new SubRancho();
    return $obj;
}

function helper_data()
{
    $ar_data = filter_input_array(INPUT_POST);
    if (empty($ar_data)) {
        $ar_data = filter_input_array(INPUT_GET);
    }
    return $ar_data;
}


exit;
?>