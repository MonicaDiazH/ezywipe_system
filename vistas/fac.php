<?php
ob_start();
session_start();
if(!isset($_SESSION['nombre']))
{
    header("Location: login.php");
}
else
{
    require 'header.php';
    if($_SESSION['Consumidor Final']==1)
    {
        ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Consumidor Final
                    <!--<small>Optional description</small>-->
                </h1>
                <ol class="breadcrumb">
                    <a onClick="mostrarForm(true); nuevo()" class="btn btn-primary btn-sm" id="btnAgregar">NUEVO</a>
                    <!--<li class="active"><a href="#"><i class="fa fa-dashboard"></i> Usuarios</a></li>
                    <li class="active">Here</li>-->
                </ol>
            </section>

            <!-- Main content -->
            <section class="content container-fluid">

                <div class="box box-danger" id="listadoRegistros">
                    <div class="box-body">
                        <!--CONTENIDO -->
                        <table id="tbllistado" class="table table-bordered table-striped">
                            <thead>
                            <th>Código</th>
                            <th>Referencia</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Correlativo</th>
                            <th>Condición Pago</th>
                            <th>Monto Total</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <th>Código</th>
                            <th>Referencia</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Correlativo</th>
                            <th>Condición Pago</th>
                            <th>Monto Total</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box table -->
                <form name="formulario" id="formulario" method="POST">
                    <div class="box box-danger" id="formularioRegistros">
                        <div class="box-body">
                            <!--CONTENIDO -->
                            <input type="hidden" name="id" id="id">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>Código</label>
                                        <input type="text" class="form-control" name="codigo" id="codigo" readonly="true">
                                    </div>

                                    <div class="form-group">
                                        <label>Fecha</label>
                                        <input type="text" class="form-control" name="fecha" id="fecha" value="<?php echo date('m/d/Y')?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Cliente</label>
                                        <select class="form-control selectpicker selectColor" data-live-search="true" name="id_cliente" id="id_cliente" title="Seleccione Cliente" required></select>
                                    </div>

                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Referencia</label>
                                        <input type="text" class="form-control" name="referencia" id="referencia">
                                    </div>

                                    <div class="form-group">
                                        <label>Condición Pago</label>
                                        <select class="form-control selectpicker selectColor" data-live-search="true" name="id_condicion_pago" id="id_condicion_pago" title="Seleccione Condición de Pago" required></select>
                                    </div>

                                    <div class="form-group">
                                        <label>Correlativo</label>
                                        <input type="text" class="form-control" name="correlativo" id="correlativo" required>
                                    </div>

                                </div>
                                <!-- /.col -->
                                <div class="col-md-6" id="divAgregarDetalle">
                                    <a data-toggle="modal" href="#myModal" class="btn btn-xs btn-primary" name="agregarDetalle" id="agregarDetalle" onclick="cerrarModal()">Agregar Detalle</a>
                                    <br><br>
                                </div>

                                <div class="col-md-12">
                                    <!--TABLA DE DETALLE FAC-->
                                    <table id="tbllistado_detalle" class="table table-bordered table-striped">
                                        <thead>
                                        <th>Cantidad</th>
                                        <th>Servicio</th>
                                        <th>Descripción</th>
                                        <th>Unitario</th>
                                        <th>Ajena</th>
                                        <th>No sujeta</th>
                                        <th>Exenta</th>
                                        <th>Gravada</th>
                                        <th>Costo</th>
                                        <th>Opciones</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                    </table>
                                    <!--/TABLA DE DETALLE FAC-->
                                </div>
                                <!-- /.col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Ventas Gravadas ($)</label>
                                        <input type="text" class="form-control" name="gravadas" id="gravadas" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>Gastos Cuenta Ajena ($)</label>
                                        <input type="text" class="form-control" name="ajena" id="ajena" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>Total General ($)</label>
                                        <input type="text" class="form-control" name="total_general" id="total_general" readonly>
                                    </div>

                                </div>
                                <!-- /.col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Ventas Exentas ($)</label>
                                        <input type="text" class="form-control" name="exentas" id="exentas" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>No Sujetas ($)</label>
                                        <input type="text" class="form-control" name="no_sujetas" id="no_sujetas" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>Costo ($)</label>
                                        <input type="text" class="form-control" name="costo_total" id="costo_total" readonly>
                                    </div>
                                </div>
                                <!-- /.col -->

                                <div class="col-md-3">
                                    <!--<div class="form-group">
                                        <label>IVA ($)</label>
                                        <input type="text" class="form-control" name="iva" id="iva" readonly>
                                    </div>-->

                                    <div class="form-group">
                                        <label>Venta Total ($)</label>
                                        <input type="text" class="form-control" name="venta_total" id="venta_total" readonly>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <button type="submit" class="btn btn-primary" name="btnGuardar" id="btnGuardar">Guardar</button>&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-primary" name="btnImpreso" id="btnImpreso" onclick="facImpreso();">FAC Impreso</button>&nbsp;&nbsp;&nbsp;
                            <a onclick="cancelarForm()">Regresar</a>

                        </div>
                        <!-- /.box-body -->
                    </div>
                </form>
                <!-- /.box formulario -->

                <!-- Modal Detalle-->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Detalle a Facturar</h4>
                            </div>
                            <div class="modal-body">
                                <form name="formularioDetalle" id="formularioDetalle" method="POST">
                                    <input type="hidden" name="id_detalle" id="id_detalle">
                                    <input type="hidden" name="id_fac" id="id_fac">
                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label>Servicio</label>
                                                <select class="form-control selectpicker selectColor" data-live-search="true" name="id_servicio" id="id_servicio" title="Seleccione Servicio"></select>
                                            </div>

                                            <div class="form-group">
                                                <label>Tipo</label>
                                                <select class="form-control selectpicker selectColor" data-live-search="true" name="tipo" id="tipo" title="Seleccione Tipo">
                                                    <option value="1" selected>Gravadas</option>
                                                    <option value="2">Ajena</option>
                                                    <option value="3">Exenta</option>
                                                    <option value="4">No Sujeta</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Cantidad</label>
                                                <input type="number" min="0" class="form-control" value="1" name="cantidad" id="cantidad" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Costo</label>
                                                <input type="number" min="0" step="0.01" value="0.00" class="form-control" name="costo" id="costo">
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label>Descripción</label>
                                                <input type="text" class="form-control" name="descripcion" id="descripcion">
                                            </div>

                                            <div class="form-group">
                                                <label>Precio Unitario</label>
                                                <input type="number" min="0" step="0.01" value="0.00" class="form-control" name="unitario" id="unitario" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Total</label>
                                                <input type="number" min="0" step="0.01" class="form-control" name="total" id="total" readonly>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" name="btnAgregarDetalle" id="btnAgregarDetalle">Agregar</button>&nbsp;&nbsp;&nbsp;
                                <button type="button" class="btn btn-default" id="close" data-dismiss="modal">Cerrar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Fin modal detalle -->

                <!-- Modal anular-->
                <div class="modal fade" id="modalAnular" tabindex="-1" role="dialog" aria-labelledby="modalAnular" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Anular</h4>
                            </div>
                            <div class="modal-body">
                                <form name="formularioAnular" id="formularioAnular" method="POST">
                                    <input type="hidden" name="id_fac_anular" id="id_fac_anular">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="form-group">
                                                <label>Tipo Anulación</label>
                                                <select class="form-control selectpicker selectColor" data-live-search="true" name="id_anulacion" id="id_anulacion" title="Seleccione Tipo de Anulación"></select>
                                            </div>

                                            <div class="form-group">
                                                <label>Comentario</label>
                                                <input type="text"  class="form-control" name="comentario" id="comentario" required>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                            </div>
                            <div class="modal-footer" id="div_btn_anular">
                                <button type="submit" class="btn btn-primary" name="btnAnular" id="btnAnular">Anular</button>&nbsp;&nbsp;&nbsp;
                                <button type="button" class="btn btn-default" id="close" data-dismiss="modal">Cerrar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Fin modal anular-->

                <!-- Modal mostrar pago-->
                <div class="modal fade" id="modalPago" tabindex="-1" role="dialog" aria-labelledby="modalPago" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Historial de Pago</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tblMostrarPago" class="table table-bordered table-striped">
                                            <thead>
                                            <th>Fecha</th>
                                            <th>Comentario</th>
                                            <th>Saldo</th>
                                            <th>Abono</th>
                                            <th>Nuevo Saldo</th>
                                            <th>Forma de Pago</th>
                                            <th>Banco</th>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </div>
                            <div class="modal-footer" id="div_btn_anular">
                                <button type="button" class="btn btn-default" id="close" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin modal mostrar pago-->

            </section>
            <!-- /.content -->

        </div>
        <!-- /.content-wrapper -->

        <?php
    }
    else
    {
        require 'noacceso.php';
    }
    require 'footer.php';
    ?>
    <script type="text/javascript" src="scripts/fac.js"></script>

    <?php
}
ob_end_flush();
?>
