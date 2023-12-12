<?php
    if ($_SERVER["REQUEST_METHOD"]=="POST"){
        require_once "./vendor/autoload.php";
        $nombre=$_POST['nombre'];
        $enviar=isset($_POST['enviar']);
        if ($enviar){
            if (strlen($nombre)>0){
                try {
                    $client = new GuzzleHttp\Client();
    
                    $res = $client->request('POST', 'http://correo', [
                        'form_params' => [
                            'nombre' => $nombre,
                        ]
                    ]);
                    echo $res->getBody();
                } catch (GuzzleHttp\Exception\RequestException $e) {
                    // Manejar errores de Guzzle
                    echo 'Error: ' . $e->getMessage();
                    if ($e->hasResponse()) {
                        echo 'Response: ' . $e->getResponse()->getBody()->getContents();
                    }
                }
            }else{
                echo "El nombre no puede estar vacío";
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <label>INTRODUZCA SU NOMBRE</label><br><br>
        <input type="text" name="nombre"><br><br>
        <input type="submit" name="enviar">
    </form>
</body>
</html>