<?php
require "../config/Conexion.php";

Class Estado{
    //Implementamos constructor
    public function __construct(){
    }

    public function insertar($nombre_estado,$id_pais){
        $sql = "INSERT INTO tb_estado (nombre_estado,id_pais,estado)
    VALUES ('$nombre_estado','$id_pais', '1')";
        return ejecutarConsulta($sql);
    }

    public function editar($id,$nombre_estado,$id_pais){
        $sql = "UPDATE tb_estado SET nombre_estado = '$nombre_estado', id_pais = '$id_pais' WHERE id = $id";
        return ejecutarConsulta($sql);
    }

    public function eliminar($id){
        $sql = "UPDATE tb_estado SET estado = 0 WHERE id = $id";
        return ejecutarConsulta($sql);
    }

    public function mostrar($id){
        $sql = "SELECT a.id, a.nombre_estado, a.id_pais, a.estado, b.pais FROM tb_estado as a INNER JOIN tb_pais as b ON a.id_pais = b.id WHERE a.id = $id";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listar(){
        $sql = "SELECT a.id, a.nombre_estado, a.id_pais, a.estado, b.pais FROM tb_estado as a INNER JOIN tb_pais as b ON a.id_pais = b.id where a.estado = 1";
        return ejecutarConsulta($sql);
    }

    public function selectEstado($id){
        $sql = "SELECT a.id, a.nombre_estado, b.id as id_pais, a.estado, b.pais 
                FROM tb_estado as a 
                INNER JOIN tb_pais as b ON a.id_pais = b.id 
                WHERE a.id_pais=$id AND a.estado = 1";
        return ejecutarConsulta($sql);
    }

}

?>
