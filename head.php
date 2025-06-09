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

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- SIDEBAR -->
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

                <!-- ICONO INICIO -->
                    <!-- Clases del Icono -->
                    <a 
                        class="
                            sidebar-brand 
                            d-flex 
                            align-items-center 
                            justify-content-center" 
                        href="mapa.php">
                        <!-- Icono -->
                            <div class="sidebar-brand-icon rotate-n-15">
                                <i class="fas fa-laugh-wink"></i>
                            </div>
                        <!-- Termina Icono -->
                        <!-- Texto del Icono -->
                            <div 
                                class="
                                    sidebar-brand-text 
                                    mx-3 
                                    <?php if (!isset($_SESSION['auth_key'])){echo "d-none";} ?>
                                ">
                                <?php if (isset($_SESSION['auth_key'])){echo "Menu principal";} ?>
                            </div>
                        <!-- Termina Texto del Icono -->
                    </a>
                <!-- Termina ICONO INICIO -->

                <!-- Divider -->
                    <hr class="sidebar-divider my-0">
                <!-- Termina Divider -->

                <?php if (isset($_SESSION['auth_key'])): ?>

                <!-- ITEM DE NAVEGACION -- (MAPA DEL FRACCIONAMIENTO)-->
                    <li class="nav-item active">
                        <!-- Opciones de Item -->
                            <a class="nav-link" 
                                href="mapa.php">
                                <!-- Icono del Item -->
                                <i class="fas fa-fw fa-tachometer-alt"></i>
                                <!-- Nombre del Item -->
                                <span>Mapa del Fraccionamiento</span>
                            </a>
                        <!-- Termina Opciones de Item -->

                        <!-- Contenido del Item -->
                            
                        <!-- Termina Contenido del Item -->
                    </li>
                <!-- Termina ITEM DE NAVEGACION -- (MAPA DEL FRACCIONAMIENTO)-->

                <!-- Divider -->
                    <hr class="sidebar-divider">
                <!-- Termina Divider -->

                <!-- ITEM DE NAVEGACION -- (REPORTES)-->
                    <li class="nav-item">
                        <!-- Opciones de Item -->
                            <a class="nav-link collapsed" 
                                href="#" 
                                data-toggle="collapse" 
                                data-target="#collapseTwo"
                                aria-expanded="true" 
                                aria-controls="collapseTwo">
                                <!-- Icono del Item -->
                                <i class="fas fa-fw fa-chart-bar"></i>
                                <!-- Nombre del Item -->
                                <span>Reportes</span>
                            </a>
                        <!-- Termina Opciones de Item -->

                        <!-- Contenido del Item -->
                            <!-- MENU BARRA LATERAL -->
                                <!-- Opciones menu barralateral -->
                                    <div 
                                    id="collapseTwo" 
                                    class="collapse" 
                                    aria-labelledby="headingTwo" 
                                    data-parent="#accordionSidebar">
                                <!-- Termina Opciones menu barralateral -->

                                <!-- Contenedor de menu barralateral -->
                                    <div class="bg-white py-2 collapse-inner rounded">

                                        <!-- DIVISOR/TITULO -->
                                            <h6 class="collapse-header">Ventas:</h6>
                                                <!-- Opciones -->
                                                <a class="collapse-item" href="ventadiaria.php">Venta Del dia</a>
                                                <a class="collapse-item" href="ventamensual.php">Venta mensual</a>
                                        <!-- Termina DIVISOR/TITULO -->
                                        
                                        <!-- DIVISOR/TITULO -->
                                            <h6 class="collapse-header">Tarjetas:</h6>
                                                <!-- Opciones -->
                                                <a class="collapse-item" href="tarjetas.php">Tarjetas registradas</a>
                                                <a class="collapse-item" href="activos.php">Tarjetas activas</a>
                                        <!-- Termina DIVISOR/TITULO -->
                                        
                                    </div>
                                <!-- Termina Contenedor de menu barralateral -->
                            
                                    </div>
                            <!-- Termina MENU BARRA LATERAL -->
                        <!-- Termina Contenido del Item -->
                    </li>
                <!-- Termina ITEM DE NAVEGACION -- (REPORTES)-->

                <!-- Divider -->
                    <hr class="sidebar-divider">
                <!-- Termina Divider -->

                <!-- ITEM DE NAVEGACION -- (REGISTROS)-->
                    <li class="nav-item">
                        <!-- Opciones de Item -->
                            <a class="nav-link collapsed" 
                                href="#" 
                                data-toggle="collapse" 
                                data-target="#collapseUtilities" 
                                aria-expanded="true" 
                                aria-controls="collapseUtilities"> <!-- 
                                                                        data-target y aria-controls deben ser el mismo ID que el div 
                                                                        del contenido que contendra el Item de Navegacion            -->
                                <!-- Icono del Item -->
                                <i class="fas fa-fw fa-wrench"></i>
                                <!-- Nombre del Item -->
                                <span>Registros</span>
                            </a>
                        <!-- Termina Opciones de Item -->

                        <!-- Contenido del Item -->
                            <!-- MENU BARRA LATERAL -->
                                <!-- Opciones menu barralateral -->
                                    <div 
                                    id="collapseUtilities" 
                                    class="collapse" 
                                    aria-labelledby="headingUtilities" 
                                    data-parent="#accordionSidebar">
                                <!-- Termina Opciones menu barralateral -->

                                <!-- Contenedor de menu barralateral -->
                                    <div class="bg-white py-2 collapse-inner rounded">

                                        <!-- DIVISOR/TITULO -->
                                            <h6 class="collapse-header">Contabilidad:</h6>
                                                <!-- Opciones -->
                                                <a class="collapse-item" href="gastos.php">Gastos</a>
                                        <!-- Termina DIVISOR/TITULO -->
                                        
                                        
                                    </div>
                                <!-- Termina Contenedor de menu barralateral -->
                            
                                    </div>
                            <!-- Termina MENU BARRA LATERAL -->
                        <!-- Termina Contenido del Item -->
                    </li>
                <!-- Termina ITEM DE NAVEGACION -- (REGISTROS)-->

                <!-- Divider -->
                    <hr class="sidebar-divider">
                <!-- Termina Divider -->

                <!-- ITEM DE NAVEGACION -- (CERRAR SESION)-->
                    <li class="nav-item active">
                        <!-- Opciones de Item -->
                            <a class="nav-link" 
                                href="logout.php">
                                <!-- Icono del Item -->
                                <i class="fas fa-sign-out-alt"></i>
                                <!-- Nombre del Item -->
                                <span>Cerrar Sesión</span>
                            </a>
                        <!-- Termina Opciones de Item -->

                        <!-- Contenido del Item -->
                            
                        <!-- Termina Contenido del Item -->
                    </li>
                <!-- Termina ITEM DE NAVEGACION -- (CERRAR SESION)-->

                <?php endif; ?>
                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">

                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>

            </ul>
        <!-- Termina SIDEBAR -->

        <!-- CONTENIDO EN CADA PAGINA -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content" style="text-align: center;">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button 
                    id="sidebarToggleTop" 
                    class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                </nav>
           
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

<!-- la clase "d-none d-md-inline" hace que los elementos desaparezcan cuando se cambia a la vista en pantallas pequeñas -->