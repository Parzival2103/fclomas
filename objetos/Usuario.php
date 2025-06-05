<?php 
Class Usuario{
    protected $conex;
    public $id;
    public $nombre;
    public $telefono;
    public $domicilioid;
    public $usuario;
    public $fotourl;
    public $rol = 20;
    public $status;
    private $error_message;
    
    public function __construct($conex){
        $this->conex = $conex;
    }
    function extraerUsuario($usuario, $password){
        $usuario    = stripslashes($usuario);
        $password   = stripslashes($password);
        $usuario    = mysqli_real_escape_string($this->conex, $usuario);
        $password   = mysqli_real_escape_string($this->conex, $password);
        $password   = md5($password);
        $query      = "SELECT *, 1 as fila FROM Usuarios WHERE usuario='$usuario' AND password='$password' LIMIT 1";
        $result     = mysqli_query($this->conex, $query);
        while($row = mysqli_fetch_assoc($result)){
            if($row['fila']==1){
                $_SESSION['id']         = $row['id'];
                $_SESSION['nombre']     = $row['nombre']; 
                $_SESSION['usuario']    = $row['usuario'];
                $_SESSION['fotourl']    = $row['fotourl'];
                $_SESSION['permisos']   = $row['permisoid'];
                $_SESSION['domicilio']  = $row['domicilioid'];
                $_SESSION['status']     = $row['statusid'];

                $this->id = $_SESSION['id'];
                $this->nombre = $_SESSION['nombre'];
                $this->usuario = $_SESSION['usuario'];
                $this->fotourl = $_SESSION['fotourl'];
                $this->rol = $_SESSION['permisos'];
                $this->domicilioid = $_SESSION['domicilio'];
                $this->status = $_SESSION['status'];
            }
        }
    }
    function registrarUsuario($usuario, $password, $nombre){
        $usuario    = stripslashes($usuario);
        $password   = stripslashes($password);
        $nombre     = stripslashes($nombre);
        $usuario    = mysqli_real_escape_string($this->conex, $usuario);
        $password   = mysqli_real_escape_string($this->conex, $password);
        $nombre     = mysqli_real_escape_string($this->conex, $nombre);
        $password   = md5($password);
        $datetime   = date("Y-m-d H:i:s");
        $default    = 1; //asignacion default de nuevo usuario para permiso y status
        $query      = " INSERT INTO Usuarios 
                                (usuario, nombre, password, fecharegistro, permisoid, statusid) 
                        VALUES  ('$usuario', '$nombre', '$password', '$datetime',$default,$default)";
        $result     = mysqli_query($this->conex, $query);

        if($result){return true;}else{return false;}
    }
    function redirigirUsuario(){
        switch($this->rol){
            case 1:
                urlset('mapa.php');
                break;
            case 2:
                urlset('mapa.php');
                break;
            case 3:
                urlset('mapa.php');
                break;
            case 4:
                urlset('mapa.php');
                break;
            case 5:
                urlset('mapa.php');
                break;
            case 20: 
                $this->error_message =  "La contraseña es incorrecta, vuelve a intentarlo";
                break;
            default:
                $this->error_message = "El rol se ha cambiado pero no esta en la lista: $this->rol";
                break;
        }
        return $this->error_message;
    }
    function urlset($url){
        $host = $_SERVER['HTTP_HOST'];
        $ruta = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $result = "http://$host$ruta/$url";
        echo "<script type='text/javascript'>window.location.replace('$result');</script>";
    }
}