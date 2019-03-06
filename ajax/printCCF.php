<?php
require_once '../vendor/autoload.php';
require_once "../modelos/CCF.php";

$ccf = new CCF();
$id = isset($_GET["id"]) ? limpiarCadena($_GET["id"]) : "";
$value = $ccf->mostrar($id);
//DATOS GENERALES
$cliente = $value['cliente'];
$direccion = $value['direccion'];
$fecha = $value['fecha'];
$nit = $value['nit'];
$registro = $value['registro'];
$giro = $value['giro'];
$letras = $value['total_letras'];
$ajena = $value['total_ajena'];
$sujeta = $value['total_no_sujeta'];
$exentas = $value['total_exentas'];
$gravadas = $value['total_gravadas'];
$iva = $value['iva'];
$ventatotal = $value['venta_total'];
$subtotal = $value['sub_total'];
$totalgeneral = $value['total_general'];
$municipio = $value['ciudad'];
$departamento = $value['nombre_estado'];
$condicion = $value['condicion'];

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => [300, 300],
    'orientation' => 'L',
    'default_font_size' => 11,
    'default_font' => 'verdana'
]);

$newY = 0;

$cliente_rep = substr($cliente, 0, 50);
$cliente_rep = strtoupper($cliente_rep);
$direccion_rep = substr($direccion, 0, 46);
$direccion_rep = strtoupper($direccion_rep);
$giro_rep = substr($giro, 0, 46);
$giro_rep = strtoupper($giro_rep);
$municipio = strtoupper($municipio);
$departamento = strtoupper($departamento);
$condicion = strtoupper($condicion);
$mpdf->WriteFixedPosHTML('' . $cliente_rep . '', 18, 22-$newY, 200, 30, 'hidden');
$mpdf->WriteFixedPosHTML('' . $fecha . '', 162, 22-$newY, 200, 30, 'auto');
$mpdf->WriteFixedPosHTML('' . $direccion_rep . '', 26, 27-$newY, 150, 30, 'auto');
$mpdf->WriteFixedPosHTML('' . $nit . '', 162, 27-$newY, 200, 30, 'auto');
$mpdf->WriteFixedPosHTML('' . $municipio . '', 26, 32-$newY, 200, 30, 'auto');
$mpdf->WriteFixedPosHTML('' . $departamento . '', 103, 32-$newY, 200, 30, 'auto');
$mpdf->WriteFixedPosHTML('' . $registro . '', 165, 32-$newY, 200, 30, 'auto');
$mpdf->WriteFixedPosHTML('' . $giro_rep . '', 162, 37-$newY, 200, 30, 'auto');
$mpdf->WriteFixedPosHTML('' . $condicion . '', 44, 37-$newY, 200, 30, 'auto'); //CONDICION

$X1 = 12;
$X2 = 22;
$X3 = 70;
$X4 = 168;
$Y = 53-$newY;
$Y2 = 40-$newY;
/*INICIO DETALLES*/
$detalle = $ccf->listadoDetalle($id);
while ($row = $detalle->fetch_array())
{
    if ($row['cantidad'] > 0) {
        $mpdf->WriteFixedPosHTML($row['cantidad'], $X1, $Y, 200, 30, 'auto');
    }
    $nombre = strtoupper($row['nombre']);
    $descripcion = strtoupper($row['descripcion']);
    $mpdf->WriteFixedPosHTML($nombre.' '.$descripcion, $X2, $Y, 200, 30, 'auto');
    //AJENA
    if ($row['ajena'] != 0.00) {
        $mpdf->SetXY(($X3 - 16 + 14), $Y2);
        $mpdf->Cell(60, 30, '$', '', '', 'R');
        $mpdf->SetXY($X3 + 14, $Y2);
        $mpdf->Cell(60, 30, number_format($row['ajena'], 2), '', '', 'R');
    }

    //NO SUJETA
    if ($row['no_sujeta'] != 0.00) {
        $mpdf->SetXY(114, $Y2);
        $mpdf->Cell(60, 30, '$', '', '', 'R');
        $mpdf->SetXY(126, $Y2);
        $mpdf->Cell(60, 30, number_format($row['no_sujeta'], 2), '', '', 'R');
    }

    //EXENTA
    if ($row['exenta'] != 0.00) {
        $mpdf->SetXY(118, $Y2);
        $mpdf->Cell(60, 30, '$', '', '', 'R');
        $mpdf->SetXY(130, $Y2);
        $mpdf->Cell(60, 30, number_format($row['exenta'], 2), '', '', 'R');
    }

    //UNITARIO
    if ($row['unitario'] > 0 && $row['exenta']==0) {
        if ($row['unitario'] != 0.00) {
            $mpdf->SetXY(95, $Y2);
            $mpdf->Cell(60, 30, '$', '', '', 'R');
            $mpdf->SetXY(110, $Y2);
            $mpdf->Cell(60, 30, number_format($row['unitario'], 2), '', '', 'R');
        }
    }

    //GRAVADAS
    if ($row['gravada'] != 0.00) {
        $mpdf->SetXY(135, $Y2);
        $mpdf->Cell(60, 30, '$', '', '', 'R');
        $mpdf->SetXY(153, $Y2);
        $mpdf->Cell(60, 30, number_format($row['gravada'], 2), '', '', 'R');
    }

    $Y = $Y + 6;
    $Y2 = $Y2 + 6;
}
/*FIN DETALLES*/
$letras = strtoupper($letras);
$mpdf->WriteFixedPosHTML('' . $letras . '', 22, 196-$newY, 75, 30, 'auto');
//$mpdf->WriteFixedPosHTML(''.$ajena.'', 128, 166, 200, 30, 'auto');
//$ SUMA AJENA
if ($ajena != 0.00) {
    $mpdf->SetXY(($X3 - 16 + 14), 173 + 6.5-$newY);
    $mpdf->Cell(60, 30, '$', '', '', 'R');
    $mpdf->SetXY($X3 + 14, 173 + 6.5-$newY);
    $mpdf->Cell(60, 30, number_format($ajena, 2), '', '', 'R');
}

