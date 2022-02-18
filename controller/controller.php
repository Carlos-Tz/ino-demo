<?php
require_once("model/model.php");
class Controller{
	private $model;
	function __construct(){
        $this->model=new Modelo();
    }
    // MOSTRAR
    public static function index(){
		$rubro_model = new Modelo();
		$res_rubros = $rubro_model->getRubros();
		$clasificacion = array();
	    foreach ($res_rubros as $key => $value)
		foreach ($value as $va ): 
			$clasificacion[strtolower($va['clasificacion'])] = strtolower($va['clasificacion']);
		endforeach;
        $rubros = array_unique($clasificacion, SORT_STRING);
		$data_model = new Modelo();
		$data = $data_model->getData("*", "movtos_prod", "1");
		$name = "DISPOSICIONES DE EFECTIVO";
		/* $data2 = array_filter($data[0], function($v) use ($name) {
			return ($v['nom_prod'] == $name);
		}); */
		require_once("view/view.php");
		/* print json_encode($data, JSON_UNESCAPED_UNICODE); */
    }

	public static function intros($arr_param){
		$data_model = new Modelo();
		$data1 = $data_model->getData("*", "movtos_prod", "1");
		/* print json_encode($data, JSON_UNESCAPED_UNICODE); */
		/* print json_encode([
			'data' => $data,
		]); */
		/* require_once("view/entradas.php"); */
		$data = array();
		$draw = $_POST['draw'];
		foreach ($data1 as $row) {
			$data[] = array(
				"id_prod"=>$row['id_prod'],
				"cantidad"=>$row['cantidad'],
				"nom_prod"=>$row['nom_prod'],
				"clasificacion"=>$row['clasificacion'],
			);
		}
		// Response
		$response = array(
			"draw" => intval($draw),
			/* "iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordwithFilter, */
			"aaData" => $data
		);
		echo json_encode($response);
	}


    // INSERTAR
    function nuevo(){
    	require_once("vista/nuevo.php");	    	    	
    }
    function guardar(){
    	$nombre 	=	$_REQUEST['nombre'];
    	$precio 	=	$_REQUEST['precio'];
        $data       =   "'".$nombre."','".$precio."'";
    	$producto 	=	new Modelo();
		$dato 		=	$producto->insertar("productos",$data);
		header("location:".urlsite);
    }


    // ACTUALIZAR

    function editar(){
    	$id=$_REQUEST['id'];
    	$producto 	=	new Modelo();
    	$dato=$producto->mostrar("productos","id=".$id);    	
    	require_once("vista/editar.php");
    }
    function update(){
    	$id 		= 	$_REQUEST['id'];
    	$nombre 	=	$_REQUEST['nombre'];
    	$precio 	=	$_REQUEST['precio'];
        $data       =   "nombre='".$nombre."', precio=".$precio;
        $condicion  =   "id=".$id;
    	$producto 	=	new Modelo();
		$dato 		=	$producto->actualizar("productos",$data,$condicion);
        header("location:".urlsite);
	}

    // ELIMINAR

	function eliminar(){		
		$id 		= 	$_REQUEST['id'];    	
        $condicion  =   "id=".$id;
    	$producto 	=	new Modelo();        
		$dato 		=	$producto->eliminar("productos",$condicion);
		header("location:".urlsite);
	}
}