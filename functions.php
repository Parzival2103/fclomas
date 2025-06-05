<?php

//CONSULTAS SQL

function conexion(){
    $conex = mysqli_connect("68.70.163.36","villanov_admin","Qazzaqwerrew1B","villanov_fracc");
    $conex->query("SET lc_time_names = 'es_ES'");
    $conex->set_charset("utf8");
    return $conex;
}
function totalmensual(){
    $conex = conexion();
    $query="SELECT SUM(cantidad) AS total FROM Tickets WHERE DATE_FORMAT(CURDATE(),'%Y-%m')=DATE_FORMAT(fechaticket,'%Y-%m');";
    $result=mysqli_query($conex,$query);
    $total=mysqli_fetch_assoc($result);
    return $total['total'];
}
function totaldiario(){
    $conex = conexion();
    $query="SELECT SUM(cantidad) AS total FROM Tickets WHERE CURDATE()=DATE_FORMAT(fechaticket,'%Y-%m-%e')";
    $result=mysqli_query($conex,$query);
    $total=mysqli_fetch_assoc($result);
    if($total['total']==null){return 0;}
    else{return $total['total'];}
}
function totaldiario_transacciones(){
    $conex = conexion();
    $query="SELECT id FROM Tickets WHERE CURDATE()=DATE_FORMAT(fechaticket,'%Y-%m-%e')";
    $result=mysqli_query($conex,$query);
    $total = 0;
    while($row=mysqli_fetch_assoc($result)){
        $total = $total+1;
    }
    return $total;
}
function ticketserialmensual(){
    $conex = conexion();
    $serial="";
    $query="SELECT CONCAT(Tickets.id,'#',Calles.calle,' ',Domicilios.numerocasa,'#',Tickets.cantidad) as fila 
            FROM Tickets 
            LEFT JOIN Domicilios ON Domicilios.id=Tickets.domicilioid
            LEFT JOIN Calles ON Calles.id=Domicilios.calleid
            WHERE DATE_FORMAT(CURDATE(),'%Y-%m')=DATE_FORMAT(fechaticket,'%Y-%m');";
    $result=mysqli_query($conex,$query);
    while($row=mysqli_fetch_assoc($result)){
        $serial=$serial.$row['fila']."|";
    }
    return $serial;
}
function ticketserialdiario(){
    $conex = conexion();
    $serial="";
    $query="SELECT CONCAT(Tickets.id,'#',Calles.calle,' ',Domicilios.numerocasa,'#',Tickets.cantidad) as fila 
            FROM Tickets 
            LEFT JOIN Domicilios ON Domicilios.id=Tickets.domicilioid
            LEFT JOIN Calles ON Calles.id=Domicilios.calleid
            WHERE CURDATE()=DATE_FORMAT(fechaticket,'%Y-%m-%e');";
    $result=mysqli_query($conex,$query);
    while($row=mysqli_fetch_assoc($result)){
        $serial=$serial.$row['fila']."|";
    }
    $query="SELECT CONCAT(t.id,'#',c.calle,' ',d.numerocasa,'#',t.cantidad) as fila
            FROM Tarjetas t
            LEFT JOIN Domicilios d ON d.id=t.domicilioid
            LEFT JOIN Calles c ON c.id=d.calleid
            WHERE CURDATE()=DATE_FORMAT(t.fecharegistro,'%Y-%m-%e');";
    $result=mysqli_query($conex,$query);
    while($row=mysqli_fetch_assoc($result)){
        $serial=$serial.$row['fila']."|";
    }
    return $serial;
}
function revisionstatus($conex): string{ 
    $query="SELECT Domicilios.id, Domicilios.nombre, Domicilios.statusid FROM Domicilios LEFT JOIN Tickets ON Tickets.domicilioid = Domicilios.id GROUP BY Domicilios.id;";
    $result=mysqli_query($conex,$query);
    $total='';
    $rows_corriente=0;
    $rows_morosos=0;
    $rows_cancelar=0;
    $rows_cancelado=0;
    while($row=mysqli_fetch_assoc($result)){
            $id=$row['id'];
            $consulta="SELECT COUNT(id) as count, domicilioid,  CONCAT(fechamenor.valor,' - ',fechamayor.valor) as rango, 
            IF(fechamayor.valor>=DATE_FORMAT(CURDATE(),'%Y-%m'),1,0) AS activo,
            IF(fechamayor.valor>=DATE_FORMAT(CURDATE()-INTERVAL 3 MONTH,'%Y-%m'),0,1) AS moroso,
            IF(fechamayor.valor>=DATE_FORMAT(CURDATE()-INTERVAL 6 MONTH,'%Y-%m'),0,1) AS desactivado,
            IF(fechamayor.valor>=DATE_FORMAT(CURDATE(),'%Y-%m'),1,IF(fechamayor.valor>=DATE_FORMAT(CURDATE()-INTERVAL 3 MONTH,'%Y-%m'),2,IF(fechamayor.valor>=DATE_FORMAT(CURDATE()-INTERVAL 5 MONTH,'%Y-%m'),3,4))) AS status
            FROM `Tickets`,
            (SELECT fechainicio as valor FROM Tickets WHERE domicilioid=$id ORDER BY fechainicio ASC LIMIT 1) as fechamenor,
            (SELECT fechafinal as valor FROM Tickets WHERE domicilioid=$id ORDER BY fechafinal DESC LIMIT 1) as fechamayor 
            WHERE domicilioid=$id
            ORDER BY `Tickets`.`id` DESC;";
            $resultado=mysqli_query($conex,$consulta);
            while($row=mysqli_fetch_assoc($resultado)){
                //$id=$row['domicilioid'];
                $status=$row['status'];
                $try="UPDATE `Domicilios` SET `statusid` = $status WHERE `Domicilios`.`id` = $id;"; // set status al corriente

                if($status==1){$rows_corriente+=1;}
                if($status==2){$rows_morosos+=1;}
                if($status==3){$rows_cancelar+=1;}
                if($status==4){$rows_cancelado+=1;}

                $resultado=mysqli_query($conex,$try);
            }
        }
        $x = 'Residentes Activos: '.$rows_corriente.', Residentes Morosos: '.$rows_morosos.', Residentes Por cancelar: '.$rows_cancelar.', Residentes Sin Pagos: '.$rows_cancelado;
        $reporte="
        <div class='row'>
            <div class='col-lg-9'>
                <div class='card mb-12 py-3 border-left-success'>
                    <div class='card-body'>
                        <div class='input-group'>
                        $x
                        </div>            
                    </div>
                </div>
            </div>
        </div>
        ";
        return $reporte.'<br>';
}
function titulo($id){
    $conex = conexion();

    $query = "SELECT 
        Calles.calle,
        Domicilios.numerocasa,
        Domicilios.nombre 
        FROM Tickets 
        LEFT JOIN Domicilios ON Domicilios.id = Tickets.domicilioid 
        LEFT JOIN Calles ON Calles.id = Domicilios.calleid 
        where Tickets.domicilioid=$id";

    $result_tasks = mysqli_query($conex, $query);
    if($row = mysqli_fetch_assoc($result_tasks)){
        $calle            = $row['calle'];
        $numerocasa       = $row['numerocasa'];
        $nombre           = $row['nombre'];
        $arg = "$calle $numerocasa a nombre de: $nombre";
        return $arg;
    }
}

