
<?php 
include('auth.php');


if($_SESSION['auth_key']>1){

  // ACCIONES DE POST TICKET
  if(isset($_POST['Pagar_Ticket'])){
    $usuarioid    = $_SESSION['usuarioid'];
    $domicilioid  = $_POST['domicilioid'];
    $fechainicial = $_POST['fechainicial'];
    $fechafinal   = $_POST['fechafinal'];
    $monto        = $_POST['monto'];
    $comentario   = $_POST['comentario'];
    $query        = "INSERT INTO `Tickets`
                    (`usuarioid`, `domicilioid`, `fechainicio`, `fechafinal`, `cantidad`, `comentario`, `statusid`) VALUES 
                    ($usuarioid,$domicilioid,'$fechainicial','$fechafinal',$monto,'$comentario',1)";
    if(strpos($comentario,"id:")===0){
      //divide el comentario en 2 partes, la fecha y el comentario real
      $comentario = explode("|",$comentario);
      //darles nombre a los valores separados
      $tid = $comentario[0];
      $comentario = $comentario[1];
      //formateado de fecha
      $tid = substr($tid,3,4);
      //genera la nueva consulta
      $query = "INSERT INTO `Tickets`
      (`id`,`usuarioid`, `domicilioid`, `fechainicio`, `fechafinal`, `cantidad`, `comentario`, `statusid`) VALUES 
      ($tid,$usuarioid,$domicilioid,'$fechainicial','$fechafinal',$monto,'$comentario',1)";
    }
    $result_tasks = mysqli_query($conex,$query);
    urlset("mapa.php");
  }

  if(isset($_POST['btn_tags'])){
      //$url = urlset('mapa.php');
      $domicilioid = $_POST['domicilioid'];
      $comentario = $_POST['comentario'];
      $cantidad = $_POST['cantidad'];
      $tags= preg_split('/\r\n|[\r\n]/', $_POST['tags']);
      foreach($tags as $tag){
          $array_tag = cleanrow($tag,$conex,$domicilioid,$comentario,$cantidad);
          $tag = $array_tag[0];
          $message = $array_tag[1];
          $status = $array_tag[2];
          //echo "tag: $tag | message: $message | status: $status <br>";
          $x = campoinput("no-name","text",'no-name',"","$message",'1','warning','disabled');
          $y = "<div class='row'>
                  <div class='col-lg-12'>
                      $x
                  </div>
              </div>
              <br>";
              echo "<div class='container fluid'>$y</div>";
          //echo "<script type='text/javascript'>window.location.replace('$url');</script>";
      }
  }



if(isset($_POST['editar_residente'])){
  $nombre = $_POST['nombre_cliente'];
  $telefono = $_POST['telefono_cliente'];
  $domicilioid = $_POST['domicilio'];
  $result = actualizar_residente($domicilioid,$nombre,$telefono);
  //echo "nombre $nombre<br>telefono $telefono<br>id $domicilioid<br>result $result";
}

if(isset($_POST['submit'])){
    $query = "SELECT nombre, YEAR(fecha) as y, CURDATE() as h FROM Porpagar where status=1 LIMIT 12";
    $count=0;
    $result_tasks = mysqli_query($conex, $query);
    while ($row = mysqli_fetch_assoc($result_tasks)){
        $nombre=$row['nombre'];
        $y=$row['y'];
        $h=$row['h'];
        $name="$nombre-$y";
        if($count<=2){$str="checked";}else{$str="";}
        
        $count=$count+1;
    }
}
    
?>

<div class="container fluid">
  <div class="titulo"><?php echo titulo($_GET['domicilio']); ?></div>



  <div class="row reticula">
          <?php reticula(); ?>
  </div>

<div class="row">
  <!-- Border Left Utilities -->
  <div class="col-lg-12">
    <form action="cal.php" method="POST" id="fraccform">

      <div class="row">
        <div class="col-2">
          <div class="py-3 mb-2">
            <div class="card-body">
              <div class="input-group" style="justify-content: center;">
                <a id="menos" class="btn btn-primary btn-circle btn-lg menos">
                    <i class="fas fa-arrow-left"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-8">
          <div class="card mb-2 py-3 border-left-primary">
            <div class="card-body">
              <div class="input-group">
                <input name="fechainicial" id="fechainicial" type="month" min="2024-5" value="2024-12" class=" itm form-control bg-light border-0 small fechainicial">
              </div>
            </div>
          </div> <!-- Fecha Inicial -->
        </div>
        <div class="col-2">
          <div class="py-3 mb-2">
            <div class="card-body">
              <div class="input-group" style="justify-content: center;">
                <a id="mas" class="btn btn-primary btn-circle btn-lg mas">
                    <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- Fecha inicial -->

      <div class="row">

        <div class="col-2">
          <div class="py-3 mb-2">
            <div class="card-body">
              <div class="input-group" style="justify-content: center;">
                <a id="izquierda" class="btn btn-primary btn-circle btn-lg izquierda">
                    <i class="fas fa-arrow-left"></i>
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-8">
          <div class="card py-3 mb-2 border-left-primary">
            <div class="card-body">
              <div class="input-group">
                <input name="fechafinal" id="fechafinal" type="month" min="2024-5" value="2024-12" class="itm form-control bg-light border-0 small fechafinal">
              </div>
            </div>
          </div>
        </div>

        <div class="col-2">
          <div class="py-3 mb-2">
            <div class="card-body">
              <div class="input-group" style="justify-content: center;">
                <a id="derecha" class="btn btn-primary btn-circle btn-lg derecha">
                    <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>

      </div> <!-- Fecha Final -->

      <div class="card mb-12 py-3 border-left-primary">
          <div class="card-body">
            <div class="input-group">
              <input name="monto" type="text" id="input_1" placeholder="MONTO POR COBRAR" class="form-control bg-light border-0 small">
            </div>
          </div>
      </div> <!-- Monto por cobrar -->

      <div class="card mb-12 py-3 border-left-primary">
          <div class="card-body">
            <div class="input-group">
              <input class="form-control bg-light border-0 small" name="comentario" type="textbox" placeholder="COMENTARIO">
            <input name="domicilio" style="display: none;" value="<?php 
                $domicilioid = $_GET['domicilio'];
                $query="SELECT CONCAT(calle,' ',numerocasa) as domicilio 
                FROM `Domicilios`
                LEFT JOIN Calles ON Calles.id=Domicilios.calleid 
                WHERE Domicilios.id=$domicilioid";
                $result_tasks=mysqli_query($conex,$query);
                $dom = "";
                foreach($result_tasks as $row){
                  $dom = $row['domicilio'];
                }
                echo $dom;
            ?>">
            <input name="folio" style="display: none;" value="<?php 
                $query="SELECT id FROM Tickets order by id desc limit 1";
                $result_tasks=mysqli_query($conex,$query);
                foreach($result_tasks as $row){
                  $folio = $row['id'];
                }
                echo $folio+1;
            ?>">
            <input name="domicilioid" style="display: none;" value="<?php echo $_GET['domicilio'];?>">
            </div>
          </div>
      </div> <!-- Comentario y domicilioid por GET -->

      <div class="card mb-12 py-3 border-left-success">
          <div class="card-body">
            <div class="input-group">
              <button onclick="enviarTicket()" class="btn btn-success form-control" name="Pagar_Ticket" type="submit">GENERAR TICKET</button>
            </div>            
          </div>
      </div> <!-- Boton Generar ticket y mandar impresion -->

      <div class="card mb-12 py-3 border-left-warning">
          <div class="card-body">
            <div class="input-group">
              <input onclick="cambiarurl(<?php echo $_GET['domicilio']; ?>)" class="btn btn-warning form-control" value="REGISTRAR TAGS">
            </div>            
          </div>
      </div> <!-- Boton para registrar tags -->

      <!--div class="card mb-12 py-3 border-left-dark">
          <div class="card-body">
              .border-left-dark
          </div>
      </div--> <!-- Espacio Plantilla -->

    </form> <!-- Form generar Tikcets -->
  </div>
</div>

<div class="row">
  <div class="card shadow mb-4 col-lg-12" style="padding: 0px !important;">
    <div class="card">
        <div class="card-body">
            <? encabezado_historial(); ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="historial">
                    <thead>
                        <tr>
                            <th col-index = 0>Folio</th>
                            <th col-index = 2>Domicilio</th>
                            <th col-index = 3>Cantidad</th>
                            <th col-index = 4>Rango</th>
                            <th col-index = 5>Comentario</th>
                            <th col-index = 6>Fecha ticket</th>
                            <th col-index = 7>Opciones</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <?php
                            $query = "SELECT 
                            Tickets.id as Tid, Domicilios.nombre, Tickets.fechainicio, DATE_FORMAT(Tickets.fechafinal,'%M DE %Y') AS info,
                            Tickets.fechafinal, DATE_FORMAT(Tickets.fechaticket,'%e De %M De %Y') as fechaticket, CONCAT('$',FORMAT(Tickets.cantidad,2,'en_US')) as cantidad, 
                            Tickets.comentario, Domicilios.numerocasa, Calles.calle 
                            FROM Tickets 
                            LEFT JOIN Domicilios on Domicilios.id = Tickets.domicilioid 
                            LEFT JOIN Usuarios on Usuarios.id = Tickets.usuarioid
                            LEFT JOIN Calles ON Calles.id = Domicilios.calleid 
                            where domicilioid=$domicilioid and Tickets.statusid=1
                            ORDER by Tickets.fechaticket  DESC;";
                            $result_tasks = mysqli_query($conex,$query);
                            while($row = mysqli_fetch_assoc($result_tasks)){
                                $id = $row['Tid'];
                                $fechainicio=datetostring($row['fechainicio']);
                                $fechafinal=datetostring($row['fechafinal']);
                                if($fechainicio==$fechafinal){$rango = $fechainicio;}
                                else {$rango = $fechainicio."<br>a<br>".$fechafinal;}
                                $fechaticket=$row['fechaticket'];
                                $comentario=$row['comentario'];
                                $numerocasa = $row['numerocasa'];
                                $monto=$row['cantidad'];
                                $calle=$row['calle'];
                                $um=$row['info'];
                                $info = "$nombre, $um";
                                echo "
                                        <tr>
                                            <td>$id</td>
                                            <td>$calle $numerocasa</td>
                                            <td>$monto</td>
                                            <td>$rango</td>
                                            <td>$comentario</td>
                                            <td>$fechaticket</td>
                                            <td>
                                              <div class='input-group'>
                                                <input id='serial_reimprimir_$id' style='display: none;' value='$id|$nombre|$calle $numerocasa|$monto|$fechainicio a $fechafinal|$comentario|$fechaticket'>
                                                <button onclick='reimprimir($id)' class='btn btn-primary form-control'>REIMPRIMIR</button>
                                              </div>            
                                            </td>
                                        </tr>
                                    ";
                            }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="card shadow mb-4 col-lg-12" style="padding: 0px !important;">
    <div class="card">
        <div class="card-body">
            <? encabezado_tarjetas_registradas();
                $query = "SELECT 
                Tarjetas.id,
                CONCAT(Calles.calle,' ',Domicilios.numerocasa) as domicilio,
                Domicilios.nombre as residente,
                Tarjetas.codigo,
                DATE_FORMAT(Tarjetas.fecharegistro,'%Y-%m') as fecha,
                Statustarjetas.css,
                Statustarjetas.descripcion
            FROM `Tarjetas`
            LEFT JOIN Domicilios ON Tarjetas.domicilioid=Domicilios.id
            LEFT JOIN Calles ON Calles.id = Domicilios.calleid
            LEFT JOIN Statustarjetas ON Statustarjetas.id=Domicilios.statusid
            WHERE Tarjetas.status=1 AND Domicilios.id = $domicilioid
            ORDER BY Tarjetas.id DESC;";
    $datatable_id="tarjetas";
    $top_table="
                <div class='table-responsive'>
                    <table class='table table-striped table-hover' id='$datatable_id'>
                        <thead>
                            <tr>
                                <th col-index = 0>Id</th>
                                <th col-index = 1>Domicilio</th>
                                <th col-index = 2>Residente</th>
                                <th col-index = 3>Codigo</th>
                                <th col-index = 4>Registro</th>
                                <th col-index = 5>Status</th>
                            </tr>
                        </thead>
                        <tbody> 
    ";
    $bottom_table="</tbody></table></div>";
    $result_tasks=mysqli_query($conex,$query);
    while($row=mysqli_fetch_assoc($result_tasks)){
        $id_tarjeta=$row['id'];
        $domicilio=$row['domicilio'];
        $residente=$row['residente'];
        $codigo=$row['codigo'];
        $fecharegistro=$row['fecha'];
        $status=$row['css'];
        $descripcion=$row['descripcion'];
        $datatable_data.="
                <tr>
                    <td class='text-center text-white $status'>$id_tarjeta</td>
                    <td>$domicilio</td>
                    <td>$residente</td>
                    <td>$codigo</td>
                    <td>$fecharegistro</td>
                    <td class='text-center text-white $status'>$descripcion</td>
                </tr>
            ";
    }
    $full_table=$top_table.$datatable_data.$bottom_table;
    echo $full_table;
             ?>
        </div>
    </div>
  </div>
</div>

<?php echo form_datos_cliente($_GET['domicilio'],'cal.php?domicilio='.$_GET['domicilio'],'editar_residente'); ?>

<div class="row">
  <div class="card shadow mb-4 col-lg-12" style="margin-top: 150px !important;">
    <div class="card">
    </div>
  </div>
</div> <!-- relleno de pie de pagina-->


</div>

<style>
  .checkbox-wrapper-26 * {
    -webkit-tap-highlight-color: transparent;
    outline: none;
    font-size: 2rem;
    line-height: 1.9rem;
    display: flex;
    justify-content: center;
    text-align: center;
  }
  @media (max-width: 500px) {
    .checkbox-wrapper-26 * {
      font-size: 1rem;
    }
  }
  .checkbox-wrapper-26 input[type="checkbox"] {
    display: none;
  }

  .checkbox-wrapper-26 label {
    --size: 50px;
    --shadow: calc(var(--size) * .07) calc(var(--size) * .1);

    position: relative;
    display: block;
    width: var(--size);
    height: var(--size);
    margin: 0 auto;
    background-color: #f72414;
    border-radius: 50%;
    box-shadow: 0 var(--shadow) #ffbeb8;
    cursor: pointer;
    transition: 0.2s ease transform, 0.2s ease background-color,
      0.2s ease box-shadow;
    overflow: hidden;
    z-index: 1;
  }

  .checkbox-wrapper-26 label:before {
    content: "";
    position: absolute;
    top: 50%;
    right: 0;
    left: 0;
    width: calc(var(--size) * .7);
    height: calc(var(--size) * .7);
    margin: 0 auto;
    background-color: #fff;
    transform: translateY(-50%);
    border-radius: 50%;
    box-shadow: inset 0 var(--shadow) #ffbeb8;
    transition: 0.2s ease width, 0.2s ease height;
  }

  .checkbox-wrapper-26 label:hover:before {
    width: calc(var(--size) * .55);
    height: calc(var(--size) * .55);
    box-shadow: inset 0 var(--shadow) #ff9d96;
  }

  .checkbox-wrapper-26 label:active {
    transform: scale(0.9);
  }

  .checkbox-wrapper-26 .tick_mark {
    position: absolute;
    top: -1px;
    right: 0;
    left: calc(var(--size) * -.05);
    width: calc(var(--size) * .6);
    height: calc(var(--size) * .6);
    margin: 0 auto;
    margin-left: calc(var(--size) * .14);
    transform: rotateZ(-40deg);
  }

  .checkbox-wrapper-26 .tick_mark:before,
  .checkbox-wrapper-26 .tick_mark:after {
    content: "";
    position: absolute;
    background-color: #fff;
    border-radius: 2px;
    opacity: 0;
    transition: 0.2s ease transform, 0.2s ease opacity;
  }

  .checkbox-wrapper-26 .tick_mark:before {
    left: 0;
    bottom: 0;
    width: calc(var(--size) * .1);
    height: calc(var(--size) * .3);
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.23);
    transform: translateY(calc(var(--size) * -.68));
  }

  .checkbox-wrapper-26 .tick_mark:after {
    left: 0;
    bottom: 0;
    width: 100%;
    height: calc(var(--size) * .1);
    box-shadow: 0 3px 5px rgba(0, 0, 0, 0.23);
    transform: translateX(calc(var(--size) * .78));
  }

  .checkbox-wrapper-26 input[type="checkbox"]:checked + label {
    background-color: #07d410;
    box-shadow: 0 var(--shadow) #92ff97;
  }

  .checkbox-wrapper-26 input[type="checkbox"]:checked + label:before {
    width: 0;
    height: 0;
  }

  .checkbox-wrapper-26 input[type="checkbox"]:checked + label .tick_mark:before,
  .checkbox-wrapper-26 input[type="checkbox"]:checked + label .tick_mark:after {
    transform: translate(0);
    opacity: 1;
  }
  th, td, tr {text-align: center !important;}

  .itm {text-transform: uppercase;}
