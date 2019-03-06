<?php
require_once "../modelos/TipoPago.php";

$formaPago = new TipoPago();

$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$tipo_pago = isset($_POST["tipo_pago"]) ? limpiarCadena($_POST["tipo_pago"]) : "";

switch ($_GET['op']) {
    case 'guardaryeditar':
        if (empty($id)) {
            $rspta = $formaPago->insertar($tipo_pago);
            echo $rspta;
        } else {
            $rspta = $formaPago->editar($id, $tipo_pago);
            echo $rspta;
        }
        break;

    case 'eliminar':
        $rspta = $formaPago->eliminar($id);
        echo $rspta;
        break;

    case 'mostrar':
        $rspta = $formaPago->mostrar($id);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $formaPago->listar();
        $data = Array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->tipo_pago,
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
