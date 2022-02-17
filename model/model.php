<?php
/* require_once("conectar/conecta.php"); */

class Modelo{
    private $Modelo;
    private $db;
    public function __construct(){
        $this->Modelo = array();
        $this->db=new PDO('mysql:host=localhost;dbname=inomac',"root","");
        /* $this->db = $this->conexion; */
    }

    public function getRubros(){
        $consul="select clasificacion from movtos_prod;";
        $resu=$this->db->query($consul);
        while($filas = $resu->FETCHALL(PDO::FETCH_ASSOC)) {
            $this->registros[]=$filas;
        }
        return $this->registros;
    }

    public function getData($colums, $table, $cond){
        $consul="select ".$colums." from ".$table." where ".$cond.";";
        $resu=$this->db->query($consul);
        while($filas = $resu->FETCHALL(PDO::FETCH_ASSOC)) {
            $this->registros[]=$filas;
        }

        return $this->registros;
    }


    public function insertar($tabla, $data){
        $consulta="insert into ".$tabla." values(null,". $data .")";
        $resultado=$this->db->query($consulta);
        if ($resultado) {
            return true;
        }else {
            return false;
        }
     }
    public function mostrar($colums, $tabla, $condicion){
        $consul="select ".$colums." from ".$tabla." where ".$condicion.";";
        /* $consul="select * from ".$tabla." where ".$condicion." ORDER BY clasificacion;"; */
            $resu=$this->db->query($consul);
            while($filas = $resu->FETCHALL(PDO::FETCH_ASSOC)) {
                $this->registros[]=$filas;
            }
            return $this->registros;
        } 
    public function actualizar($tabla, $data, $condicion){       
        $consulta="update ".$tabla." set ". $data ." where ".$condicion;
        $resultado=$this->db->query($consulta);
        if ($resultado) {
            return true;
        }else {
            return false;
        }
     }
    public function eliminar($tabla, $condicion){
        $eli="delete from ".$tabla." where ".$condicion;
        $res=$this->db->query($eli);
        if ($res) {
            return true; 
        }else {
            return false;
        }
    }
}