</style>
<script>
//BOTONES Y INPUTS
const fecha_inicial =document.querySelector('.fechainicial');
const fecha_final =document.querySelector('.fechafinal');
const izquierda =document.getElementById('izquierda');
const derecha =document.getElementById('derecha');


//INICIAR DANDO VALORES PREDETERMINADOS INICIAL y FINAL : MES ACTUAL 
let valor_sumado=0;
let separador_mes_actual = "-";
let separador_mes_formato = "-";
let date = new Date();
let mes_actual = date.getMonth(); // valores de 0 - 11
let mes_actual_fixed = mes_actual + 1; // valores de 1 - 12
let year_actual = date.getFullYear();
let mes_sumado =mes_actual_fixed + valor_sumado;

//FORMATEADO DE MESES A DOS DIGITOS
if(mes_actual_fixed<9){separador_mes_actual="-0"}
if(mes_sumado<9){separador_mes_formato="-0"}

//FORMATEO DE LA FECHA AL INPUT TYPE MONTH
let fecha_actual_format = year_actual+separador_mes_formato+mes_actual_fixed;
let fecha_final_format = year_actual+separador_mes_actual+mes_sumado;


console.log('formato: '+ fecha_actual_format + ' formato: '+ fecha_final_format)

//ASIGNAR VALORES
fecha_inicial.value = fecha_actual_format;
fecha_final.value = fecha_final_format;

