<?php session_start();
include 'head.php';
include 'functions.php';
$conex = conexion();

if(!isset($_SESSION['auth_key'])){
    echo "
    <div class='row'>
        <div class='col-lg-12'>
            <form action='auth.php' method='POST'>

            <div class='card mb-12 py-3 border-left-primary'>
                <div class='card-body'>
                    <div class='input-group'>
                    <input name='pswd' type='text' placeholder='CLAVE DE ACCESO' class='form-control bg-light border-0 small'>
                    </div>
                </div>
            </div> <!-- Contraseña -->

            <div class='card mb-12 py-3 border-left-success'>
                <div class='card-body'>
                    <div class='input-group'>
                    <button onclick='imprimir()' class='btn btn-success form-control' name='session_try' type='submit'>INICIAR SESION</button>
                    </div>            
                </div>
            </div> <!-- Iniciar Sesion -->

            </form> <!-- Form iniciar sesion -->
        </div>
    </div>
    ";
} 

//SI NO EXISTE NINGUN LOGN CREADO, SE MUESTRA EL FORM DE LOGIN Y VERIFICAR LAS CREDENCIALES
if(isset($_POST['session_try'])){
    $auth_key=$_POST['pswd'];
    $host = $_SERVER['HTTP_HOST'];
    $ruta = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $url = "http://$host$ruta/mapa.php";
    $query="SELECT * FROM Usuarios where password='$auth_key' AND statusid=1";
    $result_tasks = mysqli_query($conex,$query);
    $result_rows = mysqli_num_rows($result_tasks);
    if($result_rows==0){
        //si no encuentra la contraseña descodificada buscara codificada con md5
        $auth_key=md5($auth_key);
        $query="SELECT * FROM Usuarios where password='$auth_key' AND statusid=1";
        $result_tasks = mysqli_query($conex,$query);
    }
    while($row=mysqli_fetch_assoc($result_tasks)){
        $_SESSION['auth_key']=$row['permisosid'];
        $_SESSION['usuarioid']=$row['id'];
        echo "<script type='text/javascript'>window.location.replace('$url');</script>";
    }
}

//SI EXISTE UN INTENTO DE LOGIN POR URL, 
if(isset($_GET['key'])){
    $auth_key=$_GET['key'];
    $host = $_SERVER['HTTP_HOST'];
    $ruta = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $url = "http://$host$ruta/mapa.php";
    $query="SELECT * FROM Usuarios where password=$auth_key AND statusid=1";
    $result_tasks = mysqli_query($conex,$query);
    $result_rows = mysqli_num_rows($result_tasks);
    if($result_rows==0){
        //si no encuentra la contraseña descodificada buscara codificada con md5
        $auth_key=md5($auth_key);
        $query="SELECT * FROM Usuarios where password='$auth_key' AND statusid=1";
        $result_tasks = mysqli_query($conex,$query);
    }
    while($row=mysqli_fetch_assoc($result_tasks)){
        $_SESSION['auth_key']=$row['permisosid'];
        $_SESSION['usuarioid']=$row['id'];
        echo "<script type='text/javascript'>window.location.replace('$url');</script>";
    }
}
?>