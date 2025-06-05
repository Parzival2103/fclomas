<?php
include 'functions.php';

if (!isset($_GET['desde']) || !isset($_GET['hasta'])) {
    echo json_encode([]);
    exit;
}

$desde = $_POST['desde'];
$hasta = $_POST['hasta'];

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
            WHERE DATE_FORMAT(Tickets.fechaticket,'%Y-%m-%e') BETWEEN '$desde' AND '$hasta'
            ORDER BY Tickets.fechaticket ASC;";

$datatable_id="venta_diaria";

$top_table="
<div class='row'>
<div class='card shadow mb-4'>
    <div class='card'>
        <div class='card-body'>
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
    $nombre_usuario=$row['nombre'];
    $residente=$row['residente'];
    $domicilio=$row['domicilio'];
    $rango=$row['rango'];
    $cantidad=$row['cantidad'];
    $comentario=$row['comentario'];
    $total=$row['total'];
    $datatable_data=$datatable_data."
            <tr>
                <td>$id</td>
                <td>$nombre_usuario</td>
                <td>$residente</td>
                <td>$domicilio</td>
                <td>$rango</td>
                <td>$cantidad</td>
                <td>$comentario</td>
            </tr>
        ";
}
$full_table=$top_table.$datatable_data.$bottom_table;
echo json_encode($full_table.$query);

?>
