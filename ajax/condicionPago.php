<?php
require_once "../modelos/CondicionPago.php";

$condicionPago = new CondicionPago();

$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$condicion_pago = isset($_POST["condicion_pago"]) ? limpiarCadena($_POST["condicion_pago"]) : "";

switch ($_GET['op']) {
    case 'guardaryeditar':
        if (empty($id)) {
            $rspta = $condicionPago->insertar($condicion_pago);
            echo $rspta;
        } else {
            $rspta = $condicionPago->editar($id, $condicion_pago);
            echo $rspta;
        }
        break;

    case 'eliminar':
        $rspta = $condicionPago->eliminar($id);
        echo $rspta;
        break;

    case 'mostrar':
        $rspta = $condicionPago->mostrar($id);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $condicionPago->listar();
        $data = Array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->condicion,
                "1" => '<a onclick="mostrar('.$reg->id.')" data-toggle="tooltip" title="Editar"><i class="fa fa-edit" ></i></a>&nbsp;&nbsp;&nbsp;
                        <a onclick="eliminar('.$reg->id.')" data-toggle="tooltip" title="Eliminar"><i class="fa fa-times"></i></a>'
            );
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data);
        echo json_encode($results);
        break;
}
?>
