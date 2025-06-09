<?php
require_once 'auth.php';

if (isset($_SESSION['auth_key']) && $_SESSION['auth_key'] > 1) {
    $query = "SELECT id, calle FROM Calles";
    $color = 'success';
    $botones = [];

    $result_tasks = mysqli_query($conex, $query);
    while ($row = mysqli_fetch_assoc($result_tasks)) {
        $calle = htmlspecialchars($row['calle']);
        $id = (int) $row['id'];
        $botones[] = "<button class='calles btn btn-$color btn-icon-split btn-lg' onclick='imprimir($id)'>$calle</button>";
    }

    $botones_laterales = implode('', $botones);
    $count = count($botones);
    $btn_center_height = ($count * 119) - 3;

    echo "
    <div class='row'>
        <div class='col-5 mobile_view'>$botones_laterales</div>
        <div class='col-2 mobile'>
            <button class='calles-centro calles btn btn-$color btn-icon-split btn-lg' style='padding-top: 40px;height: {$btn_center_height}px;' onclick='imprimir()'>
                NUEVO RESIDENTE
            </button>
        </div>
        <div class='col-5 mobile'>$botones_laterales</div>
    </div>";
} else {
    $host = $_SERVER['HTTP_HOST'];
    $ruta = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $url_auth = "http://$host$ruta/auth.php";
    echo "<script type='text/javascript'>window.location.replace('$url_auth');</script>";
}
?>

<style>
    .btn:not(:disabled):not(.disabled) {
    align-items: center;
}
</style>

<script>
    function imprimir(str){
        var loc = window.location.pathname;
        var dir = loc.substring(0, loc.lastIndexOf('/'));
        if(str){
            window.location.href = dir +'/calles.php?calle='+str;
        }
        else {
            window.location.href = dir +'/nuevo.php';
        }
    }
</script>