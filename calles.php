
<?php
include('auth.php');
    if($_SESSION['auth_key']>1){
    $id=$_GET['calle'];
    $query = "SELECT nombre, numerocasa, Domicilios.id, Statustarjetas.css FROM Domicilios LEFT JOIN Statustarjetas ON Statustarjetas.id = Domicilios.statusid where calleid=$id ORDER BY CAST(numerocasa AS UNSIGNED) ASC;";
    $result_tasks = mysqli_query($conex, $query);
    while ($row = mysqli_fetch_assoc($result_tasks)){
        $nombre=$row['nombre'];
        $id=$row['id'];
        $numerocasa=$row['numerocasa'];
        $css = $row['css'];
        echo "<button class='calles btn btn-icon-split btn-lg $css' onclick='imprimir($id)'>( $numerocasa ) $nombre</button>";
     
    }
    ?>

<script>
    function imprimir(str){
        var loc = window.location.pathname;
        var dir = loc.substring(0, loc.lastIndexOf('/'));
        window.location.href = dir +'/cal.php?domicilio='+str;
    }
</script>
<?php } ?>