function enviarconsulta($query){
    $conex = conexion();
    $x =mysqli_query($conex,$query);
    return $x;
}
/** 
 * count() te regresa la cantidad de objetos en un array, en los arrays de las consultas sql, primero
 * vienen los keys que son los nombres de las columnas en la consulta si una consulta tiene 4 columnas 
 * entonces la funcion regresara valor 4, no contabiliza las filas
 * 
 * los keys despues pueden utilizarse para obtener un valor de esta manera $row['key'];
 * 
 * si quieres usar los titulos de las columnas puedes obtener un array con la funcion array_keys();
 */

// FORMATEADO DE STRINGS

function urlset($url){// completar el url
    $host = $_SERVER['HTTP_HOST'];
    $ruta = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $result = "http://$host$ruta/$url";
    echo "<script type='text/javascript'>window.location.replace('$result');</script>";
}
function cleanrow($str, $conex, $domicilioid, $comentario, $cantidad){// revisar tags validos
    $str_len = strlen($str);
    switch ($str_len){
        case 0: 
            $message = "El texto esta vacio";   
            $arr = [$str,$message,0];
            return $arr;
        case 6:
        case 7:
        case 8:
            $x = is_numeric($str);
            if($x===true){
                $y = tagexist($str,$conex, $domicilioid,$comentario,$cantidad);;
                return $y;
                
            } else {
                $message = "No registrado $str no es numerico";
                $arr = [$str,$message,0];
                return $arr;
            }
        case 24:
            $str = substr($str,18,6);
            $str = hexdec($str);
            $x = is_int($str);
            if($x===true){
                $y = tagexist($str,$conex,$domicilioid,$comentario,$cantidad);;
                return $y;
            }else {
                $message = "No registrado $str ";
                $arr = [$str,$message,0];
                return $arr;
            }
        default:
            $message = "El codigo $str no es valido como TAG";
            $arr = [$str,$message,0];
            return $arr;
    }
}
function tagexist($tag,$conex,$domicilioid,$comentario,$cantidad){//funcion auxiliar de cleanrow()
    $query = "  SELECT domicilioid, nombre, statusid 
                FROM Tarjetas 
                LEFT JOIN Domicilios 
                ON Domicilios.id=Tarjetas.domicilioid 
                WHERE codigo=$tag";
    $result_tasks = mysqli_query($conex,$query);
    $count = mysqli_num_rows($result_tasks);
    $domid = "";
    $nombre = "";
    $stid = "";
    while($row=mysqli_fetch_assoc($result_tasks)){
        $domid = $row['domicilioid'];
        $nombre = $row['nombre'];
        $stid = $row['statusid'];
    }

    if($count==1){
        $message = "El tag $tag pertenece a $nombre con status: $stid";
        $arr = [$tag,$message,1];
        return $arr;
    }elseif($count==0){
        $str_len = strlen($tag);
        $query="INSERT INTO `Tarjetas`(`domicilioid`, `codigo`,`comentario`,`cantidad`, `status`) 
                VALUES ($domicilioid,'$tag','$comentario',$cantidad,1);";
        $result_tasks = mysqli_query($conex,$query);
        $message = "Registrado $tag valido tipo $str_len";
        $arr = [$tag,$message,1];
        return $arr;
    }
}
function getDombyId($domicilioid, $conex){//regresa la direccion dando el id
    $query = "SELECT CONCAT(Calles.calle,' ',Domicilios.numerocasa) as dom 
                FROM Domicilios
                LEFT JOIN Calles ON Calles.id = Domicilios.calleid
                WHERE Domicilios.id=$domicilioid
            ";
    $result_tasks = mysqli_query($conex,$query);
    $dom = mysqli_fetch_assoc($result_tasks);
    $dom = $dom['dom'];
    return $dom;
}
function ObtenerDatosDeUsuario($domicilioid){//regresa la direccion dando el id
    $conex        = conexion();
    $query        = "SELECT * FROM Domicilios WHERE Domicilios.id=$domicilioid";
    $result_tasks = mysqli_query($conex,$query);
    $row = mysqli_fetch_assoc($result_tasks);
    $nombre=$row['nombre'];
    $telefono=$row['telefono'];
    $resultarray = [$nombre,$telefono];
    return $resultarray;
}

