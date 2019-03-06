<?php
session_start();
require_once "../modelos/Cliente.php";

$cliente = new Cliente();

$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$nombre_cliente = isset($_POST["cliente"]) ? limpiarCadena($_POST["cliente"]) : "";
$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$nit = isset($_POST["nit"]) ? limpiarCadena($_POST["nit"]) : "";
$registro = isset($_POST["registro"]) ? limpiarCadena($_POST["registro"]) : "";
$giro = isset($_POST["giro"]) ? limpiarCadena($_POST["giro"]) : "";
$fecha_ingreso1 = isset($_POST["fecha_ingreso"]) ? limpiarCadena($_POST["fecha_ingreso"]) : "";
$fecha_ingreso = date('Y-m-d', strtotime(str_replace('-', '/', $fecha_ingreso1)));
$contacto1 = isset($_POST["contacto1"]) ? limpiarCadena($_POST["contacto1"]) : "";
$telefono1 = isset($_POST["telefono1"]) ? limpiarCadena($_POST["telefono1"]) : "";
$mail1 = isset($_POST["mail1"]) ? limpiarCadena($_POST["mail1"]) : "";
$id_condicion_pago = isset($_POST["id_condicion_pago"]) ? limpiarCadena($_POST["id_condicion_pago"]) : "";
$id_ciudad = isset($_POST["id_ciudad"]) ? limpiarCadena($_POST["id_ciudad"]) : "";
$id_tipo_cliente = isset($_POST["id_tipo_cliente"]) ? limpiarCadena($_POST["id_tipo_cliente"]) : "";
$id_user = $_SESSION['id_usuario'];

switch ($_GET['op']) {
    case 'guardaryeditar':

        if (empty($id)) {
            $rspta = $cliente->insertar($nombre_cliente,$direccion,$nit,$registro,$giro,$fecha_ingreso,$contacto1,$telefono1,$mail1,$id_ciudad,$id_condicion_pago,$id_tipo_cliente,$id_user);
            echo $rspta;
        } else {
            $rspta = $cliente->editar($id,$nombre_cliente,$direccion,$nit,$registro,$giro,$fecha_ingreso,$contacto1,$telefono1,$mail1,$id_ciudad,$id_condicion_pago,$id_tipo_cliente,$id_user);
            echo $rspta;
        }
        break;

    case 'eliminar':
        $rspta = $cliente->eliminar($id);
        echo $rspta;
        break;

    case 'mostrar':
        $rspta = $cliente->mostrar($id);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $cliente->listar();
        $data = Array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->cliente,
                "1" => $reg->registro,
                "2" => $reg->nit,
                "3" => $reg->condicion,
                "4" => $reg->contacto,
                "5" => $reg->telefono,
                "6" => '<a onclick="mostrar('.$reg->id.')" data-toggle="tooltip" title="Editar"><i class="fa fa-edit" ></i></a>&nbsp;&nbsp;&nbsp;
                <a onclick="mostrarDetalle('.$reg->id.')" data-toggle="tooltip" title="Detalle"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;&nbsp;
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

    case "selectEstado":
        $id = $_POST['pais']; 
        require_once "../modelos/Estado.php";
        $estado = new Estado();

        $rspta = $estado->selectEstado($id);

        while ($reg = $rspta->fetch_object())
        {
            echo '<option value=' . $reg->id . '>' . $reg->nombre_estado . '</option>'; 
        }
        break;

    case "selectCiudad":
        $id = $_POST['estado']; 
        require_once "../modelos/Ciudad.php";
        $ciudad = new Ciudad();

        $rspta = $ciudad->selectCiudad($id);

        while ($reg = $rspta->fetch_object())
        {
            echo '<option value=' . $reg->id . '>' . $reg->ciudad . '</option>'; 
        }
        break;
        
    case "selectCondicionPago":
        require_once "../modelos/CondicionPago.php";
        $condicionPago = new CondicionPago();

        $rspta = $condicionPago->listar();

        while ($reg = $rspta->fetch_object())
        {
            echo '<option value=' . $reg->id . '>' . $reg->condicion . '</option>';
        }
        break;

    case "selectTipoCliente":
        $id = $_POST['tipo_cliente'];
        require_once "../modelos/TipoCliente.php";
        $tipo_cliente = new TipoCliente();

        $rspta = $tipo_cliente->listar($id);

        while ($reg = $rspta->fetch_object())
        {
            echo '<option value=' . $reg->id . '>' . $reg->tipo . '</option>';
        }
        break;

}
?>