function restarMes(cualmes){// SE INSERTA UN QUERY SELECTOR Y LE RESTA 1 MES
  var res = cualmes.value.split('-');
  var year = res[0];
  var month = res[1];
  month = parseInt(month);
  year = parseInt(year);
  month =month - 1;
  if(month<1){
    month = month + 12;
    year = year - 1;
  }
  if(month<10){
    separador_mes_siguiente="-0";
  }
  else {
    separador_mes_siguiente="-";
  }
  cualmes.value=year+separador_mes_siguiente+month
}

function sumarMes(cualmes){// SE INSERTA UN QUERY SELECTOR Y LE SUMA 1 MES
  var res = cualmes.value.split('-');
  var year = res[0];
  var month = res[1];
  month = parseInt(month);
  year = parseInt(year);
  month =month + 1;
  if(month>12){
    month = month - 12;
    year = year + 1;
  }
  if(month<10){
    separador_mes_siguiente="-0";
  }
  else {
    separador_mes_siguiente="-";
  }
  cualmes.value=year+separador_mes_siguiente+month
}

function clonarMes(){//ASIGNA EL MISMO VALOR AL MES OBJETIVO
  var res = fecha_inicial.value.split('-');
  var year = res[0];
  var month = res[1];
  month = parseInt(month);
  year = parseInt(year);
  console.log(year + " " + month);
  month =month + 1;
  console.log(year + " " + month);

  if(month>12){
    month = month - 12;
    year =year+1;
    console.log("el valor es: "+year+"-"+month)
  }
  if(month<10){
    separador_mes_siguiente="-0";
  }
  else {
    separador_mes_siguiente="-";
  }
  fecha_final.value=year+separador_mes_siguiente+month
}