function datetostring($date){
    $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    $d =  explode("-",$date);
    $y = $d[0];
    $m = $d[1];
    $m = intval($m);
    $m = $meses[$m-1];
    $string = "$m de $y";
    return $string;
}


function separarCasa($input) {
    // Expresión regular para separar el número exterior y el número interior
    // El número exterior es una secuencia de dígitos (\d+)
    // El número interior puede ser una letra opcionalmente seguida de un guion y otra letra
    if (preg_match('/^(\d+)([A-Za-z-]*)$/', $input, $matches)) {
        $numeroExterior = $matches[1];  // Primer grupo: números
        $numeroInterior = $matches[2];  // Segundo grupo: letra o letra con guion

        return [
            'numeroExterior' => $numeroExterior,
            'numeroInterior' => $numeroInterior
        ];
    }
    
    return null;  // Si no se encuentra el patrón esperado
}

/* Ejemplos de prueba
$casas = ["11B", "11-A", "123A", "45", "200-B"];
foreach ($casas as $casa) {
    $resultado = separarCasa($casa);
    if ($resultado) {
        echo "Input: $casa\n";
        echo "Número Exterior: " . $resultado['numeroExterior'] . "\n";
        echo "Número Interior: " . $resultado['numeroInterior'] . "\n\n";
    } else {
        echo "Formato inválido para: $casa\n\n";
    }
}*/


