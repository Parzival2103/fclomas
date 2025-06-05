<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Fraccionamiento Chapultepec California</title>

    <!-- Tipo de letra personalizado para esta plantilla-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- CSS personalizado para esta plantilla-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="mapa.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Frac. <sup>Chapultepec California</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="mapa.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Mapa del Fraccionamiento</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-chart-bar"></i>
                    <span>Reportes</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Ventas:</h6>
                        <a class="collapse-item" href="ventadiaria.php">Venta Del dia</a>
                        <a class="collapse-item" href="ventamensual.php">Venta mensual</a>
                        <h6 class="collapse-header">Tarjetas:</h6>
                        <a class="collapse-item" href="tarjetas.php">Tarjetas registradas</a>
                        <a class="collapse-item" href="activos.php">Tarjetas activas</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Registros</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Contabilidad:</h6>
                        <a class="collapse-item" href="gastos.php">Gastos</a>
                    </div>
                </div>
            </li>


            <!-- Heading ->
            <div class="sidebar-heading">
                Addons
            </div>

            <!-- Nav Item - Pages Collapse Menu ->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="login.html">Login</a>
                        <a class="collapse-item" href="register.html">Register</a>
                        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="404.html">404 Page</a>
                        <a class="collapse-item" href="blank.html">Blank Page</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts ->
            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li>

            <!-- Nav Item - Tables ->
            <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content" style="text-align: center;">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button> 

                </nav>
                <!-- End of Topbar -->

<?php
    $config = require __DIR__ . '/config.php';
    $conex = mysqli_connect($config['host'], $config['user'], $config['password'], $config['name']);
    $conex->query("SET CHARACTER SET utf8");
    $conex->query("SET lc_time_names = 'es_ES'");
    $host = $_SERVER['HTTP_HOST'];
    $ruta = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $url = "http://$host$ruta";
    $url_auth = "http://$host$ruta/auth.php";
?>
<style>
    .calles{
        width: 80%;
        height: 100px;
        font-size: 2.5rem !important;
        padding: 10px 20px 10px 20px;
        text-decoration: none;
        margin: 10px;
        color: #fff;
    }
    .calles:hover {
        color:#0d5b8c;
    }
    .calles-centro{
        width: 100%;
        writing-mode: vertical-rl;
        font-size: 4rem;
    }
    .titulo{
        font-size: 2.2rem;
    }
    .check{
        height: 100px;
        width: 100%;
    }
    .checklabel{
        font-size: 1.62rem;
        width: 100%;
        text-align-last: center;
        padding-top: 25px;
    }
    .checkborder{
        border: solid 2px #0d5b8c;
        padding: 5px 35px;
    }
    .input-lg {
            height: 120px;
            width: 140%;
        }
    @media (max-width: 850px) {
        .calles{
            font-size: 1.2rem !important;
            height: auto;
        }
        .check{
            height: auto;
            width: auto;
        }
        .checklabel{
            font-size: auto;
            width: auto;
            text-align-last: center;
            padding-top: 25px;
        }
        .checkborder{
            border: solid 2px #0d5b8c;
            padding: 5px 35px;
        }
        .input-lg {
            height: 60px;
            width: 70%;
        }
        .mobile{
            display: none;
        }
        .mobile_view {
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
    }  
    .disabled-checkbox {
        opacity: 0.8; /* Reduce the opacity of the checkbox */
        cursor: not-allowed; /* Change the cursor to indicate that the checkbox is disabled */
        pointer-events: none; /* Disable pointer events to prevent user interaction */
    }
    .form-ticket{
        background-color: #bdf8ff;
        border: #008a32 solid;
        height: auto;
        font-size: 2rem;
        margin-bottom: 5px;
    }
    .full-input{
        width: 96%;
        height: 96%;
        margin: 2%;
    }
    .input-bg {
        background-color: #ededed;
        color:#000000;
    }
    ::placeholder {
    color: black;
    opacity: 0.9;
    }
    .reticula{
        margin: 10px;
        border: solid 5px lightgray;
        padding: 10px;
        background-color: #f0f0f0;
    }
    
</style>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
<script src="plugin_impresora_termica.js"></script>