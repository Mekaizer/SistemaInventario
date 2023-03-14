<link href="./css/Fondos.css" rel="stylesheet" type="text/css">
    <div class="text-center caja-nologo">
    <div class="text-center formulario-cabecera-nologo">
    <div class="elements">
          

<?php

setlocale(LC_ALL,"es_ES");
date_default_timezone_set('America/Santiago');
$dia =date('Y-m-d h:s:m');
$script_tz = date_default_timezone_get();
include_once "./libreria/Dompdf/vendor/autoload.php";
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->set_paper("A4");
require 'conexion.php';
//$Codigo corresponde al rut de la persona a remover y $Res el nombre de la persona responsable a remover
$Codigo = $_POST["Elimina"];
$Codigo=strtoupper($Codigo);
$Res = $_POST["nombre"];
$sql = "SELECT * FROM usuario WHERE Rut = '$Codigo'";
$query = mysqli_query($conexion, $sql);
$muestra = mysqli_fetch_array($query);
$type=$_POST["sec"];
//Se asegura que se encuentre el rut y que no sea el del usuario
if($muestra!=NULL){
    //$Rut es el rut del usuario a remover y $nombre es su nombre
    $Rut = $muestra["Rut"];
    $nombre = $muestra["Nombre"];
    if($Res!=$nombre){
        //Se remueve de la base de datos y se guarda los cambios
        $remove = "DELETE FROM usuario WHERE Rut = '$Codigo'";
        $Nombre = $muestra["Nombre"];
        $query = mysqli_query($conexion, $remove);
        echo "<center>Se ha realizado con exito";
        date_default_timezone_set('America/Santiago');
        $script_tz = date_default_timezone_get();
        $time = date('d-m-Y (h:s:m)');
        //Estas dos lineas guardan los todos cambios realizados
        $file = fopen("./txt/todocambios.txt", "a");
        fwrite($file, "Se removió el usuario $Nombre, $Rut. Fue removido por $Res # $time " . PHP_EOL);
        fclose($file);
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
        echo "<center>No se puede eliminar usted mismo";
    }

} 
else {
    echo '<center>No se encontro la Persona';
}

if($type=="SADMIN"){
    ?>
    <br>
    <a href="ingresoSuperAdmin.php">Regresar al Menu</a>
    <br>
    <?php 
    }
    else{
        ?>
        <br>
        <a href="ingresoAdmin.php">Regresar al Menu</a>
        <br>
        <?php 
        }
        ?>
    
    <img src="./css/imagenes/logo.png">