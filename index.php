<?php

require_once("controller/controller.php");
if(isset($_GET['meth'])):
    $metodo = $_GET['meth'];
    echo $metodo;
    $arr_param = filter_input_array(INPUT_POST);
    if (empty($arr_param)) {
        $arr_param = filter_input_array(INPUT_GET);
    }
    if(method_exists(Controller, $metodo)):
        Controller::{$metodo}($arr_param);
    endif;
else:
    Controller::index();
endif;
?>