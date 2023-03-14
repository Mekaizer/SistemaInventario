<link href="./css/Fondos.css" rel="stylesheet" type="text/css">
    <div class="text-center caja-logo">
    <div class="text-center formulario-cabecera-logo">
    <div class="elements">
          
<?php
/*$Nombre es el nombre del objeto, $Codigo es su codigo, $Cantidad es la cantidad de productos, $Categoria corresponde al tipo de objeto, $Rol pertenece al nombre del admin
*/
setlocale(LC_ALL,"es_ES");    
date_default_timezone_set('America/Santiago');
$script_tz = date_default_timezone_get();
$dia =date('d-m-Y');
    include_once "./libreria/Dompdf/vendor/autoload.php";
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();
    $dompdf->set_paper("A4");
    require 'conexion.php';
    $Nombre = $_POST["NombreObjeto"];
    $Codigo = $_POST['Codigo'];
    $Codigo=strtoupper($Codigo);
    $Cantidad =$_POST['Cantidad'];
    $Categoria=$_POST['Categoria'];
    $RUT = $_POST['tipo'];
    $tipon="SELECT * FROM usuario WHERE Rut='$RUT'";
    $query=mysqli_query($conexion, $tipon);
    $muestra = mysqli_fetch_array($query);
    $RROll= $muestra["Tipo"];
    $NAME=$muestra["Nombre"];
    $area=$_POST["area"];
    $area=strtoupper($area);
//Se ingresan a la base de datos, nos aseguramos antes de que los valores sean no nulos
$sql = "SELECT * FROM producto WHERE Codigo = '$Codigo'";
$query = mysqli_query($conexion, $sql);

if(mysqli_num_rows($query) == 0){
    $insertar = " INSERT INTO producto VALUES('$Codigo','$Nombre','$Categoria')";
    $query = mysqli_query($conexion, $insertar);
} 
   #Si se encontro el producto o no, se debe crear en el inventario, entonces debemos ir a inventario y revisar que el producto no este en el area, recordar que aqui nos guiamos por el codigo, no el nombre del objeto
   $sql = "SELECT * FROM inventario WHERE CodProducto = '$Codigo' and Area ='$area'";
   $query = mysqli_query($conexion, $sql);
   if(mysqli_num_rows($query) == 0){
    $insertar = " INSERT INTO inventario VALUES('$Codigo','$Cantidad','$area')";
    $query = mysqli_query($conexion, $insertar);

    echo "<center>Se ha realizado con exito";
        
    $time = date('d-m-Y (h:s:m)');
    //Estas dos lineas guardan los cambios realizados
    $file = fopen("./txt/todocambios.txt", "a");
    if($Cantidad!=0){
    fwrite($file, "Se añadio el producto $Nombre, codigo: $Codigo, categoria: $Categoria con una cantidad de $Cantidad unidades, por el $RROll $NAME, Rut $RUT # $time " . PHP_EOL);
    }
    else{
    fwrite($file, "Se añadio el producto $Nombre codigo: $Codigo, categoria: $Categoria, por el $RROll $NAME, Rut $RUT # $time " . PHP_EOL);
    }
    fclose($file);
    $file = fopen("./txt/cambios.txt", "a");
    if($Cantidad!=0){
        fwrite($file, "Se añadio el producto $Nombre codigo: $Codigo, categoria: $Categoria con una cantidad de $Cantidad unidades, por el $RROll $NAME, Rut $RUT # $time " . PHP_EOL);
        }
        else{
        fwrite($file, "Se añadio el producto $Nombre codigo: $Codigo, categoria: $Categoria, por el $RROll $NAME, Rut $RUT # $time " . PHP_EOL);
        }
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
    
    $nombreDelDocumento = "Reporte de inventario hasta $dia .pdf";
    $bytes = file_put_contents("./pdfrespaldo/$nombreDelDocumento", $output);//Se usa la libreria dompdf
   }else{
    echo "<center>El producto ya existe en esta area";
   }
?>
<br>
<?php
if($RROll=="ADMIN"){
    ?>
    <a href="ingresoAdmin.php">Regresar al Menu</a> 
    <?php
}if($RROll=="SADMIN"){
    ?>
    <a href="ingresoSuperAdmin.php">Regresar al Menu</a> 
    <?php
}
if($RROll=="Bodeguero"){
    ?>
<a href="ingresoBodega.php">Regresar al Menu</a> 
<?php 
}?>
<br>
<img src="./css/imagenes/logo.png">