<meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link href="./css/FondoEditar.css?v=<?php echo time(); ?>"  rel="stylesheet" type="text/css">
  
  <?PHP
#agarra el valor y lo devuelve a la base de datos
    $usuario=$_POST["rut"];
    $codigo= $_POST["code"];
    $cantidad=$_POST["stock"];
    $action=$_POST["accion"];
    $txt=$_POST["txt"];
  
    if(isset($_POST["enviar"])){
            #si se quiere hacer un cambio pasa por aqui
        require 'conexion.php';
        $rutt = $_POST["rut"];
        $code = $_POST["codigo"];
        $regresa=$_POST["cantidad"];
    
        $cambio=$_POST["total"]-$regresa;
        $txt=$_POST["txt"];
        $operacion="";
        $action=$_POST["action"];
        setlocale(LC_ALL,"es_ES"); 
        date_default_timezone_set('America/Santiago');
        $time = date('d-m-Y (h:s:m)');  
        if($cambio>=0){
            #buscar el producto
            $total ="SELECT * FROM inventario WHERE CodProducto='$code'";
            $resultado = mysqli_query($conexion, $total);
            $mostrar=mysqli_fetch_array($resultado);
            #aqui se debe diferenciar entre añadir y retirar, añadir es regresar 
            if($action=="Res"){
                $total=abs($mostrar["Cantidad"] - $regresa);
                $sql = "UPDATE inventario SET Cantidad='$total' WHERE CodProducto='$code'";
                $consulta=mysqli_query($conexion,$sql);
                $pedido="UPDATE pedido SET Cantidad='$cambio' WHERE Codigo='$code'";
                $file = fopen($txt, "a");
                fwrite($file, "$code -$regresa \n");
                $cambio = fopen("./txt/todocambios.txt", "a");
                fwrite($cambio,"Se regreso el objeto de codigo $code, una cantidad de $regresa, por $rutt # $time" . PHP_EOL);
                fclose($cambio);
                $cambio = fopen("./txt/cambios.txt", "a");
                fwrite($cambio,"Se regreso el objeto de codigo $code, una cantidad de $regresa, por $rutt # $time" . PHP_EOL);
                fclose($cambio);
                echo "<script> alert('Se regresaron los objetos!!!!');location.assign('EditarPDFE.php')</script>";
                
            }else{

                $total=abs($mostrar["Cantidad"] + $regresa);
                $sql = "UPDATE inventario SET Cantidad='$total' WHERE CodProducto='$code'";
                $consulta=mysqli_query($conexion,$sql);
                $pedido="UPDATE pedido SET Cantidad='$cambio' WHERE Codigo='$code'";
                $file = fopen($txt, "a");
                fwrite($file, "$code -$regresa \n");
                $cambio = fopen("./txt/todocambios.txt", "a");
                fwrite($cambio,"Se regreso el objeto de codigo $code al inventario, una cantidad de $regresa, por $rutt # $time" . PHP_EOL);
                fclose($cambio);
                $cambio = fopen("./txt/cambios.txt", "a");
                fwrite($cambio,"Se regreso el objeto de codigo $code al inventario, una cantidad de $regresa, por $rutt # $time" . PHP_EOL);
                fclose($cambio);
                echo "<script> alert('Se regresaron al inventario!!!!');location.assign('EditarPDFS.php')</script>";
            }

        }   
        else{
            echo "<script> alert('No se puede devolver más productos de los que se pidio');location.assign('EditarPDFE.php')</script>";
        }
       

    }
    ?>   
    <body>

           <h2><center>Escriba la cantidad a regresar </center></h2>
    
        <div>

      
        <center><form action ="" method="post">
    <input input name="cantidad" class="form-control" type="number"required min="1" >
    <?php

?>
    <br>
    <input type="hidden" name="rut" value="<?= isset($usuario)?htmlspecialchars($usuario):'' ?>">
    <input type="hidden" name="codigo" value="<?= isset($codigo)?htmlspecialchars($codigo):'' ?>"> 
    <input type="hidden" name="total" value="<?= isset($cantidad)?htmlspecialchars($cantidad):'' ?>"> 
    <input type="hidden" name="action" value="<?= isset($action)?htmlspecialchars($action):'' ?>"> 
    <input type="hidden" name="txt" value="<?= isset($txt)?htmlspecialchars($txt):'' ?>">
    <input type="submit" name="enviar" value="ACTUALIZAR">
    
  
</form>
</div>
</body>
<br>
    <?php

    if($action=="Res"){
        ?> 
   <center><a href="EditarPDFE.php">Regresar</a>
      <?php
}
else{
    ?> 
   <center><a href="EditarPDFS.php">Regresar</a>
   <?php
}