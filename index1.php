<?php

require_once("controller/controller.php");
if(isset($_POST['meth'])):
    $metodo = $_POST['meth'];
    /* echo $metodo; */
    $arr_param = filter_input_array(INPUT_POST);
    if (empty($arr_param)) {
        $arr_param = filter_input_array(INPUT_GET);
        /* echo 'get'; */
    }
    /* print_r($arr_param); */
    if(method_exists('Controller', $metodo)):
        Controller::{$metodo}($arr_param);
    endif;
else:
    Controller::index();
endif;
?>