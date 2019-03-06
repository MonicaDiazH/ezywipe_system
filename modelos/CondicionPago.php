<?php
require "../config/Conexion.php";

Class CondicionPago{
    //Implementamos constructor
    public function __construct(){
    }

    public function insertar($condicion){
        $sql = "INSERT INTO tb_condicion_pago (condicion,estado)
    VALUES ('$condicion', '1')";
        return ejecutarConsulta($sql);
    }

    public function editar($id,$condicion){
        $sql = "UPDATE tb_condicion_pago SET condicion = '$condicion' WHERE id = $id";
        return ejecutarConsulta($sql);
    }

    public function eliminar($id){
        $sql = "UPDATE tb_condicion_pago SET estado = 0 WHERE id = $id";
        return ejecutarConsulta($sql);
    }

    public function mostrar($id){
        $sql = "SELECT * FROM tb_condicion_pago WHERE id = $id";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listar(){
        $sql = "SELECT * FROM tb_condicion_pago WHERE estado = 1";
        return ejecutarConsulta($sql);
    }

}

?>
