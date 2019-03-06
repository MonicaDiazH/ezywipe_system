<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>EZYWIPE SYSTEM</title>
    <!--Favicon-->
    <link rel="icon" type="image/png" href="../public/dist/img/favicon_logo.png">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../public/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../public/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/dist/css/AdminLTE.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect. -->
    <link rel="stylesheet" href="../public/dist/css/skins/skin-red-light.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../public/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
          href="../public/plugins/bootstrap-select/dist/css/bootstrap-select.min.css">
    <!-- AlertifyJS -->
    <link rel="stylesheet" href="../public/plugins/alertifyjs/css/alertify.min.css"/>
    <!-- AlertifyJS -->
    <link rel="stylesheet" href="../public/plugins/alertifyjs/css/themes/default.min.css"/>
    <!-- SAlertifyJS -->
    <link rel="stylesheet" href="../public/plugins/alertifyjs/css/themes/semantic.min.css"/>
    <!--Bootstrap Treeview-->
    <link rel="stylesheet" href="../public/bower_components/bootstrap-treeview/dist/bootstrap-treeview.min.css"
          type="text/css" media="all">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="../public/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-red-light sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="../public/dist/img/ezywipe_min.png"></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>EZYWIPE</b> SYSTEM</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="../public/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs"><?php echo $_SESSION['nombre']; ?> </span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="../public/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                                <p>
                                    <?php echo $_SESSION['nombre'] . ' - ' . $_SESSION['perfil']; ?>
                                    <small>Usuario: <?php echo $_SESSION['user']; ?></small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Perfil</a>
                                </div>
                                <div class="pull-right">
                                    <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Cerrar
                                        Sesión</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="../public/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?php echo $_SESSION['user']; ?></p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu tree" data-widget="tree">
                <li class="header">MENÚ</li>

                <?php
                require_once "../modelos/Usuario.php";
                $usuario = new Usuario();
                //obtenemos todo el menu de la tb_permiso
                $rspta = $usuario->menu();
                while ($reg = $rspta->fetch_object()) {
                    if ($_SESSION[$reg->nombre] == 1 && $reg->nivel == 1) {
                        if ($reg->url == "#") {
                            echo '<li class="treeview">
                        <a href="' . $reg->url . '"><i class="' . $reg->icono . '"></i> <span>' . $reg->nombre . '</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                      </a>';
                        } else {
                            echo '<li><a href="' . $reg->url . '"><i class="' . $reg->icono . '"></i> <span>' . $reg->nombre . '</span></a></li>';
                        }

                        //Determinamos submenus
                        echo '<ul class="treeview-menu">';
                        $rspta2 = $usuario->submenu($reg->id);
                        while ($reg2 = $rspta2->fetch_object()) {
                            //var_dump($reg2->nombre,$reg2->id);
                            if ($_SESSION[$reg2->nombre] == 1 && $reg2->nivel == 2) {
                                echo '<li><a href="' . $reg2->url . '">' . $reg2->nombre . '</a></li>';
                            }


                        }
                        echo '</ul>
                        </li>';

                    }
                }
                ?>
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>
