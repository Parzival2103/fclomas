<?php include('auth.php');

if($_SESSION['auth_key']>1){
  if(isset($_POST['nuevo_residente'])){
      $nombre = $_POST['nombre'];
      $telefono = $_POST['telefono'];
      $calleid = $_POST['calle'];
      $numero_casa = $_POST['numero_casa'];
      echo $nombre.$telefono.$calleid.$numero_casa;
      $query = "INSERT INTO Domicilios (nombre, telefono, calleid, numerocasa, fecharegistro,fraccionamientoid,statusid) VALUES ('$nombre','$telefono',$calleid,'$numero_casa',CURRENT_DATE(),2,1)";
      enviarconsulta($query);
      echo $query;
    }
  x($arg);
}
function x($arg){
  echo "
    <div class='container fluid'>
      <div class='titulo'>$arg</div>
      <div class='row'>
        <div class='col-lg-12'>
          <form action='nuevo.php' method='POST' id='form_nuevo_residente'>
         ";
            echo generar_input(
              "danger",
              "nombre",
              "text",
              "NOMBRE DEL RESIDENTE",
              "nombre input");
            echo generar_input(
              "primary",
              "telefono",
              "text",
              "TELEFONO DEL RESIDENTE",
              "telefono input");
            generar_select(
              "select id, calle as descripcion from Calles",
              "danger",
              "calle",
              "SELECCIONE LA CALLE",
              "select de calle");
            echo generar_input(
              "primary",
              "numero_casa",
              "text",
              "NUMERO DEL DOMICILIO",
              "numero casa input");
            echo generar_submit(
              'REGISTRAR RESIDENTE',
              'nuevo_residente',
              "");
         echo " 
          </form>
        </div>
      </div>
    </div>
    ";
}

?>

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
    let table = new DataTable('#prestamos', {
        responsive: true,
        columnDefs: [
            {
                target: 0,
                visible: false,
                searchable: false
            }
        ],
        "pageLength": 25
    
    });
 $(document).ready( function () {$('#prestamos').DataTable();});

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

  async function imprimir(){
    let nombreImpresora = "POS58 Printer";
    let api_key = "3100e271-22bc-4e5c-803b-e34b99bc4ff2"
    var str = $( "#fraccform" ).serialize();
    //calle=1&numero=dad&nombre=......
    var datos = str.split('&');
    //calle
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
    var folio =datos[5];
    folio = folio.replace("folio=","");
    
    
    const conector = new connetor_plugin()
    conector.fontsize("2")
    conector.textaling("center")
    conector.text("Fraccionamiento Chapultepec")
    conector.text("California")
    conector.fontsize("1")
    conector.text("Tijuana, Baja California")
    conector.feed("2")
    conector.text("Folio Ticket----------------"+folio)
    conector.text("--------------------------------")
    conector.textaling("left")
    conector.text("Comprobante de")
    conector.text("mensualidades pagadas")
    conector.feed("1")
    conector.text("desde: "+fim+" de "+fiy)
    conector.feed("1")
    conector.text("hasta: "+ffm+" de "+ffy)
    conector.feed("1")
    conector.text("Fecha: Mier 21 de Dic 2024 18:50")                        
    conector.text("Descripcion             Importe")
    conector.text("--------------------------------")
    conector.text("PAGO MENSUALIDADES $"+monto+".00")
    conector.text("--------------------------------")
    conector.text("Total:             $"+monto+".00")
    conector.fontsize("1.6")
    conector.text(comentario)
    conector.feed("2")
    //conector.feed("1")
    //conector.fontsize("2")
    //conector.textaling("center")
    //conector.qr("https://villanovenasur.com")
    //conector.text(str)
    //conector.feed("5")
    //conector.cut("0") 
    
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