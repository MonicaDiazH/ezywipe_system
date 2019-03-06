<?php
require_once "../modelos/Usuario.php";
$usuario = new Usuario();
$rspta = $usuario->menu();
while( $row = mysqli_fetch_assoc($rspta) ) {
    $data[] = $row;
    }
    $itemsByReference = array();
    // Build array of item references:
    foreach($data as $key => &$item) {
    $itemsByReference[$item['id']] = &$item;
    }
    // Set items as children of the relevant parent item.
    foreach($data as $key => &$item) {
    if($item['id_padre'] && isset($itemsByReference[$item['id_padre']])) {
    $itemsByReference [$item['id_padre']]['nodes'][] = &$item;
    }
    }
    // Remove items that were added to parents elsewhere:
    foreach($data as $key => &$item) {
    if($item['id_padre'] && isset($itemsByReference[$item['id_padre']]))
    unset($data[$key]);
    }
    // Encode:
    echo json_encode($data);

?>
