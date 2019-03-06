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
                    Pago Consumidor Final
                    <!--<small>Optional description</small>-->
                </h1>
            </section>

            <!-- Main content -->
            <section class="content container-fluid">

                <div class="box box-danger" id="listadoRegistros">
                    <div class="box-body">
                        <!--CONTENIDO -->
                        <!--MOSTRAR TOTALES-->
                        <h4><strong>Total Pendiente: $ <label id="label_total_pendiente"></label></strong></h4>
                            <br>
                        <!--FIN MOSTRAR TOTALES-->
                            <table id="tbllistado" class="table table-bordered table-striped">
                                <thead>
                                <th>Código</th>
                                <th>Referencia</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Correlativo</th>
                                <th>Condición Pago</th>
                                <th>Monto Total</th>
                                <th>Saldo Pendiente</th>
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
                                <th>Saldo Pendiente</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                                </tfoot>
                            </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box table -->
                <form name="formulario" id="formulario" method="POST">
                
                <div id="formularioRegistros">
                <!--Historial de pagos-->
                <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">Historial de Pagos</h3>
                        </div>
                        <div class="box-body">
                        <!--CONTENIDO -->
                                <table id="tblhistorial" class="table table-bordered table-striped">
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
                    <!-- /.box-body -->
                    </div><!--/Historial de pagos-->
                <div class="box box-danger">
                    <div class="box-body">
                        <!--CONTENIDO -->
                                <input type="hidden" name="id" id="id">
                                <input type="hidden" name="id_fac" id="id_fac">
                                <input type="hidden" name="abono_h" id="abono_h">
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>Código</label>
                                            <input type="text" class="form-control" name="codigo" id="codigo" readonly="true">
                                        </div>

                                        <div class="form-group">
                                            <label>Total facturado</label>
                                            <input type="text" class="form-control" name="total_factura" id="total_factura" readonly="true">
                                        </div>

                                        <div class="form-group">
                                            <label>Fecha</label>
                                            <input type="text" class="form-control" name="fecha" id="fecha" value="<?php echo date('m/d/Y')?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Forma de pago</label>
                                            <select class="form-control selectpicker selectColor" name="id_forma_pago" id="id_forma_pago" title="Seleccionar Forma de Pago" required></select>
                                        </div>
                                        <div class="form-group">
                                            <label>Banco</label>
                                            <select class="form-control selectpicker selectColor" name="id_banco" id="id_banco" title="Seleccionar Banco"></select>
                                        </div>

                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Cliente</label>
                                            <input type="text" class="form-control" name="cliente" id="cliente" readonly="true">
                                        </div>

                                        <div class="form-group">
                                            <label>Saldo pendiente ($)</label>
                                            <input type="number" step="0.01" class="form-control" name="saldo_pendiente" id="saldo_pendiente" readonly="true">
                                        </div>

                                        <div class="form-group">
                                            <label>Abono ($)</label>
                                            <input type="number" step="0.01" min="0" class="form-control" name="abono" id="abono" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Nuevo saldo ($)</label>
                                            <input type="number" step="0.01" class="form-control" name="nuevo_saldo" id="nuevo_saldo" readonly="true">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Comentarios</label>
                                            <input type="text" class="form-control" name="comentario" id="comentario" required>
                                        </div>
                                        

                                    </div>
                                    <!-- /.col -->
                                 
                                </div>
                                <button type="submit" class="btn btn-primary" name="btnGuardar" id="btnGuardar">Guardar</button>&nbsp;&nbsp;&nbsp;
                                <a onclick="cancelarForm()">Regresar</a>

                    </div>
                    <!-- /.box-body -->
                </div>

                    
                        <!-- /.box-body -->
                    </div> 
                    <!-- /.box -->
                
                   </div>
                </form>
                <!-- /.box formulario -->
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
    <script type="text/javascript" src="scripts/pagofac.js"></script>

    <?php
}
ob_end_flush();
?>
