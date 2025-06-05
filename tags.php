
<?php
    include('auth.php');
    $domicilioid=$_GET['domicilio'];
    $accion="cal.php?domicilio=$domicilioid";
    $campos = 
            campotextarea("tags","tags",10).
            campoinput("cantidad","text","cantidad","CANTIDAD",0).
            campoinput("comentario","text","comentario","COMENTARIO","UPDT").
            campoinput("domicilioid","text","domicilioid","",$domicilioid,0).
            campoinput("domicilio","text","domicilio","",getDombyId($domicilioid,$conex),0).
            camposubmit("imprimir","btn_tags","REGISTRAR TAGS"); 
    $form = crearForm(12,$accion,"fraccform",$campos);
    echo "<div class='container fluid'>$form</div>";
    unset($domicilioid);
?>

<style>
    .form-label{
        text-transform: uppercase;
        width: 100%;
        color: black;
        font-size: 1.3rem;
    }

    .form-submit-custom{
        color: black !important;
    }
</style>
<script>

async function imprimir(){
    let nombreImpresora = "POS58 Printer";
    let api_key = "3100e271-22bc-4e5c-803b-e34b99bc4ff2";
    let tags =document.getElementById("tags");
    let domicilio =document.getElementById("domicilio");
    let cantidad =document.getElementById("cantidad");
    let comentario =document.getElementById("comentario");
    domicilio =domicilio.value;
    cantidad =cantidad.value;
    comentario =comentario.value;
    let tags_format = "";
    tags = tags.value.split('\n');
    console.log("tags");
    console.log(tags);
    let check_duplicate_in_array = (input_array) => {
        let duplicate_elements = []
        let duplicate_elements2 = []
        for (num in input_array) {
            for (num2 in input_array) {
                if (num === num2) {
                if (input_array[num] === input_array[num2]) {
                        duplicate_elements2.push(input_array[num]);
                        console.log("duplicate_elements2");
                        console.log(duplicate_elements2);
                        continue;
                    }
                }
                else {
                    if (input_array[num] === input_array[num2]) {
                        duplicate_elements.push(input_array[num]);
                        console.log("duplicate_elements2");
                        console.log(duplicate_elements2);
                    }
                }
            }
        }
        return [...new Set(duplicate_elements2)];
    }
    tags =check_duplicate_in_array(tags);
    

    let meses_array = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago',,'Sep','Oct','Nov','Dic']
    let semanas = ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']
    const date = new Date()
    let zona = date.getTimezoneOffset()
    let hora = date.getHours()
    if(zona==480){}else{
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
    //conector.text("F. ")
    conector.text("--------------------------------")
    conector.text("Comprobante de")
    conector.text("adquisicion de tags")
    conector.text("Dom:"+domicilio)
    conector.feed("1")
    conector.text("Descripcion             Importe")
    conector.text("--------------------------------")
    tags.forEach(format);
    conector.feed("1")
    conector.text("Importe a pagar:      $"+cantidad*(tags.length)+".00")
    conector.text("--------------------------------")
    conector.fontsize("1.6")
    conector.text(comentario)
    conector.feed("2")
    //conector.qr("https://villanovenasur.com")
    conector.cut("0") 
    
    function format(item, index){
        largo = item.length
        console.log("item");
        console.log(largo);
        console.log(item);
        switch(largo){
            case 0: 
                mensaje = "La linea esta vacia";
                console.log("mensaje");
                console.log(mensaje);
                break;
            case 6:
            case 7:
            case 8:
                tag = item.toString();
                conector.text("tag-"+(index+1)+": "+tag+"        $ "+cantidad+".00")
                break;
            case 24:
                tag = item.slice(18,25);
                tag = parseInt(tag,16);
                tag = tag.toString();
                console.log((index+1)+": "+item+" tag: "+tag);
                conector.text("tag-"+(index+1)+": "+tag+"        $ "+cantidad+".00")
        }

        index = index + 1;

    }
    const resp = await conector.imprimir(nombreImpresora, api_key);
    if (resp === true) {} 
    else {
      console.log("Problema al imprimir: "+resp);
    }

    
}
</script>