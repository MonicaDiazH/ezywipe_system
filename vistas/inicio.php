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
if($_SESSION['INICIO']==1)
{
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Inicio
            <!--<small>Optional description</small>-->
        </h1>

    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        
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
<?php
}
ob_end_flush();
?>
