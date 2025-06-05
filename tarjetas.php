<?php 
session_start();
include 'auth.php';
if(isset($_POST['actualizar_status'])){
    $a = revisionstatus($conex);
    echo $a;
}

if(isset($_SESSION['auth_key'])){
    if($_SESSION['auth_key']==2){
        function totaltarjetas($conex){
            $query="SELECT COUNT(Tarjetas.id) as total FROM `Tarjetas` WHERE Tarjetas.status=1;";
            $result=mysqli_query($conex,$query);
            $total=mysqli_fetch_assoc($result);
            return $total['total'];
        }
    $datatable_data="";
        $total=totaltarjetas($conex);
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
                WHERE Tarjetas.status=1
                ORDER BY Tarjetas.id DESC;";
        $title_table="TARJETAS REGISTRADAS: $total";
        $datatable_id="tarjetas";
        $boton_imprimir="
        <div class='input-group col-5'>
            <form method='POST' id='ticketserial' action='tarjetas.php'>
                <input name='ticketserial' style='display: none;' value='$serial'>
                <button class='btn btn-success form-control' name='actualizar_status' type='submit'>Actualizar Tarjetas</button>
            </form>
        </div>
        ";
        $top_table="
        <div class='row'>
        <div class='col-lg-9'
        <div class='card shadow mb-4'>
            <div class='card'>
                <div class='card-body'>
                    <div class='row'>
                    <div class='input-group col-7'><p class='card-title'>$title_table</p></div>
                    $boton_imprimir
                    </div>
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
        $bottom_table="</tbody></table></div></div></div></div></div></div>";
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
    }
}
?>


<script>
let table = new DataTable('#tarjetas', {
    responsive: true,
    "pageLength": 25,
    order:[[0,'desc']]

});
$(document).ready( function () {$('#tarjetas').DataTable();});
async function imprimir(total){
      let nombreImpresora = "POS58 Printer";
      let api_key = "3100e271-22bc-4e5c-803b-e34b99bc4ff2"
      var str = $( "#ticketserial" ).serialize();
      str= str.replace(/%23/g, "#");
      str= str.replace(/%20/g, " ");
      str= str.replace(/%7C/g, "|");
      str= str.replace("ticketserial=", "");
      var datos = str.split('|');
      var datosSize = datos.length;
      //calle
      //var fi = datos[0];
      //fi = fi.replace("fechainicial=", ""); // fi = fecha inicial
      //var fiym = fi.split('-'); //fecha inicial año y mes
      //var fiy =fiym[0];
      //var fim =fiym[1];
      //var meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
      //fim = meses[fim-1];
      
      const conector = new connetor_plugin()
      conector.fontsize("2")
      conector.textaling("center")
      conector.text("Fraccionamiento Chapultepec")
      conector.text("California")
      conector.fontsize("1")
      conector.text("Tijuana, Baja California")
      conector.feed("2")
      conector.text("Reporte Diario de Tickets")
      conector.text("Fecha: Mier 21 de Dic 2024 18:50")                        
      conector.textaling("left")
      conector.text("--------------------------------")
      conector.text("F.| Domicilio         | Pago")
      conector.text("--------------------------------")
      conector.fontsize("0.9")
      for (let step = 0; step < datosSize-1; step++) {
            var fila = datos[step].split("#")
            var filaSize = fila.length
            var cadafila = ""
            //conector.text("Numero de Columnas"+filaSize+datos[step])
            for(let paso =0; paso < filaSize; paso++){
                var filaL = fila[paso].length
                var z = " "
                if(paso==0){var x = 4; var y =x-filaL}
                if(paso==1){var x = 20; var y =x-filaL}
                if(paso==2){var x = 7; var y =x-filaL}
                z = z.repeat(y)
                //conector.text("Tamaño de fila"+filaL+fila[paso]+"a"+z+"a")
                cadafila=cadafila+fila[paso]+z
            }
            conector.text(cadafila) 
            conector.text("--------------------------------")
        }
        conector.text("Total de venta : "+total)
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

</script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>