//  CREACION DE ELEMENTOS BOOTSTRAP
function campoinput($name,$type,$id,$placeholder,$value = 0,$visible=1,$color = "primary",$disabled = ""){//div input bootstrap
    $x="";
    if($visible==0){$x="style= 'display: none;'";}
    $result = "
            <div class='card mb-12 py-3 border-left-$color' $x>
            <div class='card-body'>
                <div class='input-group'>
                <label for='$id' class='form-label'>$placeholder</label>
                <input 
                    class='form-control bg-light border-0 small'
                    name='$name' 
                    type='$type' 
                    id='$id' 
                    value='$value'
                    placeholder='$placeholder'
                    $disabled>
                </div>
            </div>
        </div> <!-- $placeholder -->
        ";
    return $result;
}
function campotextarea($name,$id,$rows,$color = "primary"){//div textarea bootstrap
    $result = "
            <div class='card mb-12 py-3 border-left-$color'>
            <div class='card-body'>
                <div class='input-group'>
                <label for='$id' class='form-label' style='text-transform: capitalize;'>$name</label>
                <textarea 
                    class='form-control bg-light border-0 small'
                    name='$name' 
                    id='$id' 
                    rows='$rows'
                    autofocus></textarea>
                </div>
            </div>
        </div> <!-- $name -->
        ";
    return $result;
}
function camposubmit($onclick,$name,$placeholder, $color = "success"){//div sumbit bootstrap
    $result = "
            <div class='card mb-12 py-3 border-left-$color'>
                <div class='card-body'>
                    <div class='input-group'>
                        <button 
                        class='btn btn-success form-control form-submit-custom' 
                        type=''
                        onclick='$onclick()' 
                        name='$name'> 
                        $placeholder</button>
                    </div>            
                </div>
            </div>
            ";
    return $result;
}
function crearForm($size,$action,$id,$campos,$method = "POST"){
    $result = "
            <div class='row'>
                <div class='col-lg-$size'>
                    <form action='$action' method='$method' id='$id'>
                        $campos
                    </form> <!-- Form generar Tikcets -->
                </div>
            </div>";
    return $result;
}


