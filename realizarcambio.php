<link href="./css/Fondos.css" rel="stylesheet" type="text/css">
    <div class="text-center caja">
    <div class="text-center formulario-cabecera-fuente">
    <div class="elements">
<?php
/*Una vez entregado la cantidad a remover o añadir, se debe asegurarse la operacion correspondiente
*/
require 'conexion.php';
include "./funciones/Comprobar.php";
$codigo = $_POST['codigo'];
$cantidad = $_POST['cantidad'];
$user = $_POST['usuario'];
$tipo = $_POST["type"];
date_default_timezone_set('America/Santiago');
$script_tz = date_default_timezone_get();
$time = time();
$time =  date('d-m-Y (h:s:m)', $time);
setlocale(LC_ALL,"es_ES");
$dia = time() + (7 * 24 * 60 * 60);
$dia =date(date("Y")."/".date("m")."/".date("d"), $dia);
include_once "./libreria/Dompdf/vendor/autoload.php";
use Dompdf\Dompdf;
//Aunque salga en rojo, la libreria lo respalda
$dompdf = new Dompdf();
$dompdf->set_paper("A4");
//Introduzca  lo que se quiera mostrar en pdf
$file = fopen("./txt/todocambios.txt", "a");

    //Se envia el codigo para buscarlo en  la base de datos para sacar y modificar sus datos
    $sql = "SELECT * FROM inventario WHERE CodProducto = '$codigo'";
    $res = mysqli_query($conexion, $sql);
    $muestra = mysqli_fetch_array($res);
    $cood="SELECT *FROM producto WHERE Codigo ='$codigo'";
    $aux = mysqli_query($conexion, $cood);
    $m1 = mysqli_fetch_array($aux);
    $nombre = $m1["NombreObjeto"];
if($tipo=="Bodeguero"){
    $Action = $_POST["action"];

    if($Action=="Add"){
        $stock = $muestra["Cantidad"]+$cantidad;
        $insertar = " UPDATE inventario SET Cantidad = $stock WHERE CodProducto ='$codigo'";
        $query = mysqli_query($conexion, $insertar);
        echo "<center>Se ha realizado con exito";
     
        fwrite($file, "Se añadio una cantidad de $cantidad unidad(es) del producto $codigo llamado $nombre. Fue añadido por $user, quien es $tipo.  # $time " . PHP_EOL);
        fclose($file);
        //Aqui solo se guardan los cambios que no tengan que ver con personas
        $file = fopen("./txt/cambios.txt", "a");
        fwrite($file, "Se añadio una cantidad de $cantidad unidad(es) del producto $codigo llamado $nombre. Fue añadido por $user, quien es $tipo.  # $time " . PHP_EOL);
        fclose($file);
        //Se guardara en un txt los datos de los objetos a pedir por el usuario
         $cambios = fopen("./txt/pdfe.txt", "a");
         fwrite($cambios,"$codigo $cantidad" . PHP_EOL);
         //con esto se genera el pdf
        ob_start();
        // Operaciones para generar el HTML que pueden ser llamadas a Bases de Datos, while, etc...
        include 'tablacambios.php';
        // Volcamos el contenido del buffer
        $html = ob_get_clean();
        $dompdf->load_html($html);
        $dompdf->render();
        $output = $dompdf->output();
        $nombreDelDocumento = "Reporte de inventario hasta $dia .pdf";
        $bytes = file_put_contents("./pdfrespaldo/$nombreDelDocumento", $output);//Se usa la libreria dompdf
    
    }else{

        $stock = $muestra["Cantidad"]-$cantidad;
        if($stock>=0){
            $insertar = " UPDATE inventario SET Cantidad = $stock WHERE CodProducto ='$codigo'";
            $query = mysqli_query($conexion, $insertar);
            echo "<center>Se ha realizado con exito";
         
            fwrite($file, "Se pidió una cantidad de $cantidad unidad(es) del producto $codigo llamado $nombre. Fue pedido por $user, quien es $tipo.  # $time " . PHP_EOL);
            fclose($file);
            //Aqui solo se guardan los cambios que no tengan que ver con personas
            $file = fopen("./txt/cambios.txt", "a");
            fwrite($file, "Se pidió una cantidad de $cantidad unidad(es) del producto $codigo llamado $nombre. Fue pedido por $user, quien es $tipo.  # $time " . PHP_EOL);
            fclose($file);
            //Se guardara en un txt los datos de los objetos a pedir por el usuario
             $cambios = fopen("./txt/pdf.txt", "a");
             fwrite($cambios,"$codigo $cantidad" . PHP_EOL);
            //con esto se genera el pdf
            ob_start();
            // Operaciones para generar el HTML que pueden ser llamadas a Bases de Datos, while, etc...
            include 'tablacambios.php';
            // Volcamos el contenido del buffer
            $html = ob_get_clean();
            $dompdf->load_html($html);
            $dompdf->render();
            $output = $dompdf->output();
            $nombreDelDocumento = "Reporte de inventario hasta $dia .pdf";
            $bytes = file_put_contents("./pdfrespaldo/$nombreDelDocumento", $output);//Se usa la libreria dompdf
        }else{
            echo "<center>No hay stock suficiente";
        }

    }
    ?>
    <br>
    <a href="ingresoBodega.php">Regresar al inventario</a>
    <br>
    <img src="./css/imagenes/logo.png">
    <?php
}
else{
    $stock = $muestra["Cantidad"]-$cantidad;
    if($stock>=0){
        $insertar = " UPDATE inventario SET Cantidad = $stock WHERE CodProducto ='$codigo'";
        $query = mysqli_query($conexion, $insertar);
        echo "<center>Se ha realizado con exito";
        fwrite($file, "Se pidió una cantidad de $cantidad unidad(es) del producto $codigo llamado $nombre. Fue pedido por $user, quien es $tipo.  # $time " . PHP_EOL);
        fclose($file);
        //Aqui solo se guardan los cambios que no tengan que ver con personas
        $file = fopen("./txt/cambios.txt", "a");
        fwrite($file, "Se pidió una cantidad de $cantidad unidad(es) del producto $codigo llamado $nombre. Fue pedido por $user, quien es $tipo.  # $time " . PHP_EOL);
        
        //Se guardara en un txt los datos de los objetos a pedir por el usuario
        $cambios = fopen("./txt/pdf.txt", "a");
        fwrite($cambios,"$codigo $cantidad " . PHP_EOL);
        //con esto se genera el pdf
        ob_start();
        // Operaciones para generar el HTML que pueden ser llamadas a Bases de Datos, while, etc...
        include 'tablacambios.php';
        // Volcamos el contenido del buffer
        $html = ob_get_clean();
        $dompdf->load_html($html);
        $dompdf->render();
        $output = $dompdf->output();
        $nombreDelDocumento = "Reporte de inventario hasta $dia .pdf";
        $bytes = file_put_contents("./pdfrespaldo/$nombreDelDocumento", $output);//Se usa la libreria dompdf

    }
    else{
        echo "<center>No hay stock suficiente";
    }
    fclose($file);
    fclose($cambios);
    ?>
    <br>
    <a href="ingresoUsuario.php">Regresar al inventario</a>
    <br>
    <img src="./css/imagenes/logo.png">
    <?php
}


?>


