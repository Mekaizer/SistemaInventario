<!DOCTYPE html>
<html lang="es">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<link href="./css/FondoMenu.css" rel="stylesheet" type="text/css">
<div class="text-center formulario-fuente">
<img src="./css/imagenes/logo.png">

<?php

session_start();
$rut = $_SESSION["Rut"];
$user=$_SESSION['Nombre'];
$tipo= $_SESSION['Tipo'];
$area=$_SESSION['Area'];
echo "<center><h2>Bienvenido $user usted es  $tipo del area de $area</h2>";

include("conexion.php");
$productos = "Select * from  producto"; 

?>


<head>
<!--El usuario se encarga de pedir productos, los productos no pueden llegar a tener stock/cantidad menor a 0 -->
<title>Menu Usuario</title> 
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
</head>
<body>
<br>
<h2>Todos los Productos</h2>
<input class="form-control" id="myInput" type="text"  style="width: 550px" placeholder="Escriba aqui codigo, nombre o categoria del producto a buscar">
  <br>
<div id="container">
<div class="container">
<div class="table-responsive">
<table class="table" border="1">

      <thead class="table-info"> 
        
            <tr>
                <th>Codigo</th>               
                <th>NombreObjeto</th>
                <th>Cantidad</th>
                <th>Categoría</th>
                <th></th>
                
        </tr>
        </thead>
        <form  method="post" action="cambiarstock.php">
        <?php 
        $inventario="SELECT * FROM  inventario WHERE Area='$area'";
        $muestra = mysqli_query($conexion,$inventario);
    while ($row = mysqli_fetch_assoc($muestra)) {
        $cod=$row["CodProducto"];
        $producto = "SELECT * FROM  producto WHERE Codigo ='$cod'";
        $pro= mysqli_query($conexion,$producto);
        $rowP = mysqli_fetch_assoc($pro);
        ?>
        <tbody id="myTable">
        <tr>
            
            <!--Se muestra los datos de cada producto en la base de datos -->
            
            <?php $stock=$row["Cantidad"] ?><name="stock">
            <td><?php echo $cod ?></td>
            <td><?php echo $rowP["NombreObjeto"] ?></td>
            <td><?php echo $stock ?></td>
            <td><?php echo $rowP["Categoría"] ?></td>
            <td><button type="submit" name="code" value="<?= isset($cod)?htmlspecialchars($cod ):'' ?> "> Realizar pedido</button></td>
            <input type="hidden" name="tipo" value="<?= isset($tipo)?htmlspecialchars($tipo):'' ?>">
            <input type="hidden" name="user" value="<?= isset($user)?htmlspecialchars($user):'' ?>">
            <?php
            $accion = "Add";
            ?>
            <input type="hidden" name="accion" value="<?= isset($accion)?htmlspecialchars($accion):'' ?>">
            
        </tr>
        </tr>
        </tr>
        <?php }  mysqli_free_result($muestra);?> 
        </table>
    </div>
    </div> 
    </div>      </form>
    <br>
    <br>
    <h3>Ver Datos</h3>
    <form  method="post" action="Password.php">
      <button type="submit" class="btn btn-primary btn-lg btn-block info">Mostrar</button>
      <input type="hidden" name="rut" value="<?= isset($rut)?htmlspecialchars($rut):'' ?>">
    </form>
      <br> <br>
    </tbody>


<div class="topnav">
            
    <th><a href="pasofinalB.php"> Cerrar Sesión </a></th>
    <th> <a href="EditarPDFS.php">Editar PDF </a> </th> 
    <th> <a href="pasofinalA.php">Crear pdf </a> </th>       
    
</div>

   
      





</body>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>