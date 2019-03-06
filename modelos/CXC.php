<?php
require "../config/Conexion.php";

Class CXC
{
    //Implementamos constructor
    public function __construct()
    {
    }

    public function mostrarPendiente()
    {
        $sql = "SELECT SUM(IFNULL(total_general - (SELECT SUM(abono) FROM tb_pago_cliente as d WHERE d.id_ccf = a.id), total_general)) as saldo_pendiente
                FROM tb_ccf as a 
                WHERE a.estado = 2";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function mostrarPendienteNoVencido()
    {
        $sql = "SELECT SUM(IFNULL(total_general - (SELECT SUM(abono) FROM tb_pago_cliente as d WHERE d.id_ccf = a.id), total_general)) as saldo_pendiente
                FROM tb_ccf as a 
                WHERE a.estado = 2 AND DATEDIFF(Date_format(now(),'%Y/%m/%d'),a.fecha)<30 ";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function mostrarPendienteVencido()
    {
        $sql = "SELECT SUM(IFNULL(total_general - (SELECT SUM(abono) FROM tb_pago_cliente as d WHERE d.id_ccf = a.id), total_general)) as saldo_pendiente
                FROM tb_ccf as a 
                WHERE a.estado = 2 AND DATEDIFF(Date_format(now(),'%Y/%m/%d'),a.fecha)>30 ";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function clientePendiente()
    {
        $sql = "SELECT a.* FROM tb_cliente as a WHERE EXISTS (SELECT * FROM tb_ccf as b WHERE a.id = b.id_cliente AND b.estado = 2)";
        return ejecutarConsulta($sql);
    }

    public function clientePendienteNoVencido()
    {
        $sql = "SELECT a.* FROM tb_cliente as a WHERE EXISTS (SELECT * FROM tb_ccf as b WHERE a.id = b.id_cliente AND b.estado = 2 AND DATEDIFF(Date_format(now(),'%Y/%m/%d'),b.fecha)<30);";
        return ejecutarConsulta($sql);
    }

    public function clientePendienteVencido()
    {
        $sql = "SELECT a.* FROM tb_cliente as a WHERE EXISTS (SELECT * FROM tb_ccf as b WHERE a.id = b.id_cliente AND b.estado = 2 AND DATEDIFF(Date_format(now(),'%Y/%m/%d'),b.fecha)>30);";
        return ejecutarConsulta($sql);
    }

    public function totalPendiente($id)
    {
        $sql = "SELECT SUM(IFNULL(total_general - (SELECT SUM(abono) FROM tb_pago_cliente as d WHERE d.id_ccf = a.id), total_general)) as saldo_pendiente
                FROM tb_ccf as a 
                WHERE a.estado = 2 AND a.id_cliente = $id";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function totalNoVencido($id)
    {
        $sql = "SELECT SUM(IFNULL(total_general - (SELECT SUM(abono) FROM tb_pago_cliente as d WHERE d.id_ccf = a.id), total_general)) as saldo_pendiente
                FROM tb_ccf as a 
                WHERE a.estado = 2 AND DATEDIFF(Date_format(now(),'%Y/%m/%d'),a.fecha)<30 AND a.id_cliente = $id";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function totalVencido($id)
    {
        $sql = "SELECT SUM(IFNULL(total_general - (SELECT SUM(abono) FROM tb_pago_cliente as d WHERE d.id_ccf = a.id), total_general)) as saldo_pendiente
                FROM tb_ccf as a 
                WHERE a.estado = 2 AND DATEDIFF(Date_format(now(),'%Y/%m/%d'),a.fecha)>30 AND a.id_cliente = $id";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function totalPendienteCCF($id)
    {
        $sql = "SELECT a.*, c.cliente, IFNULL(total_general - (SELECT SUM(abono) FROM tb_pago_cliente as d WHERE d.id_ccf = a.id), total_general) as saldo_pendiente, (SELECT SUM(abono) FROM tb_pago_cliente as d WHERE d.id_ccf = a.id) as abonos
                FROM tb_ccf as a INNER JOIN tb_cliente as c ON a.id_cliente = c.id
                WHERE a.estado = 2 AND a.id_cliente = $id";
        return ejecutarConsulta($sql);
    }

    public function totalPendienteNoVencidoCCF($id)
    {
        $sql = "SELECT a.*, c.cliente, IFNULL(total_general - (SELECT SUM(abono) FROM tb_pago_cliente as d WHERE d.id_ccf = a.id), total_general) as saldo_pendiente, (SELECT SUM(abono) FROM tb_pago_cliente as d WHERE d.id_ccf = a.id) as abonos
                FROM tb_ccf as a INNER JOIN tb_cliente as c ON a.id_cliente = c.id
                WHERE a.estado = 2 AND DATEDIFF(Date_format(now(),'%Y/%m/%d'),a.fecha)<30 AND a.id_cliente = $id";
        return ejecutarConsulta($sql);
    }

    public function totalPendienteVencidoCCF($id)
    {
        $sql = "SELECT a.*, c.cliente, IFNULL(total_general - (SELECT SUM(abono) FROM tb_pago_cliente as d WHERE d.id_ccf = a.id), total_general) as saldo_pendiente, (SELECT SUM(abono) FROM tb_pago_cliente as d WHERE d.id_ccf = a.id) as abonos
                FROM tb_ccf as a INNER JOIN tb_cliente as c ON a.id_cliente = c.id
                WHERE a.estado = 2 AND DATEDIFF(Date_format(now(),'%Y/%m/%d'),a.fecha)>30 AND a.id_cliente = $id";
        return ejecutarConsulta($sql);
    }

    public function consultaCliente($id)
    {
        $sql = "SELECT * FROM tb_cliente WHERE id = $id";
        return ejecutarConsultaSimpleFila($sql);
    }

}

?>
