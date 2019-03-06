<?php
require "../config/Conexion.php";

Class PagoFAC{
    //Implementamos constructor
    public function __construct(){
    }

    public function insertar($fecha_abono,$comentario,$saldo,$abono,$nuevo_saldo,$id_forma_pago,$id_banco,$id_fac,$id_user){
        $sql = "INSERT INTO tb_pago_cliente(fecha_abono,comentario,saldo,abono,nuevo_saldo,estado,id_forma_pago,id_banco,id_fac,id_user) 
                VALUES ('$fecha_abono','$comentario',$saldo,$abono,$nuevo_saldo,1,$id_forma_pago,$id_banco,$id_fac,$id_user)";
       
        return ejecutarConsulta($sql);
    }

    public function listar(){
        $sql = "SELECT a.*, b.condicion, c.cliente, 
                IFNULL(total_general - (SELECT SUM(abono) FROM tb_pago_cliente as d WHERE d.id_fac = a.id), total_general) as saldo_pendiente
                FROM tb_fac as a 
                INNER JOIN tb_condicion_pago as b ON a.id_condicion_pago = b.id
                INNER JOIN tb_cliente as c ON a.id_cliente = c.id 
                WHERE a.estado = 2";
        return ejecutarConsulta($sql);

        //Modificar el estado a 2, por el momento se ha usado 1 porque no hay datos con estado 2 en la base
    }

    public function mostrar($id){
        $sql = "SELECT a.*, b.condicion, c.cliente, IFNULL((total_general - SUM(abono)), total_general) as saldo_pendiente
                    FROM tb_fac as a 
                    INNER JOIN tb_condicion_pago as b ON a.id_condicion_pago = b.id
                    INNER JOIN tb_cliente as c ON a.id_cliente = c.id 
                    INNER JOIN tb_pago_cliente as d ON a.id = d.id_fac
                    WHERE a.id = $id";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function actualizarEstado($id)
    {
        $sql ="UPDATE tb_fac SET estado=3 WHERE id=$id";
        return ejecutarConsulta($sql);
    }

    public function mostrarPago($id){
        $sql = "SELECT a.*, b.id as id_forma_pago, forma_pago, c.id as id_banco, banco 
                FROM tb_pago_cliente as a
                LEFT JOIN tb_forma_pago as b ON b.id = a.id_forma_pago
                LEFT JOIN tb_banco as c ON  a.id_banco  = c.id
                WHERE a.id_fac = $id
                ORDER BY fecha_abono DESC";
        return ejecutarConsulta($sql);
    }

    public function mostrarTotalPendiente(){
        $sql = "SELECT SUM(IFNULL(total_general - (SELECT SUM(abono) FROM tb_pago_cliente as d WHERE d.id_fac = a.id), total_general)) as saldo_pendiente
                FROM tb_fac as a 
                WHERE a.estado = 2";
        return ejecutarConsultaSimpleFila($sql);
    }
}

?>
