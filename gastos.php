<?php include('auth.php');

if($_SESSION['auth_key']>1){
  if(isset($_POST['nuevo_gasto'])){
      $proveedor = $_POST['proveedor'];
      $concepto = $_POST['concepto'];
      $monto = $_POST['monto'];
      $usuarioid = $_SESSION['usuarioid'];
      $query = "INSERT INTO Gastos (usuarioid, proveedorid, concepto, cantidad, fecha, status) VALUES ($usuarioid,'$proveedor','$concepto',$monto,CURRENT_DATE(),1)";
      enviarconsulta($query);
      //echo $query;
      urlset('mapa.php');
    }
  x($arg);
}
function x($arg){
  echo "
    <div class='container fluid'>
      <div class='titulo'>$arg</div>
      <div class='row'>
        <div class='col-lg-12'>
          <form action='gastos.php' method='POST' id='form_nuevo_residente'>
         ";
            generar_select(
              "select id, nombre as descripcion from Proveedores",
              "danger",
              "proveedor",
              "SELECCIONE EL PROVEEDOR",
              "select de calle");
            echo generar_input(
              "primary",
              "concepto",
              "text",
              "CONCEPTO DEL GASTO",
              "concepto input");
            echo generar_input(
              "danger",
              "monto",
              "text",
              "MONTO",
              "monto input");
            echo generar_submit(
              'REGISTRAR GASTO',
              'nuevo_gasto',
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


  

</script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>