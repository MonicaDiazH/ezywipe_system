<?php
require_once "../modelos/Servicio.php";

$servicio = new Servicio();

$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$precio = isset($_POST["precio"]) ? limpiarCadena($_POST["precio"]) : "";

switch ($_GET['op']) {
    case 'guardaryeditar':
        if (empty($id)) {
            $rspta = $servicio->insertar($nombre, $precio);
            //echo $rspta ? "Dato ingresado correctamente" : "Dato no se pudo ingresar correctamente";
            echo $rspta;
        } else {
            $rspta = $servicio->editar($id, $nombre, $precio);
            //echo $rspta ? "Dato modificado correctamente" : "Dato no se pudo modificar correctamente";
            echo $rspta;
        }
        break;

    case 'eliminar':
        $rspta = $servicio->eliminar($id);
        //echo $rspta ? "Dato eliminado correctamente" : "Dato no se pudo eliminar correctamente";
        echo $rspta;
        break;

    case 'mostrar':
        $rspta = $servicio->mostrar($id);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $servicio->listar();
        $data = Array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->nombre,
                "1" => $reg->precio,
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
}
?>
