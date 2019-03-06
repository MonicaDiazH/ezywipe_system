<?php
require_once "../modelos/Estado.php";

$estado = new Estado();

$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$nombre_estado = isset($_POST["nombre_estado"]) ? limpiarCadena($_POST["nombre_estado"]) : "";
$id_pais = isset($_POST["id_pais"]) ? limpiarCadena($_POST["id_pais"]) : "";

switch ($_GET['op']) {
    case 'guardaryeditar':
        if (empty($id)) {
            $rspta = $estado->insertar($nombre_estado,$id_pais);
            echo $rspta;
        } else {
            $rspta = $estado->editar($id, $nombre_estado,$id_pais);
            echo $rspta;
        }
        break;

    case 'eliminar':
        $rspta = $estado->eliminar($id);
        echo $rspta;
        break;

    case 'mostrar':
        $rspta = $estado->mostrar($id);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $estado->listar();
        $data = Array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->nombre_estado,
                "1" => $reg->pais,
                "2" => '<a onclick="mostrar('.$reg->id.')" data-toggle="tooltip" title="Editar"><i class="fa fa-edit" ></i></a>&nbsp;&nbsp;&nbsp;
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

    case "selectPais":
        require_once "../modelos/Pais.php";
        $pais = new Pais();

        $rspta = $pais->listar();

        while ($reg = $rspta->fetch_object())
        {
            echo '<option value=' . $reg->id . '>' . $reg->pais . '</option>';
        }
        break;
}
?>
