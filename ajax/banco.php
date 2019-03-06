<?php
require_once "../modelos/Banco.php";

$banco = new Banco();

$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$nombre_banco = isset($_POST["banco"]) ? limpiarCadena($_POST["banco"]) : "";

switch ($_GET['op']) {
    case 'guardaryeditar':
        if (empty($id)) {
            $rspta = $banco->insertar($nombre_banco);
            echo $rspta;
        } else {
            $rspta = $banco->editar($id, $nombre_banco);
            echo $rspta;
        }
        break;

    case 'eliminar':
        $rspta = $banco->eliminar($id);
        echo $rspta;
        break;

    case 'mostrar':
        $rspta = $banco->mostrar($id);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $banco->listar();
        $data = Array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->banco,
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
