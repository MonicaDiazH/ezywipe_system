<?php
require "../config/Conexion.php";

Class DetalleFAC{
    //Implementamos constructor
    public function __construct(){
    }

    public function insertar($cantidad, $descripcion, $ajena, $unitario, $no_sujeta, $exenta, $gravada, $costo,$id_fac, $id_servicio){
        $sql = "INSERT INTO tb_detalle_fac (cantidad, descripcion, ajena, unitario, no_sujeta, exenta, gravada, costo, id_fac, id_servicio)
                VALUES ('$cantidad', '$descripcion', '$ajena', '$unitario', '$no_sujeta', '$exenta', '$gravada', '$costo','$id_fac', '$id_servicio')";
        return ejecutarConsulta($sql);
    }

    public function editar($id,$cantidad, $descripcion, $ajena, $unitario, $no_sujeta, $exenta, $gravada,
                           $costo,$id_servicio){
        $sql = "UPDATE tb_detalle_fac SET 
                cantidad = '$cantidad', 
                descripcion = '$descripcion', 
                ajena = '$ajena', 
                unitario = '$unitario', 
                no_sujeta = '$no_sujeta', 
                exenta = '$exenta', 
                gravada = '$gravada', 
                costo = '$costo', 
                id_servicio = '$id_servicio'
                WHERE id = $id";
        return ejecutarConsulta($sql);
    }

    public function eliminar($id){
        $sql = "DELETE FROM tb_detalle_fac WHERE id = $id";
        return ejecutarConsulta($sql);
    }

    public function mostrar($id){
        $sql = "SELECT * FROM tb_detalle_fac WHERE id = $id";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listar($id){
        $sql = "SELECT a.*, b.nombre FROM tb_detalle_fac as a 
                INNER JOIN tb_servicios as b ON a.id_servicio = b.id
                WHERE a.id_fac = $id ORDER BY id ASC";
        return ejecutarConsulta($sql);
    }

}

?>
