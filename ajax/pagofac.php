<?php
session_start();
require_once "../modelos/PagoFAC.php";

$pagofac = new PagoFAC();

$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$fecha = isset($_POST["fecha"]) ? limpiarCadena($_POST["fecha"]) : "";
$fecha_abono = date('Y-m-d', strtotime(str_replace('-', '/', $fecha)));
$comentario = isset($_POST["comentario"]) ? limpiarCadena($_POST["comentario"]) : "";
$saldo = isset($_POST["total_factura"]) ? limpiarCadena($_POST["total_factura"]) : "";
$abono = isset($_POST["abono"]) ? limpiarCadena($_POST["abono"]) : "";
$saldo_pendiente = isset($_POST["saldo_pendiente"]) ? limpiarCadena($_POST["saldo_pendiente"]) : "";
$nuevo_saldo = $saldo_pendiente - $abono;
$id_forma_pago = isset($_POST["id_forma_pago"]) ? limpiarCadena($_POST["id_forma_pago"]) : "";
$id_bank = isset($_POST["id_banco"]) ? limpiarCadena($_POST["id_banco"]) : "";
$id_fac = isset($_POST["id_fac"]) ? limpiarCadena($_POST["id_fac"]) : "";
$id_user = $_SESSION['id_usuario'];

$id_banco ='' ;
if($id_bank != ''){$id_banco=$id_bank;}else{$id_banco='null';} 

switch ($_GET['op'])
{
    case 'guardaryeditar':
        if (empty($id)) {
            $rspta = $pagofac->insertar($fecha_abono,$comentario,$saldo,$abono,$nuevo_saldo,$id_forma_pago,$id_banco,$id_fac,$id_user);
            echo $rspta;
        } else {
            $rspta = $pagofac->editar($id,$fecha_abono,$comentario,$saldo,$abono,$nuevo_saldo,$id_forma_pago,$id_banco,$id_fac,$id_user);
            echo $rspta;
        }
        break;

    case 'listar':
        $rspta = $pagofac->listar();
        $data = Array();
        while ($reg = $rspta->fetch_object()) {
            //CODIGO
            $codigo = $reg->id;
            $codigo = str_pad($codigo, 5, "0", STR_PAD_LEFT);

            //ESTADO
            $estado = $reg->estado;

            if($estado == 2){
                $estado_print = "<span class='label label-warning'>Pendiente</span>";
            }
            
            $data[] = array(
                "0" => 'CO-'.$codigo,
                "1" => $reg->referencia,
                "2" => $reg->fecha,
                "3" => $reg->cliente,
                "4" => $reg->correlativo,
                "5" => $reg->condicion,
                "6" => '$ '.$reg->total_general,
                "7" => '$ '.$reg->saldo_pendiente,
                "8" => $estado_print,
                "9" => '<a onclick="mostrar('.$reg->id.')" data-toggle="tooltip" title="Abonar"><i class="fa fa-credit-card" ></i></a>&nbsp;&nbsp;&nbsp;
                        '
            );//onclick="imprimirFAC('.$reg->id.')"
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data);
        echo json_encode($results);
        break;

    //Muestra el detalle de FAC a abonar
    case 'mostrar':
        $rspta = $pagofac->mostrar($id);
            $codigo = 'CO-'.str_pad($rspta['id'], 5, "0", STR_PAD_LEFT);
            $data = Array(
                "codigo" => $codigo,
                "id" => $rspta['id'],
                "cliente"=> $rspta['cliente'],
                "total_general"=> $rspta['total_general'],
                "saldo_pendiente"=>$rspta['saldo_pendiente']
            );        
        echo json_encode($data);
        break;
    
    case 'mostrarPago':
        $id=$_POST['id'];
        $rspta = $pagofac->mostrarPago($id);      
        $data = Array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->fecha_abono,
                "1" => $reg->comentario,
                "2" => $reg->saldo,
                "3" => $reg->abono,
                "4" => $reg->nuevo_saldo,
                "5" => $reg->forma_pago,
                "6" => $reg->banco
            );
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data);
        echo json_encode($results);
        break; 
    
    case 'selectFormaPago':
        require_once "../modelos/TipoPago.php";
        $formapago = new TipoPago();

        $rspta = $formapago->listar();

        while ($reg = $rspta->fetch_object())
        {
            echo '<option value=' . $reg->id . '>' . $reg->forma_pago . '</option>';
        }
        break;
    
    case 'selectBanco':

        require_once "../modelos/Banco.php";
        $banco = new Banco();

        $rspta = $banco->listar();

        while ($reg = $rspta->fetch_object())
        {
            echo '<option value=' . $reg->id . '>' . $reg->banco . '</option>';
        }
        break;    
      
    case 'actualizarEstado':
        $id=$_POST['id'];
        $rspta = $pagofac->actualizarEstado($id); 
        echo $rspta;
        break;

    case 'mostrarTotalPendiente':
        $rspta = $pagofac->mostrarTotalPendiente();
        /*$data = Array(
            "total" => $rspta
        );*/
        echo json_encode($rspta);
        break;

    }

?>