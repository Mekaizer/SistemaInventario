<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

  <link href="./css/FondoMenuAdmin.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css">
<center><img src="./css/imagenes/logo.png">


<?php
session_start();
$rut = $_SESSION["Rut"];
$user=$_SESSION['Nombre'];
$tipo= $_SESSION['Tipo'];
$area=$_SESSION['Area'];
echo "<center><h2>Bienvenido $user usted es  $tipo del Area de $area </h2>";
include("conexion.php");

$user = "SELECT * FROM usuario WHERE Area='$area'";
?>

<!DOCTYPE html>
<html lang="es">
  <head>
<!--El admin se encarga de añadir gente nueva y productos, los productos pueden venir con minimo de 0 stock
si se desea añadir mas stock se debe ingresar como bodeguero -->
<title>Menu Admin</title> 
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
</head>
<body>
                

<!--Se muestra la tabla -->
<h2>Todas las Persona</h2>
<input class="form-control" id="myInput" type="text"  style="width: 550px" placeholder="Escriba aqui nombre, rut, rol o area del usuario a buscar">
  <br>
<div class="container">
  <div class="table-responsive">
  <table class="table" border="1">
        <thead class="table-info"> 
        <tr> 
        <th>Nombre</th>               
        <th>Rut</th>
        <th>Rol de persona</th>
        </tr> 
        </thead>
      

        <?php  $muestra2 = mysqli_query($conexion,$user);
        
        while ($row2 = mysqli_fetch_assoc($muestra2)) {?>
      <tbody id="myTable">
          <tr>
            <div id="container">
          <!--Se muestra las filas con los datos de cada producto en la base de datos -->
          <td><?php echo $row2["Nombre"] ?></td>
          <td><?php echo $row2["Rut"] ?></td>
          <td><?php echo $row2["Tipo"] ?></td>
          </tr>
          <?php 
        }  mysqli_free_result($muestra2);?> 

      </div>
  </table>
  </div>
  </div> 
  </tbody>
    <br><br>

<!--El ADMIN  es el unico en añadir mas gente al sistema, para ello debe agregar los datos del nuevo usuario-->






<div class="column">
<h2>Ingresar Nueva Persona</h2>
    <form  method="post" action="guardarUsuario.php">

            
    <div class="form-group">
                <div class="col-md-6">
                  <label class="control-label" for="name">Nombre del usuario</label>
                  <input name="Nombre" class="form-control" type="text" required>
                  </div>
                </div>
      
              <div class="form-group">
                  <div class="col-md-6">
                    <label class="control-label" for="Rut">Rut del usuario</label>
                    <input name="Rut" class="form-control" placeholder="Con punto y guion" type="text" required>
                  </div>
                </div>
      
      
                <div class="form-group">
                  <div class="col-md-6">
                    <!-- value sirve para traspasar el nombre a la hora de crear el usuario -->
                    <label class="control-label" for="Rol">Rol del usuario </label>
                   
                    <br />

                    <input name="Rol" for="rol" value="ADMIN" type="radio"  required/> ADMIN

                    <br />

                    <input name="Rol"for="rol" value="Usuario" type="radio" required/> Usuario

                    <br />

                    <input name="Rol" for="rol" value="Bodeguero" type="radio"  required/> Bodeguero
                    <br />
    
                </div>
                          
                <div class="form-group">
                  <div class="col-md-6">
                  Contraseña
                    <label class="control-label" for="Pass"></label>
                    <input name="Pass" class="form-control"placeholder="Debe tener una mayúscula, minúscula y número" type="text" required>
                  </div>
                </div>
      
                <br>
                <div class="form-group">
                  <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-lg btn-block info">Agregar</button>
                  </div>
                </div>     
    
            <!--Esta linea sirve para dar datos que no se piden. pero existen y se quieren pasar a otra pagina -->
            <input type="hidden" name="Responsable" value="<?= isset($_SESSION['Rut'])?htmlspecialchars($_SESSION['Rut']):'' ?>"/>
                <input type="hidden" name="Area" value="<?= isset($area)?htmlspecialchars($area):'' ?>"/>
                <input type="hidden" name="sec" value="<?= isset($area)?htmlspecialchars($area):'' ?>"/>
                
                <input type="hidden" name="SArea" value="<?= isset($area)?htmlspecialchars($area):'' ?>"/>
          </form>

          </div>
          
</div>

   <div class="column1">
    <h2>Remover Persona</h2>
  <!--Se pide al ADMIN  ingresar el rut para remover la persona de la base de datos-->
  <form  method="post" action="RemoverPersona.php">

  <div class="form-group">
      <div class="col-md-6">
        <label class="control-label" for="code">Rut de la persona</label>
        <input name="Elimina" class="form-control"  type="text"required>
      </div>
    </div>

    <br>
    <div class="form-group">
      <div class="col-md-12">
        <button type="submit" class="btn btn-primary btn-lg btn-block info">Eliminar</button>
      </div>
    </div>     

