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
if($_SESSION['PERFILES']==1)
{
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 text-align="left">
            Perfiles
            <!--<small>Optional description</small>-->
        </h1>
        <ol class="breadcrumb">
            <a onClick="mostrarForm(true)" class="btn btn-primary btn-sm" id="btnAgregar">AGREGAR</a>
            <!--<li class="active"><a href="#"><i class="fa fa-dashboard"></i> Usuarios</a></li>
            <li class="active">Here</li>-->
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-danger">
            <div class="box-body">
                <!--CONTENIDO -->
                <div class="panel-body" id="listadoRegistros">
                    <table id="tbllistado" class="table table-bordered table-striped">
                        <thead>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Opciones</th>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Opciones</th>
                        </tfoot>
                    </table>
                </div>
                <div class="panel-body" id="formularioRegistros">
                    <form name="formulario" id="formulario" method="POST">
                        <input type="hidden" name="id" id="id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Perfil</label>
                                    <input type="text" class="form-control" name="nombre" id="nombre" required>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Descripción</label>
                                    <input type="text"class="form-control" name="descripcion" id="descripcion" required>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        
                        <button type="submit" class="btn btn-primary" name="btnGuardar" id="btnGuardar">Guardar</button>&nbsp;&nbsp;&nbsp;
                        <a onclick="cancelarForm()">Regresar</a>
                    </form>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

<!--Inicio Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form name="formModal" id="formModal" method="POST">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Seleccione Permisos</h4>
            </div>
            <div class="modal-body">
                    <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="id_perfil" id="id_perfil">
                                    <label>Permisos</label>
                                    <select id="slc_permiso" name="slc_permiso"class="form-control selectpicker" data-size="5" data-width="100%" data-live-search="true" title="Seleccionar Permiso"required>
                                    </select>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Detalle Permisos</label>
                                    <select id="slc_dpermiso" name="slc_dpermiso"class="form-control selectpicker" data-size="5" multiple data-width="100%" data-live-search="true" title="Seleccionar Detalle Permiso"  disabled required>
                                    </select>
                                </div>
                            </div>
                            <!-- /.col -->
                    </div>   
            </div>
            <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="btnGModal" id="btnGModal" onclick="insertarPP()">Guardar</button>&nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn btn-default" name="btnCModal" id="btnCModal" onclick="cancelarModal()" data-dismiss="modal" aria-hidden="true">Cerrar</button>
            </div>
        </div>
    </div>
</form>
</div>
<!--Fin Modal-->

<?php
}
else 
{
 require 'noacceso.php';
}
require 'footer.php';
?>
<script type="text/javascript" src="scripts/perfil.js"></script>

<?php
}
ob_end_flush();
?>