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
$area=$_SESSION["Area"];
echo "<center><h2>Bienvenido $user usted es  $tipo del Area de $area </h2>";
include("conexion.php");
$productos = "SELECT * from  producto"; 

?>


<head>

<title>Menu Bodeguero</title> 
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
<table class="table">
      <thead class="table-info"> 
        
            <tr>
                <th>Codigo</th>               
                <th>NombreObjeto</th>
                <th>Cantidad</th>
                <th>Categoría</th>
                <th></th>
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
        <tr>
        <tbody id="myTable">
            <!--Se muestra los datos de cada producto en la base de datos -->
            
            <?php $stock=$row["Cantidad"] ?><name="stock">
            <td><?php echo $cod ?></td>
            <td><?php echo $rowP["NombreObjeto"] ?></td>
            <td><?php echo $stock ?></td>
            <td><?php echo $rowP["Categoría"] ?></td>
            <form  method="post" action="cambiarstock.php">
            <td><button type="submit" name="code" value="<?= isset($cod)?htmlspecialchars($cod ):'' ?> "> Añadir Stock</button></td>
            <input type="hidden" name="tipo" value="<?= isset($tipo)?htmlspecialchars($tipo):'' ?>">
            <input type="hidden" name="user" value="<?= isset($user)?htmlspecialchars($user):'' ?>">
            <?php
            $accion = "Add";
            ?>
            <input type="hidden" name="accion" value="<?= isset($accion)?htmlspecialchars($accion):'' ?>">
            </form>
            
            <form  method="post" action="cambiarstock.php">
            <td><button type="submit" name="code" method="post"action="index.php" value="<?= isset($cod)?htmlspecialchars($cod ):'' ?> "> Realizar pedido</button></td>
            <input  type="hidden" name="tipo" value="<?= isset($tipo)?htmlspecialchars($tipo):'' ?>">
            <input type="hidden" name="user" value="<?= isset($user)?htmlspecialchars($user):'' ?>">
            <?php
            $accion = "Sub";
            ?>
            <input type="hidden" name="accion" value="<?= isset($accion)?htmlspecialchars($accion):'' ?>">
          </form>
        </tr>
    </tbody>
        <?php }  
        mysqli_free_result($muestra);?> 
    
  
    </table>
    </div>
    </div> 
    </div> 
    
  <!--Se pide al ADMIN  agregar los datos del producto para añadir a la base de datos, OJO, solo añade, no agrega ni resta stock
Luego llama al php guardarProducto para realizar las operaciones-->
  <div class="column"><h2>Ingresar Producto</h2>
    <form  method="post" action="guardarProducto.php">
      <div class="form-group">
      <div class="col-md-6">
      <label class="control-label" for="name">Nombre del objeto</label>
      <input name="NombreObjeto" class="form-control" type="text" required>
      </div>
      </div>
      <br>  
      <div class="form-group">
      <div class="col-md-6">
      <label class="control-label" for="code">Codigo del producto</label>
      <input name="Codigo" class="form-control"  type="text"required>
      </div>
      </div>
      <br>  
      
      <div class="form-group">
      <div class="col-md-6">
      <label class="control-label" for="stock">Cantidad a añadir</label>
      <input name="Cantidad" class="form-control" type="number"required min='0'>
      </div>
      </div>
      <br>  
                          
      <div class="form-group">
      <div class="col-md-6">
      <label class="control-label" for="category">Categoria del objeto</label>
      <input name="Categoria" class="form-control" type="text"required>
      </div>
      </div>
          
      <br>
      <div class="form-group">
      <div class="col-md-12">
      <button type="submit" class="btn btn-primary btn-lg btn-block info">Agregar</button>
      </div>
      </div>     

      <!--Esta linea sirve para dar datos que no se piden. pero existen y se quieren pasar a otra pagina -->
      <input type="hidden" name="tipo" value="<?= isset($_SESSION['Rut'])?htmlspecialchars($_SESSION['Rut']):'' ?>"/>
      <input type="hidden" name="area" value="<?= isset($_SESSION['Area'])?htmlspecialchars($_SESSION['Area']):'' ?>"/>

    </form>
    </div>


  

  <div class="column"><h2>Remover Producto</h2>
  <!--Se pide al ADMIN  ingresar el codigo del producto para remover de la base de datos-->
      <form  method="post" action="RemoverProducto.php">
        
        <div class="form-group">
        <div class="col-md-6">
        <label class="control-label" for="code">Codigo del producto</label>
        <input name="EliminaP" class="form-control"  type="text"required>
        </div>
        </div>
        <br>
  
        <div class="form-group">
        <div class="col-md-12">
        <button type="submit" class="btn btn-primary btn-lg btn-block info">Eliminar</button>
        </div>
        </div>     
   
        <!--Esta linea sirve para dar datos que no se piden. pero existen y se quieren pasar a otra pagina -->
        <input type="hidden" name="rut" value="<?= isset($_SESSION['Rut'])?htmlspecialchars($_SESSION['Rut']):'' ?>"/>
        <input type="hidden" name="area" value="<?= isset($_SESSION['Area'])?htmlspecialchars($_SESSION['Area']):'' ?>"/>
        
        
      </form>
      </div>
        <br>
        <div >
        <h2>Mostrar Cambios</h2>
        <br>
        <form  method="post" action="MostrarCambios.php">
        <div class="form-group">
        <div class="col-md-12">
         
        <button type="submit" class="btn btn-primary btn-lg btn-block info">Mostrar</button>
        <input type="hidden" name="tipo" value="<?= isset($_SESSION['Tipo'])?htmlspecialchars($_SESSION['Tipo']):'' ?>"/>
        </div>
        </div>     
      </form>
    </div>
    <br>
   
    <div>
    <h3>Ver Datos Usuario</h3>
    <br>
    <form  method="post" action="Password.php">
      <button type="submit" class="btn btn-primary btn-lg btn-block info">Mostrar</button>
      <input type="hidden" name="rut" value="<?= isset($rut)?htmlspecialchars($rut):'' ?>">
    </form>
      <br>
    </div>
    <br> <br>  <br> <br>  <br> <br>
      
      <div class="topnav">
 
<th><a href="pasofinalD.php"> Cerrar Sesión </a></th> 
<th> <a href="EditarPDFS.php">Editar PDF Salida</a> </th> 
<th> <a href="EditarPDFE.php">Editar PDF Entrada</a> </th> 
<th> <a href="pasofinalA.php">Crear PDF Salida </a> </th> 
<th> <a href="pasofinalC.php">Crear PDF Entrada </a> </th>

                    
</div>
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
</body>