<!--Esta linea sirve para dar datos que no se piden. pero existen y se quieren pasar a otra pagina -->
<input type="hidden" name="nombre" value="<?= isset($_SESSION['Rut'])?htmlspecialchars($_SESSION['Rut']):'' ?>"/>
<input type="hidden" name="sec" value="<?= isset($_SESSION['Area'])?htmlspecialchars($_SESSION['Area']):'' ?>"/>

</form>    
<h2>Actualizar Persona</h2>
  <form  method="post" action="ActualizarPersona.php">
    <br>
    <div class="form-group">
      <div class="col-md-12">
        <button type="submit" class="btn btn-primary btn-lg btn-block info">Buscar</button>
      </div>
    </div>     

<!--Esta linea sirve para dar datos que no se piden. pero existen y se quieren pasar a otra pagina -->
<input type="hidden" name="nombre" value="<?= isset($_SESSION['Rut'])?htmlspecialchars($_SESSION['Rut']):'' ?>"/>
<input type="hidden" name="area" value="<?= isset($_SESSION['Area'])?htmlspecialchars($_SESSION['Area']):'' ?>"/>


</form>
    </div>
    <br><br><br>

<!--Se muestra la tabla -->
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>


<h2>Todos los Productos</h2>

<input class="form-control" id="InputP" type="text"  style="width: 650px" placeholder="Escriba aqui codigo, nombre, categoria o area del producto a buscar">
  <br>
<div class="container">

  <div class="table-responsive">
  <table class="table" border="1">
    <thead class="table-info"> 
          <tr>
              <!--Aqui se muestra el nombre de las columnas -->
              <th>Codigo</th>               
              <th>NombreObjeto</th>
              <th>Cantidad</th>
              <th>Categoría</th>
      </tr>
      </thead>
      
      <?php  
      $inventario="SELECT * FROM  inventario WHERE Area='$area'";
      $muestra = mysqli_query($conexion,$inventario);
  while ($row = mysqli_fetch_assoc($muestra)) {
    $cod=$row["CodProducto"];
    $producto = "SELECT * FROM  producto WHERE Codigo ='$cod'";
    $pro= mysqli_query($conexion,$producto);
    $rowP = mysqli_fetch_assoc($pro);
    ?>
     <tbody id="TableP">
      <tr>
          <!--Se muestra las filas de los datos de cada producto en la base de datos -->
          <td><?php echo $row["CodProducto"] ?></td>
          <td><?php echo $rowP["NombreObjeto"] ?></td>
          <td><?php echo $row["Cantidad"] ?></td>
          <td><?php echo $rowP["Categoría"] ?></td>
          
      </tr>
      <?php } 
       mysqli_free_result($muestra);?> 
 
      </table>
  </div>
</div> 
  </tdbody>
  <br><br>   

  <!--Se pide al ADMIN  agregar los datos del producto para añadir a la base de datos, OJO, solo añade, no agrega ni resta stock
Luego llama al php guardarProducto para realizar las operaciones-->
<div class="column2">  
<h2>Ingresar Producto</h2>
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
  <div class="column2">  
  <h2>Remover Producto</h2>
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
        <div class="column2">  
      <h2>Mostrar Cambios</h2>
      <br> 
  <!--Se pide al ADMIN  ingresar el codigo del producto para remover de la base de datos-->
      <form  method="post" action="MostrarCambios.php">
        <div class="form-group">
        <div class="col-md-12">
        <button type="submit" class="btn btn-primary btn-lg btn-block info">Mostrar</button>
        <input type="hidden" name="tipo" value="<?= isset($_SESSION['Tipo'])?htmlspecialchars($_SESSION['Tipo']):'' ?>"/>
        <input type="hidden" name="area" value="<?= isset($_SESSION['Area'])?htmlspecialchars($_SESSION['Area']):'' ?>"/>
        </div>
        </div>     
      </form>
      <br>

 
      </div>
      <h3>Ver Datos</h3>
    <form  method="post" action="Password.php">
      <button type="submit" class="btn btn-primary btn-lg btn-block info">Mostrar</button>
      <input type="hidden" name="rut" value="<?= isset($rut)?htmlspecialchars($rut):'' ?>">
    </form>
      <br> 
      </div>
     
      
</div>
<br>
<div class="topnav">
<a href="index.php">Cerrar Sesión</a>        
</div>
</body>
</html>
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
<script>
$(document).ready(function(){
  $("#InputP").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#TableP tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
    
  });
});
</script>