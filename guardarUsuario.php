<link href="./css/Fondos.css" rel="stylesheet" type="text/css">
    <div class="text-center caja-logo">
    <div class="text-center formulario-cabecera-logo">
    <div class="elements">
          

<?php
/*$Nombre, $Rut, $Rol, $Pass son los datos para añadir un nuevo usuario. $Res es el nombre del responsable
*/
include "./funciones/Comprobar.php";
setlocale(LC_ALL,"es_ES");
date_default_timezone_set('America/Santiago');
$dia =date('Y-m-d h:s:m');
$script_tz = date_default_timezone_get();
include_once "./libreria/Dompdf/vendor/autoload.php";
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->set_paper("A4");
require 'conexion.php';
$Nombre = $_POST["Nombre"];
$Rut = $_POST['Rut'];
$Rol =$_POST['Rol'];
$Pass=$_POST['Pass'];
$Res = $_POST['Responsable'];
$Area=$_POST["Area"];
$Sarea=$_POST["SArea"];
$type=$_POST["sec"];
$Rut = validarrut($Rut);
$Pase = validar($Pass);
if(strcmp($Rut,"NO")!=0){
    if($Pase){
        //Se ingresan a la base de datos, ya esta asegurado de que los valores sean no nulos pero ahora comprobamos que no exista el rut
        $sql = "SELECT * FROM usuario WHERE Rut = '$Rut'";
        $query = mysqli_query($conexion, $sql);
        if(mysqli_num_rows($query) == 0){
            if($Sarea!=null or $Sarea!=""){
                $Sarea=strtoupper($Sarea);
                $insertando = " INSERT INTO usuario VALUES('$Rut','$Rol','$Nombre','$Pass','$Sarea')";
            }else{
                $insertando = " INSERT INTO usuario VALUES('$Rut','$Rol','$Nombre','$Pass','$Area')";
            }
        $query = mysqli_query($conexion, $insertando);
        echo "<center>Se ha realizado con exito";
        $time = date('d-m-Y (h:s:m)');
        //Estas dos lineas guardan los cambios realizados
        $file = fopen("./txt/todocambios.txt", "a");
        fwrite($file, "Se añadio el usuario $Nombre, $Rut que será $Rol y su contraseña es $Pass, el cual fue añadido por $Res # $time " . PHP_EOL);
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
} 
else {
    echo '<center>Reingrese nuevamente';
}
    }else {
        echo '<center>Reingrese nuevamente';
    }
}else {
    echo '<center>Reingrese nuevamente';
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