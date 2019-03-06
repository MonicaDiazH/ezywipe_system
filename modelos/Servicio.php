<?php
require "../config/Conexion.php";

Class Servicio{
  //Implementamos constructor
  public function __construct(){
  }

  public function insertar($nombre,$precio){
    $sql = "INSERT INTO tb_servicios (nombre,precio, estado)
    VALUES ('$nombre', '$precio', '1')";
    return ejecutarConsulta($sql);
  }

  public function editar($id,$nombre,$precio){
    $sql = "UPDATE tb_servicios SET nombre = '$nombre', precio = '$precio' WHERE id = $id";
    return ejecutarConsulta($sql);
  }

  public function eliminar($id){
    $sql = "UPDATE tb_servicios SET estado = 0 WHERE id = $id";
    return ejecutarConsulta($sql);
  }

  public function mostrar($id){
    $sql = "SELECT * FROM tb_servicios WHERE id = $id";
    return ejecutarConsultaSimpleFila($sql);
  }

  public function listar(){
    $sql = "SELECT * FROM tb_servicios WHERE estado = 1";
    return ejecutarConsulta($sql);
  }

}

?>
