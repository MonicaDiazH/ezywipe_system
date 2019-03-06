<?php
require "../config/Conexion.php";

Class CCF{
    //Implementamos constructor
    public function __construct(){
    }

    public function nuevo(){
        $sql = "INSERT INTO tb_ccf (estado) VALUES ('0')";
        return ejecutarConsulta_retornarID($sql);
    }

    /*public function insertar($fecha, $referencia, $total_letras, $total_ajena, $total_no_sujeta,
                $total_exentas, $total_gravadas, $iva, $venta_total, $sub_total, $total_general,
                $correlativo,$id_condicion_pago, $id_cliente, $id_user){
        $sql = "INSERT INTO tb_ccf (fecha, referencia, total_letras, total_ajena, total_no_sujeta,
                total_exentas, total_gravadas, iva, venta_total, sub_total, total_general,
                correlativo,id_condicion_pago, id_cliente, id_user, estado)
    VALUES ('$fecha', '$referencia', '$total_letras', '$total_ajena', '$total_no_sujeta',
                '$total_exentas', '$total_gravadas', '$iva', '$venta_total', '$sub_total', '$total_general',
                '$correlativo','$id_condicion_pago', '$id_cliente', '$id_user', '1')";
        return ejecutarConsulta($sql);
    }*/

    public function editar($id,$fecha, $referencia, $total_letras, $total_ajena, $total_no_sujeta,
                           $total_exentas, $total_gravadas, $iva, $venta_total, $sub_total, $total_general,
                           $costo_total,$correlativo,$id_condicion_pago, $id_cliente, $id_user){
        $sql = "UPDATE tb_ccf SET 
                fecha = '$fecha', 
                referencia = '$referencia', 
                total_letras = '$total_letras', 
                total_ajena = '$total_ajena', 
                total_no_sujeta = '$total_no_sujeta', 
                total_exentas = '$total_exentas', 
                total_gravadas = '$total_gravadas', 
                iva = '$iva', 
                venta_total = '$venta_total', 
                sub_total = '$sub_total', 
                total_general = '$total_general',
                costo_total = '$costo_total',
                correlativo = '$correlativo',
                id_condicion_pago = '$id_condicion_pago', 
                id_cliente = '$id_cliente', 
                id_user = '$id_user',
                estado = 1
                WHERE id = '$id'";
        return ejecutarConsulta($sql);
    }

    public function eliminar($id){
        $sql = "UPDATE tb_ccf SET estado = 0 WHERE id = $id";
        return ejecutarConsulta($sql);
    }

    public function mostrar($id){
        $sql = "SELECT a.*, b.cliente, b.direccion, b.registro, b.nit, b.giro, d.ciudad,e.nombre_estado, c.condicion FROM tb_ccf as a 
                INNER JOIN tb_cliente as b ON a.id_cliente = b.id 
                INNER JOIN tb_condicion_pago as c ON a.id_condicion_pago = c.id
                INNER JOIN tb_ciudad as d ON b.id_ciudad = d.id
                INNER JOIN tb_estado as e ON d.id_estado = e.id
                WHERE a.id = $id";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listar(){
        $sql = "SELECT a.*, b.condicion, c.cliente FROM tb_ccf as a 
                INNER JOIN tb_condicion_pago as b ON a.id_condicion_pago = b.id
                INNER JOIN tb_cliente as c ON a.id_cliente = c.id 
                WHERE a.estado != 0";
        return ejecutarConsulta($sql);
    }

    public function totalesCCF($id){
        $sql = "SELECT SUM(costo) as costo, SUM(ajena) as ajena, SUM(no_sujeta) as no_sujeta, SUM(exenta) as exenta, SUM(gravada) as gravada FROM tb_detalle_ccf WHERE id_ccf = $id";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listadoDetalle($id){
        $sql = "SELECT a.*, b.nombre FROM tb_detalle_ccf as a 
                INNER JOIN tb_servicios as b ON a.id_servicio = b.id
                WHERE a.id_ccf = $id ORDER BY ID ASC";
        return ejecutarConsulta($sql);
    }

    public function anular($id, $comentario, $id_anulacion){
        $sql = "UPDATE tb_ccf SET estado = 4,comentario_anulacion = '$comentario',id_anulacion = '$id_anulacion' WHERE id = $id";
        return ejecutarConsulta($sql);
    }

    public function mostrarAnular($id){
        $sql = "SELECT a.*, b.tipo_anulacion FROM tb_ccf AS a INNER JOIN tb_tipo_anulacion as b ON a.id_anulacion = b.id WHERE a.id = $id";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function ccfImpreso($id){
        $sql = "UPDATE tb_ccf SET estado = 2 WHERE id = $id";
        return ejecutarConsulta($sql);
        //return $sql;
    }

    public function mostrarCCF($id){
        $sql = "SELECT * FROM tb_ccf WHERE id = $id";
        return ejecutarConsultaSimpleFila($sql);
    }
}

?>
