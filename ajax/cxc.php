<?php
session_start();
require_once "../modelos/CXC.php";

$cxc = new CXC();

$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";

switch ($_GET['op'])
{
    case 'listar':
        $rsptaClientePendiente = $cxc->clientePendiente();
        $data = Array();
        while ($reg = $rsptaClientePendiente->fetch_object()) {
            $id = $reg->id;
            $pendiente = $cxc->totalPendiente($id);
            $no_vencido = $cxc->totalNoVencido($id);
            $vencido = $cxc->totalVencido($id);

            if($pendiente['saldo_pendiente'] == null){
                $printPendiente = '$ 0.00';
            }
            else{
                $printPendiente = '$ '.$pendiente['saldo_pendiente'];
            }

            if($no_vencido['saldo_pendiente'] == null){
                $printNoVencido = '$ 0.00';
            }
            else{
                $printNoVencido = '$ '.$no_vencido['saldo_pendiente'];
            }

            if($vencido['saldo_pendiente'] == null){
                $printVencido = '$ 0.00';
            }
            else{
                $printVencido = '$ '.$vencido['saldo_pendiente'];
            }

            $data[] = array(
                "0" => $reg->cliente,
                "1" =>'<a href="../ajax/printReporteCxCCliente.php?id='.$id.'" target="_blank">'.$printPendiente.'</a>',
                "2" =>'<a href="../ajax/printReporteCxCClienteNoVencido.php?id='.$id.'" target="_blank">'.$printNoVencido.'</a>',
                "3" =>'<a href="../ajax/printReporteCxCClienteVencido.php?id='.$id.'" target="_blank">'.$printVencido.'</a>'
            );
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data);
        echo json_encode($results);
        break;

    case 'mostrarPendiente':
        $rspta = $cxc->mostrarPendiente();
        echo json_encode($rspta);
        break;

    case 'mostrarNoVencido':
        $rspta = $cxc->mostrarPendienteNoVencido();
        echo json_encode($rspta);
        break;

    case 'mostrarVencido':
        $rspta = $cxc->mostrarPendienteVencido();
        echo json_encode($rspta);
        break;

}

?>