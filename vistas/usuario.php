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
if($_SESSION['USUARIOS']==1)
{
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Usuarios
        <button class="btn btn-danger pull-right" id="btnagregar" onclick="mostrarform(true)">Agregar</button>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
    <div class="row">
              <div class="col-md-12">
                  <div class="box box-danger">

                  <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Usuario</th>
                                <th>Perfil</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                              </thead>
                              <tbody>
                              </tbody>
                              <tfoot>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Usuario</th>
                                <th>Perfil</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                          </tfoot>
                        </table>
                    </div>

                      <div class="panel-body" id="formularioregistros">
                          <form name="formulario" id="formulario" method="POST">
                              <input type="hidden" name="id" id="id">
                              <div class="row">
                                  <div class="col-md-6">

                                      <div class="form-group">
                                          <label>Nombre</label>
                                          <input type="text" class="form-control" name="nombre" id="nombre" required>
                                      </div>

                                      <div class="form-group">
                                          <label>Correo</label>
                                          <input type="email" class="form-control" name="email" id="email">
                                      </div>

                                      <div class="form-group">
                                          <label>Perfil</label>
                                          <select id="id_perfil" name="id_perfil" class="form-control selectpicker selectColor" data-size="10" data-width="100%" data-live-search="true" title="Seleccionar Perfil"required></select>
                                      </div>

                                  </div>
                                  <!-- /.col -->
                                  <div class="col-md-6">

                                      <div class="form-group">
                                          <label>usuario</label>
                                          <input type="text" class="form-control" name="user" id="user" required>
                                      </div>

                                      <div class="form-group">
                                          <label>Contraseña</label>
                                          <input type="password" class="form-control" name="pass" id="pass" required>
                                      </div>
                                  </div>
                                  <!-- /.col -->
                              </div>
                              <button type="submit" class="btn btn-primary" name="btnGuardar" id="btnGuardar">Guardar</button>&nbsp;&nbsp;&nbsp;
                              <a onclick="cancelarform()">Regresar</a>
                          </form>
                      </div>

                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->

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
  <script type="text/javascript" src="scripts/usuario.js"></script>

<?php
}
ob_end_flush();
?>
