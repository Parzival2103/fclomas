<?php
if (!isset($_FILES['imagen'])) {
    echo "No se envió ninguna imagen.";
    exit;
}

$imagen_tmp = $_FILES['imagen']['tmp_name'];
$nombre_original = $_FILES['imagen']['name'];

$url_raspberry = 'https://81c3-2806-290-880a-8426-100a-78-6acc-16.ngrok-free.app/procesar'; // Reemplaza si cambió

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url_raspberry,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => [
        'imagen' => new CURLFile($imagen_tmp, mime_content_type($imagen_tmp), $nombre_original)
    ],
    CURLOPT_TIMEOUT => 60
]);

$respuesta = curl_exec($curl);

if (curl_errno($curl)) {
    $error_msg = curl_error($curl);
    echo "Error CURL: $error_msg";
} else {
    echo $respuesta;
}
curl_close($curl);