//EVENTOS DE CLICK y Listeners
izquierda.addEventListener("click", (event) => {restarMes(fecha_final);});
derecha.addEventListener("click", (event) => {sumarMes(fecha_final);});
menos.addEventListener("click", (event) => {restarMes(fecha_inicial);clonarMes();});
mas.addEventListener("click", (event) => {sumarMes(fecha_inicial);clonarMes();});
fecha_inicial.addEventListener("change",(event)=>{clonarMes();});


    let table = new DataTable('#historial', {
        responsive: true,
        "pageLength": 25,
        paging: false,
        searching: false,
        info: false,
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados"
        }
    
    });
 $(document).ready( function () {$('#historial').DataTable();});

  function showValues() {
    var str = $( "#fraccform" ).serialize();
    }
  function mostrar_impresoras(){
      connetor_plugin.obtenerImpresoras()
        .then(impresoras => {                    
          console.log(impresoras)
        });
  }

  function enviarTicket(){
    let input1 = document.getElementById('input_1');
    document.getElementById("fraccform").addEventListener("submit", function(e){
      if ( !input1.value ) {
        e.preventDefault();
        location.reload()
        return false;	
      } else {
        imprimir();
      }
    });
  }

  async function reimprimir(id){
    let input = document.getElementById('serial_reimprimir_'+id);
    let nombreImpresora = "POS58 Printer";
    let api_key = "3100e271-22bc-4e5c-803b-e34b99bc4ff2";
    var datos = input.value.split('|');
    var folio = datos[0];
    var nombre = datos[1];
    var domicilio = datos[2];
    var cantidad = datos[3];
    var rango = datos[4];rango = rango.split(' a ');
    var fecha_inicial = rango[0];
    var fecha_final = rango[1];
    var meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    var temporal = fecha_inicial.split('-');
    fecha_inicial =temporal[0]+"-"+meses[temporal[1]-1];
    temporal =fecha_final.split('-');
    fecha_final =temporal[0]+"-"+meses[temporal[1]-1];
    var comentario = datos[5];
    var fechaticket = datos[6];

    console.log(folio+nombre+domicilio+cantidad+fecha_inicial+fecha_final+comentario+fechaticket);

    
    const conector = new connetor_plugin()
    conector.fontsize("2")
    conector.textaling("center")
    conector.text("Fraccionamiento Chapultepec")
    conector.text("California")
    conector.fontsize("1")
    conector.text("Tijuana, Baja California")
    conector.feed("2")
    conector.text("Fecha: "+fechaticket)                        
    conector.feed("2")
    conector.textaling("left")
    conector.text("Folio Ticket: "+folio)
    conector.text("--------------------------------")
    conector.text("Aportacion Mensual para ")
    conector.text("seguridad y mantenimiento ")
    conector.text("de domicilio:")
    conector.feed("1")
    conector.text(domicilio)
    conector.feed("1")
    conector.text("Con rango de meses:")
    conector.text("--------------------------------")
    conector.feed("1")
    conector.text("desde: "+fecha_inicial)
    conector.feed("1")
    conector.text("hasta: "+fecha_final)
    conector.feed("1")
    conector.text("Descripcion             Importe")
    conector.text("--------------------------------")
    conector.text("PAGO MENSUALIDADES      "+cantidad)
    conector.text("--------------------------------")
    conector.fontsize("1.6")
    conector.text("Comentario:")
    conector.text(comentario)
    conector.text("--------------------------------")
    conector.feed("2")
    //conector.qr("https://credikappa.com/frc/ticket.php?id="+folio)
    conector.cut("0") 
    
    const resp = await conector.imprimir(nombreImpresora, api_key);
    if (resp === true) {} 
    else {
      console.log("Problema al imprimir: "+resp);
    }

  }

  async function imprimir(){
    //ASIGNACION DE VALORES DE IMPRESORA Y CREDENCIALES
    let nombreImpresora = "POS58 Printer";
    let api_key = "3100e271-22bc-4e5c-803b-e34b99bc4ff2"

    //SERIALIZADO DEL FORMULARIO Y SEGMENTADO DE DATOS
    var str = $( "#fraccform" ).serialize();
    var datos = str.split('&');
    //calle=1&numero=dad&nombre=......
    
    
    var fi = datos[0];
    fi = fi.replace("fechainicial=", ""); // fi = fecha inicial
    var fiym = fi.split('-'); //fecha inicial año y mes
    var fiy =fiym[0];
    var fim =fiym[1];
    var meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    fim = meses[fim-1];

    var ff = datos[1];
    ff = ff.replace("fechafinal=", ""); // fi = fecha inicial
    var ffym = ff.split('-'); //fecha inicial año y mes
    var ffy =ffym[0];
    var ffm =ffym[1];
    ffm = meses[ffm-1];

    var monto = datos[2];
    monto = monto.replace("monto=", ""); 

    var comentario = datos[3];
    comentario = comentario.replace("comentario=", ""); 
    comentario = comentario.replace(/%20/g, " ");
    
    var dom = datos[4];
    dom=dom.replace("domicilio=","");
    dom=dom.replace(/%20/g, " ");

    var folio =datos[5];
    folio = folio.replace("folio=","");


    let meses_array = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic']
    let semanas = ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']
    const date = new Date()
    let zona = date.getTimezoneOffset()
    let hora = date.getHours()
    let horas = zona/60
    let x
    if(zona!=480){
      if(horas<8){
          x = 8 - horas
          hora = hora - x
      }
      if(horas>8){
          x = horas - 8
          hora = hora + x
      }
    }
    let minutos = date.getMinutes()
    let ys = ''
    if(minutos<10){ys='0'}
    let weekday = date.getDay()
    let day = date.getDate()
    let month = date.getMonth()
    let year = date.getFullYear()
    let fecha = semanas[weekday] + " " + day + " " + meses_array[month] + " " + year + " " + hora + ":" + ys + minutos
    
    const conector = new connetor_plugin()
    conector.fontsize("2")
    conector.textaling("center")
    conector.text("Fraccionamiento Chapultepec")
    conector.text("California")
    conector.fontsize("1")
    conector.text("Tijuana, Baja California")
    conector.feed("2")
    conector.text("Fecha: "+fecha)                        
    conector.feed("2")
    conector.textaling("left")
    conector.text("Folio Ticket: "+folio)
    conector.text("--------------------------------")
    conector.text("Aportacion Mensual para ")
    conector.text("seguridad y mantenimiento ")
    conector.text("de domicilio:")
    conector.feed("1")
    conector.text(dom)
    conector.feed("1")
    conector.text("Con rango de meses:")
    conector.text("--------------------------------")
    conector.feed("1")
    conector.text("Desde: "+fim+" de "+fiy)
    conector.feed("1")
    conector.text("Hasta: "+ffm+" de "+ffy)
    conector.feed("1")
    conector.text("Descripcion             Importe")
    conector.text("--------------------------------")
    conector.text("PAGO MENSUALIDADES      $"+monto+".00")
    conector.text("--------------------------------")
    conector.fontsize("1.6")
    conector.text("Comentario:")
    conector.text(comentario)
    conector.text("--------------------------------")
    conector.feed("2")
    //conector.qr("https://villanovenasur.com")
    conector.cut("0") 
    
    const resp = await conector.imprimir(nombreImpresora, api_key);
    if (resp === true) {} 
    else {
      console.log("Problema al imprimir: "+resp);
    }
  }
  function cambiarurl(str) {
    var loc = window.location.href;
    var dir = loc.substring(0, loc.lastIndexOf('/'));
    window.location.href= dir +'/tags.php?domicilio='+str;
    //window.alert(dir +'/tags.php?domicilio='+str);
  }
  

</script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>




<?php
} ?>