//GRAVADAS
if ($gravadas != 0.00) {
    $mpdf->SetXY(135, 173 + 6.5-$newY);
    $mpdf->Cell(60, 30, '$', '', '', 'R');
    $mpdf->SetXY(153, 173 + 6.5-$newY);
    $mpdf->Cell(60, 30, number_format($gravadas, 2), '', '', 'R');
}

//IVA
if ($iva != 0.00) {
    $mpdf->SetXY(135, 177 + 6.5-$newY);
    $mpdf->Cell(60, 30, '$', '', '', 'R');
    $mpdf->SetXY(153, 177 + 6.5-$newY);
    $mpdf->Cell(60, 30, number_format($iva, 2), '', '', 'R');
}

//NO SUJETAS
if ($sujeta != 0.00) {
    $mpdf->SetXY(135, 182 + 6.5-$newY);
    $mpdf->Cell(60, 30, '$', '', '', 'R');
    $mpdf->SetXY(153, 182 + 6.5-$newY);
    $mpdf->Cell(60, 30, number_format($sujeta, 2), '', '', 'R');
}

//EXENTAS
if ($exentas != 0.00) {
    $mpdf->SetXY(135, 186 + 6.5-$newY);
    $mpdf->Cell(60, 30, '$', '', '', 'R');
    $mpdf->SetXY(153, 186 + 6.5-$newY);
    $mpdf->Cell(60, 30, number_format($exentas, 2), '', '', 'R');
}

//RETENIDO
if ($retenido != 0.00) {
    $mpdf->SetXY(135, 191 + 6.5-$newY);
    $mpdf->Cell(60, 30, '$', '', '', 'R');
    $mpdf->SetXY(153, 191 + 6.5-$newY);
    $mpdf->Cell(60, 30, number_format($retenido, 2), '', '', 'R');
}

//VENTA TOTAL
if ($ventatotal != 0.00) {
    $mpdf->SetXY(135, 197 + 6.5-$newY);
    $mpdf->Cell(60, 30, '$', '', '', 'R');
    $mpdf->SetXY(153, 197 + 6.5-$newY);
    $mpdf->Cell(60, 30, number_format($ventatotal, 2), '', '', 'R');
}

//AJENA
if ($ajena != 0.00) {
    $mpdf->SetXY(135, 202 + 6.5-$newY);
    $mpdf->Cell(60, 30, '$', '', '', 'R');
    $mpdf->SetXY(153, 202 + 6.5-$newY);
    $mpdf->Cell(60, 30, number_format($ajena, 2), '', '', 'R');
}

//SUB TOTAL
if ($subtotal != 0.00) {
    $mpdf->SetXY(135, 212 + 6.5-$newY);
    $mpdf->Cell(60, 30, '$', '', '', 'R');
    $mpdf->SetXY(153, 212 + 6.5-$newY);
    $mpdf->Cell(60, 30, number_format($subtotal, 2), '', '', 'R');
}

//TOTAL GENERAL
if ($totalgeneral != 0.00) {
    $mpdf->SetXY(135, 218 + 6-$newY);
    $mpdf->Cell(60, 30, '$', '', '', 'R');
    $mpdf->SetXY(153, 218 + 6-$newY);
    $mpdf->Cell(60, 30, number_format($totalgeneral, 2), '', '', 'R');
}

$mpdf->Output();
?>
