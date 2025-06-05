<?php 
session_start();
include 'auth.php';

if(isset($_SESSION['auth_key'])){
    if($_SESSION['auth_key']==2){
        $datatable_data="";
        $total=totalmensual();
        $serial=ticketserialmensual();
        $query = "SELECT 
                    Tickets.id,
                    Usuarios.nombre,
                    DATE_FORMAT(Tickets.fechaticket,'%d-%M') as fecha,
                    Domicilios.nombre as residente, 
                    CONCAT(Calles.calle,' ',Domicilios.numerocasa) as domicilio, 
                    CONCAT(Tickets.fechainicio,' a ',Tickets.fechafinal) as rango, 
                    CONCAT('$',FORMAT(Tickets.cantidad,2,'en_US')) as cantidad, 
                    Tickets.comentario
                    FROM Tickets
                    LEFT JOIN Domicilios ON Domicilios.id=Tickets.domicilioid 
                    LEFT JOIN Usuarios ON Usuarios.id=Tickets.usuarioid 
                    LEFT JOIN Calles ON Calles.id=Domicilios.calleid 
                    WHERE DATE_FORMAT(CURDATE(),'%Y-%m')=DATE_FORMAT(Tickets.fechaticket,'%Y-%m')
                    ORDER BY Tickets.fechaticket DESC;";
        $boton_imprimir="
        <div class='input-group col-4'>
            <form method='POST' id='ticketserial'>
                <input name='ticketserial' style='display: none;' value='$serial'>
                <button onclick='imprimir($total)' class='btn btn-success form-control' name='imprimir_ticket_diario' type='submit'>Reporte Mensual</button>
            </form>
        </div>
        ";
        $title_table="<div class='row'><div class='input-group col-8'><p class='card-title'>VENTA TOTAL DEL MES: $$total</p></div>$boton_imprimir</div>";
        $datatable_id="venta_mensual";

        $top_table="
        <div class='row'>
        <div class='card shadow mb-4 ml-4'>
            <div class='card'>
                <div class='card-body'>$title_table
                    <div class='table-responsive'>
                        <table class='table table-striped table-hover' id='$datatable_id'>
                            <thead>
                                <tr>
                                    <th col-index = 0>Folio</th>
                                    <th col-index = 1>Nombre</th>
                                    <th col-index = 2>Residente</th>
                                    <th col-index = 3>Domicilio</th>
                                    <th col-index = 4>Rango</th>
                                    <th col-index = 5>Cantidad</th>
                                    <th col-index = 6>Comentario</th>
                                </tr>
                            </thead>
                            <tbody> 
        ";
        $bottom_table="</tbody></table></div></div></div></div></div>";
        $result_tasks=mysqli_query($conex,$query);
        while($row=mysqli_fetch_assoc($result_tasks)){
            $id=$row['id'];
            $fecha=$row['fecha'];
            $residente=$row['residente'];
            $domicilio=$row['domicilio'];
            $rango=$row['rango'];
            $cantidad=$row['cantidad'];
            $comentario=$row['comentario'];
            $total=$row['total'];
            $datatable_data=$datatable_data."
                    <tr>
                        <td>$id</td>
                        <td>$fecha</td>
                        <td>$residente</td>
                        <td>$domicilio</td>
                        <td>$rango</td>
                        <td>$cantidad</td>
                        <td>$comentario</td>
                    </tr>
                ";
        }
        $full_table=$top_table.$datatable_data.$bottom_table;
        echo $full_table;
    }
}
?>


<script>
let table = new DataTable('#venta_mensual', {
    responsive: true,
    "pageLength": 50,
    order:[[0,'desc']]

});
$(document).ready( function () {$('#venta_mensual').DataTable();});

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
        let meses_array = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic']
        let semanas = ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']
        const date = new Date()
        let zona = date.getTimezoneOffset()
        let hora = date.getHours()
        let horas = zona/60
        let x
        if(zona!=480){
        horas = zona/60
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
      let fecha = semanas[weekday] + " " + day + " " + meses[month] + " " + year + " " + hora + ":" + ys + minutos
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
      conector.feed("1")
      conector.text("Reporte Mensual de Tickets")
      conector.text("Fecha:"+fecha)                        
      conector.feed("1")
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
                if(paso==0){var x = 5; var y =x-filaL}
                if(paso==1){var x = 19; var y =x-filaL}
                if(paso==2){var x = 7; var y =x-filaL}
                z = z.repeat(y)
                //conector.text("Tamaño de fila"+filaL+fila[paso]+"a"+z+"a")
                cadafila=cadafila+fila[paso]+z
            }
            conector.text(cadafila) 
            conector.text("--------------------------------")
        }
        conector.text("Total de venta : "+total)
        //conector.text("Total de Tickets : "+transacciones)
        conector.feed("4")
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