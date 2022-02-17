<?php

require_once("controller/controller.php");
if(isset($_GET['m'])):
    $metodo =   $_GET['m'];
    if(method_exists(Controller, $metodo)):
        Controller::{$metodo}();
    endif;
else:
    Controller::index();
endif;
?>