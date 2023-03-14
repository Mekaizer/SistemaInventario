<link href="./css/Fondos.css" rel="stylesheet" type="text/css">
    <div class="text-center caja-nologo">
    <div class="text-center formulario-cabecera-nologo">
    <div class="elements">
          

<?php
setlocale(LC_ALL,"es_ES");    
date_default_timezone_set('America/Santiago');
$script_tz = date_default_timezone_get();
$dia =date('d-m-Y');
include_once "./libreria/Dompdf/vendor/autoload.php";
use Dompdf\Dompdf;
//Aunque salga en rojo, la libreria lo respalda
$dompdf = new Dompdf();
$dompdf->set_paper("A4");
require 'conexion.php';
//$Codigo es el codigo del producto a buscar, $Res el el nombre de la persona responsable a remover
$Codigo = $_POST["EliminaP"];
$Codigo=strtoupper($Codigo);
$Res = $_POST["rut"];
$tipon="SELECT * FROM usuario WHERE Rut='$Res'";
$query=mysqli_query($conexion, $tipon);
$muestra = mysqli_fetch_array($query);
$RROll= $muestra["Tipo"];
$NAME=$muestra["Nombre"];
$sql = "SELECT * FROM producto WHERE Codigo = '$Codigo'";
$query = mysqli_query($conexion, $sql);
$muestra = mysqli_fetch_array($query);
$inventario ="SELECT * FROM inventario WHERE CodProducto='$Codigo'";
$query2= mysqli_query($conexion, $inventario);
$muestra2 = mysqli_fetch_array($query2);
//Se asegura que se encuentre el producto
if($muestra!=NULL){
    //$Code es el codigo del producto a remover y $nombre es su nombre
    $cantidad=$muestra2["Cantidad"];
    if($cantidad==0){ 
         #comprobar si esta en boleta, para evitar quitarlo
         include "./funciones/Comprobar.php";    
         $pdf=ExisteBoleta($Codigo,"./txt/pdf.txt");
         $pdfe=ExisteBoleta($Codigo,"./txt/pdfe.txt");
         if($pdf==True or $pdfe==True){
             echo "<center>Hay productos en una boleta"; 
         }
         else{   
        $Code = $muestra["Codigo"];
        //Se remueve de la base de datos y se guarda los cambios
        $remove = "DELETE FROM inventario WHERE CodProducto = '$Codigo'";
        $Nombre = $muestra["NombreObjeto"];
        $query = mysqli_query($conexion, $remove);
        echo "<center>Se ha realizado con exito";
        date_default_timezone_set('America/Santiago');
        $time = date('d-m-Y (h:s:m)');
        //Estas dos lineas guardan los cambios realizados
        $file = fopen("./txt/todocambios.txt", "a");
        fwrite($file, "Se removió el producto $Nombre, codigo: $Code. Fue removido por $NAME; Rut $Res, quien es $RROll #  $time " . PHP_EOL);
        fclose($file);
        $file = fopen("./txt/cambios.txt", "a");
        fwrite($file, "Se removió el producto $Nombre, codigo: $Code. Fue removido por $NAME; Rut $Res, quien es $RROll #  $time " . PHP_EOL);
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
}

else {
    echo "<center>Todavia quedan productos  ";
}

}else {
    echo "<center>No se encontro el producto en la base de datos  ";
}
?>
<br>
<br>
<a href="ingresoSuperAdmin.php">Regresar al Menu</a> 