//funciones de pantalla generacion de tickets
function reticula(){
    $conex = conexion();
    $domicilioid=$_GET['domicilio'];
    $query = "
              SELECT 
                nombre, 
                YEAR(fecha) as y, 
                MONTH(fecha) as m, 
                year(CURDATE()) as cy, 
                month(CURDATE()) as cm, 
                IF(fecha>=consult.fi and fecha<=consult.ff,1,0) as pago 
                FROM Porpagar, 
                  (
                    SELECT 
                      domicilioid as di, 
                      concat(fi.fi, '-01') as fi, 
                      concat(ff.ff,'-01') as ff 
                      FROM Tickets,
                        (
                          SELECT fechainicio as fi 
                          FROM `Tickets` 
                          where domicilioid=$domicilioid AND Tickets.statusid = 1
                          order by fechainicio ASC limit 1
                        ) as fi,
                        (
                          SELECT fechafinal as ff 
                          FROM `Tickets` 
                          WHERE Tickets.domicilioid = $domicilioid AND Tickets.statusid = 1
                          order by fechafinal DESC limit 1
                        ) as ff
                    WHERE Tickets.domicilioid = $domicilioid and statusid = 1 LIMIT 1
                  ) as consult 
              where status=1 and fecha>=CURDATE()-INTERVAL 1 month LIMIT 12;";
    $count=0;
    $result_tasks = mysqli_query($conex, $query);
    if(mysqli_num_rows($result_tasks)>=1){
        while ($row = mysqli_fetch_assoc($result_tasks)){
            $nombre=$row['nombre'];
            $y=$row['y'];
            $m=$row['m'];
            $h=$row['h'];
            $pago=$row['pago'];
            $name="$nombre $y";
            if($pago==1){$str="checked";}else{$str="";}
            echo "<div class='checkbox-wrapper-26 col-4  disabled-checkbox'>
            <input type='checkbox' id='_checkbox-26-$y-$m' name='' class=' disabled-checkbox' $str>
            <label for='_checkbox-26-$y-$m' class='' >
                <div class='tick_mark'></div>
            </label>
            <p class='checklabel' >$name</p>
            </div>";
            $count=$count+1;
        }
    }
    else {
        echo "<p style='color: red;'>EL RESIDENTE NO TIENE NINGUN PAGO REGISTRADO DESDE 2023 EN ADELANTE</p>";
    }
}
function encabezado_historial(){
    $domicilioid=$_GET['domicilio'];
    $nombre = enviarconsulta("SELECT * FROM Domicilios WHERE id=$domicilioid");
    $nombre = mysqli_fetch_assoc($nombre);
    $nombre = $nombre['nombre'];

    $info = enviarconsulta(
        "SELECT 
                fechafinal AS info
                FROM Tickets 
                LEFT JOIN Domicilios on Domicilios.id = Tickets.domicilioid 
                where domicilioid=$domicilioid and Tickets.statusid=1
                ORDER BY Tickets.fechafinal DESC;
                ");
    if(mysqli_num_rows($info)==0){
        $info = "Sin registro";
    }
    else {
        $info = mysqli_fetch_assoc($info);
        $info = datetostring($info['info']);
        $info = "Pagado hasta: <p style='color: red;'>$info";
    }
    $x = "$nombre<br>$info<p>";
    echo"<h4 class='card-title'>HISTORIAL DE:<br>$x</h4>"; 
}
class Tags{
    var $id;
}
class Domicilio{
    var $nombre;
    var $calle;
    var $numerocasa;
    var $status;

}
function encabezado_tarjetas_registradas(){

    $domicilioid=$_GET['domicilio'];
    $resultado = mysqli_fetch_assoc(enviarconsulta("SELECT * FROM Domicilios WHERE id=$domicilioid"));
    $domicilio = new Domicilio;
    $domicilio->nombre = $resultado['nombre'];

    $info = enviarconsulta("SELECT count(id) as count FROM `Tarjetas` WHERE domicilioid = $domicilioid;");
    if(mysqli_num_rows($info)==0){
        $info = "Sin registro";
    }
    else {
        $info = mysqli_fetch_assoc($info);
        $info = $info['count'];
        $info = "Total: $info";
    }
    $x = "$domicilio->nombre<br>$info<p>";
    echo"<h4 class='card-title'>TARJETAS DE:<br>$x</h4>"; 
}
function tarjetas_activas(){
    $domicilioid= $_GET['domicilio'];
    $resultado = enviarconsulta(
        "SELECT 
                    Domicilios.id                                   as id,
                    CONCAT(Calles.calle,' ',Domicilios.numerocasa)  as domicilio,
                    Domicilios.nombre                               as residente,
                    Statustarjetas.css,
                    Statustarjetas.descripcion
                FROM 
                    Domicilios
                LEFT JOIN 
                    Calles          ON Calles.id         = Domicilios.calleid
                LEFT JOIN 
                    Statustarjetas  ON Statustarjetas.id = Domicilios.statusid  
                ORDER BY 
                    Calles.calle ASC, 
                    CAST(Domicilios.numerocasa AS UNSIGNED) ASC;
                ");
    $datatable_id="tarjetas";
    $top_table="<div class='row'>
  <div class='card shadow mb-4 col-lg-12' style='padding: 0px !important;'>
    <div class='card'>
        <div class='card-body'>
                <div class='table-responsive'>
                    <table class='table table-striped table-hover' id='$datatable_id'>
                        <thead>
                            <tr>
                                <th col-index = 0>Id</th>
                                <th col-index = 1>Domicilio</th>
                                <th col-index = 2>Residente</th>
                                <th col-index = 3>Tarjetas</th>
                                <th col-index = 5>Status</th>
                            </tr>
                        </thead>
                        <tbody> 
    ";
    $bottom_table="</tbody></table></div></div></div></div></div>";
    $datatable_data="";
    while($row=mysqli_fetch_assoc($resultado)){
        $id=$row['id'];
        $count = mysqli_fetch_assoc(enviarconsulta("SELECT count(id) as count FROM `Tarjetas` WHERE domicilioid = $id;"));$count = $count['count'];
        $domicilio=$row['domicilio'];
        $residente=$row['residente'];
        $status=$row['css'];
        $descripcion=$row['descripcion'];
        $datatable_data.="
                <tr>
                    <td class='text-center text-white $status'>$id</td>
                    <td>$domicilio</td>
                    <td>$residente</td>
                    <td>$count</td>
                    <td class='text-center text-white $status'>$descripcion</td>
                </tr>
            ";
    }
    $full_table=$top_table.$datatable_data.$bottom_table;
    echo $full_table;
}
function generar_titulo($domicilioid){
    $conex = conexion();
    $query = "SELECT CONCAT(calle,' ',numerocasa,' A NOMBRE DE: ',nombre) as titulo
              FROM Domicilios
              LEFT JOIN Calles ON Calles.id = Domicilios.calleid
              where Domicilios.id=$domicilioid;
            ";
    $result = mysqli_query($conex, $query);
    $titulo = mysqli_fetch_assoc($result);
    return $titulo;
}

function form_datos_cliente($domicilioid,$localizacion,$identificador){
    $datos = ObtenerDatosDeUsuario($domicilioid);
    $input_nombre = generar_input(
        "primary",
        "nombre_cliente",
        "text",
        "NOMBRE DEL RESIDENTE",
        "nombre input",
        $datos[0],
        "<input name='domicilio' style='display: none;' value='$domicilioid'>");
    $input_telefono = generar_input(
        "warning",
        "telefono_cliente",
        "text",
        "TELEFONO DEL RESIDENTE",
        "nombre input",
        $datos[1]);
    $submit = generar_submit('ACTUALIZAR DATOS','editar_residente','');
    
    $a ="<div class='row'>
            <div class='card shadow mb-12 col-sm-12'>
                <!-- Encabezado -->

                    <a 
                        href            = '#collapseCardExample' 
                        class           = 'd-block card-header py-3' 
                        data-toggle     = 'collapse' 
                        role            = 'button' 
                        aria-expanded   = 'true' 
                        aria-controls   = 'collapseCardExample'
                    >
                        <h6 class='m-0 font-weight-bold text-primary'>EDITAR DATOS DEL CLIENTE</h6> <!-- Titulo -->
                    </a>

                <!-- Contenido colapsable -->

                    <div class='collapse ' id='collapseCardExample' style=''>
                        <div class='card-body'>
                            <form action='$localizacion' method='POST' id='$identificador'>
                            $input_nombre
                            $input_telefono
                            $submit
                            </form>
                        </div>
                    </div>
            </div>
        </div>
        ";
    return $a;
    

}
function generar_input($color,$nombre,$tipo,$placeholder,$comentario,$value="",$extras=""){
    $x = "
    <div class='card mb-12 py-3 border-left-$color'>
        <div class='card-body'>
            <div class='input-group'>

            <input class='form-control bg-light border-0 small' name='$nombre' type='$tipo' placeholder='$placeholder' value='$value'>
            $extras
            

            </div>
        </div>
    </div> <!-- $comentario -->
    ";
    $extras = "
            <input name='folio' style='display: none;' value=''>
            <input name='domicilioid' style='display: none;' value=''>";
    return $x;
}
function generar_submit($texto,$nombre,$onclick){
    $x = "
          <div class='card mb-12 py-3 border-left-success'>
          <div class='card-body'>
            <div class='input-group'>
              <button onclick='$onclick' class='btn btn-success form-control' name='$nombre' type='submit'>$texto</button>
            </div>            
          </div>
      </div> <!-- Boton Generar ticket y mandar impresion -->
    ";
    return $x;
}
function generar_select($query,$color,$nombre,$placeholder,$comentario){
    $x = enviarconsulta($query);
    $y = '';
    while($row = mysqli_fetch_assoc($x)){
        $id = $row['id'];
        $descripcion = $row['descripcion'];
        $string = "<option value='$id'>$descripcion</option>";
        $y = $y.$string;
    }
    echo "
    <div class='card mb-12 py-3 border-left-$color'>
        <div class='card-body'>
            <div class='input-group'>
            <select style='height: 45px' class='form-control bg-light border-0 small' name='$nombre'>
            <option value='0' selected>$placeholder</option>
            $y
            </select>
            </div>
        </div>
    </div> <!-- $comentario -->
    ";
}

function actualizar_residente($id,$nombre,$telefono){
    $conex = conexion();
    $query = "UPDATE Domicilios SET nombre='$nombre', telefono='$telefono' WHERE id=$id";
    $result = mysqli_query($conex,$query);
    return $result;
}
function historial_de_tarjetas(){
    
}
?>

