<?php
require_once("modelo.php");
class Controller{
	private $model;
	function __construct(){
        $this->model=new Modelo();
    }
    // MOSTRAR
    public static function index(){
    	$producto 	=	new Modelo();
		$dato=$producto->mostrar("movtos_prod","1");
		require_once("vista.php");
    }
}