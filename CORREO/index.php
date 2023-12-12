<?php
require "vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre=$_POST['nombre'];

    // Ahora, $datos es un array que contiene los datos enviados en el cuerpo de la solicitud
    // Puedes acceder a cada elemento así:
    $conexion=new PDO("mysql:host=datos;dbname=cestero","root","root");
    $resultado=$conexion->prepare("SELECT * FROM cesta where nombre=:nombre");
    $resultado->bindParam(":nombre",$nombre,PDO::PARAM_STR);
    $resultado->execute();
    $objeto=null;

    while ($tuplas = $resultado->fetch(PDO::FETCH_OBJ)) {
        $nombre=$tuplas->nombre;
        $tipo=$tuplas->tipocesta;
        $objeto=new stdClass();
        $objeto->nombre=$nombre;
        $objeto->tipo=$tipo;
    }

    if ($objeto!==null){
        $contenido="";
        try {
            $client = new GuzzleHttp\Client();

            $res = $client->request('POST', 'http://cestero', [
                'form_params' => [
                    'tipo' => $tipo
            ]]);
            $contenido=$res->getBody();
        } catch (GuzzleHttp\Exception\RequestException $e) {
            // Manejar errores de Guzzle
            echo 'Error: ' . $e->getMessage();
            if ($e->hasResponse()) {
                echo 'Response: ' . $e->getResponse()->getBody()->getContents();
            }
        }
        if ($contenido==""){
    
        }else{
            $filename='/var/www/html/documento.pdf';
            file_put_contents($filename,$contenido);
            $mail = new PHPMailer();
            $mail->IsSMTP();
            // cambiar a 0 para no ver mensajes de error
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587;
            // introducir usuario de google
            $mail->Username = 'gdeniamoreno@gmail.com';
            // introducir clave
            $mail->Password = "pgsi cpbp bgqg tjzw";
            $mail->SetFrom($nombre.'@gmail.com', 'HOLA');
            // asunto
            $mail->Subject = "DOCKER";
            $mail->isHTML(true);
            // cuerpo
            $mail->MsgHTML("Examen");
            // adjuntos
            //$mail->addAttachment("hola.html");
            // destinatario
            $mail->AddAddress('gabrieldeniamoreno@gmail.com', "Test");

            $mail->addAttachment($filename, 'Docker');
            // enviar
            $resul = $mail->send();
            if (!$resul) {
                echo "Error" . $mail->ErrorInfo;
            } else {
                echo "El gmail ha sido enviado correctamente";
            }
        }
    }else{
        echo "Error al mandar el correo";
    }
}
?>
