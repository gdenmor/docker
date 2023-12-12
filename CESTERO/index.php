<?php
    require_once "./vendor/autoload.php";
    use Dompdf\Dompdf;
    if ($_SERVER["REQUEST_METHOD"]=="POST"){
            $tipo=$_POST['objeto'];
            $pdfprovisional=new Dompdf();
            $html='<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
            </head>
            <body>';
            $html.='<p>'.$tipo.'</p>';
            if ($tipo=="con jamon"){
                $html.='<img src="imagen.jpg">';
                $pdfprovisional->getOptions()->setChroot("/var/www/html/imagen.jpg");
            }
            $html.='</body>
            </html>';
            $pdfprovisional->setPaper("A4", "portrait");
            # Cargamos el contenido HTML.
            $pdfprovisional->loadHtml($html);

            # Renderizamos el documento PDF.
            $pdfprovisional->render();

            # Creamos un fichero
            echo $pdfprovisional->output();
    }

?>