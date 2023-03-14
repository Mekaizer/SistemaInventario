<?php

//Funcion que valida una contraseña de tamaño minimo 7 y s16 como maximo, debe tener mayusculas, minusculas y numero
   function validar($pass){
    if(strlen($pass) < 6){
        return false;
     }
     if(strlen($pass) > 16){
        return false;
     }
     if (!preg_match('`[a-z]`',$pass)){
        return false;
     }
     if (!preg_match('`[A-Z]`',$pass)){
        return false;
     }
     if (!preg_match('`[0-9]`',$pass)){
        return false;
     }
     return true;
   }
   //Funcion que valida un rut y le pone punto y guion
function rut($c){
    $revc=strrev( $c);
    $large= strlen($revc);
    if($large>7 and $large<10){
           $a = str_split($revc);
     $cont=0;
     $si=true;
     while($cont<$large-1){
         if($cont==0 ){
             if(strtoupper($a[0])=="K"){
                 $si=true;
             }else{
                 if (preg_match('`[a-z]`',$a[0])){
                     $si=false;
                     $cont=$large;
             }
         } 
     }
         else{
             if (preg_match('`[a-z]`',$a[$cont])){
             $cont=$large;
             $si=false;
         }
         }
         $cont++;
     }
     if($si){
         $une=$a[0]."-";
         $cont=0;
         while($cont<$large-1){
             $cont++;
         $une.=$a[$cont];
         if($cont==3 or $cont==6){
             $une.=".";
         }
     }
             $fin= strrev($une);
        return $fin;
     }
     else{
         return "NO";
     }
 
    }else{
        return "NO";
    }
}
//funcion que transforma un txt a una base de datos de pedidos. SOLO FUNCIONA con pdf.txt y pdfe.txt
function Pedido($txt){
    require 'conexion.php';
    $cont = -1;
    $rut = "";
    $codigo = "";
    $int = 0;
    $fp =fopen($txt,"r");
    #Se recorre el txt
while (!feof($fp)) {
    $linea = fgets($fp);
    $cont++;

    if ($linea != "") {
        #se separa la linea en 2, codigo y cantidad
        $separada = explode(" ", $linea, 2);
        if ($cont != 0) {
            $codigo = $separada[0];
            $int = $separada[1];
                #Se encontro el producto en el pedido
                $query = "SELECT * FROM pedido WHERE Codigo = '$codigo'";
                $consulta = mysqli_query($conexion, $query);
                
                $cantidad = mysqli_num_rows($consulta);
                if ($cantidad == 0) {
                    $insertando = " INSERT INTO pedido VALUES('$rut','$codigo','$int','$f')";
                    $query = mysqli_query($conexion, $insertando);
                } else {
                    $row = mysqli_fetch_assoc($consulta);
                    $total = $row["Cantidad"] + $int;
                    $remover = "DELETE FROM `pedido` WHERE `pedido`.`Codigo` = '$codigo'";
                    $query = mysqli_query($conexion, $remover);
                    $insertando = " INSERT INTO pedido VALUES('$rut','$codigo','$total','$f')";
                    $query = mysqli_query($conexion, $insertando);
                    
                }
            
        } 
        else {
            $rut = $separada[0];
            $f= $separada[1];

        }

    }

}

if($cont<=1){
    return false;
}
    return true;
}
//trasforma la base de datos de pedido a txt . SOLO FUNCIONA con pdf.txt y pdfe.txt
function transformatxt($txt){

    require 'conexion.php';
    $query = "SELECT * FROM pedido";
    $consulta = mysqli_query($conexion, $query);
    $file = fopen("./txt/salve.txt", "w");
    $pos =0;

    while ($row = mysqli_fetch_assoc($consulta)) {
        $cod=$row["Codigo"];
        $stock=$row["Cantidad"];
            if($pos==0){
                $rut=$row["Rut"];
                if($rut!=Null){ 
                $fecha=$row["CodFecha"];
                fwrite($file, "$rut $fecha");

                $pos=1;
                if($stock>0){
                    fwrite($file, "$cod $stock \n");
                }
                }
            } else{
                if($stock>0){ 
                    $cod=$row["Codigo"];
                    $stock=$row["Cantidad"];  
                fwrite($file, "$cod $stock \n");
                }
            }
 
  }
  if($pos==0){
    unlink("./txt/salve.txt");
  }
else{
    unlink($txt);
    rename("./txt/salve.txt",$txt);
}




}
function ExisteBoleta($code,$txt){
    //recorre el txt y retorna true si se encontro, caso contrario returna false
    $fp =fopen($txt,"r");
    while (!feof($fp)) {
        $linea = fgets($fp);
            $separada = explode(" ", $linea, 2);
            $codigo = $separada[0];
            if($codigo==$code){
                return true;
            }
        }
        return false;
}
function validarrut($c){
    $revc=strrev($c);
    $large= strlen($revc);
    if($large>10 and $large<13){
           $a = str_split($revc);
     $cont=0;
     $si=true;
          while($cont<$large-1){
         if($cont==0 ){
             if(strtoupper($a[0])=="K"){
                 $si=true;
                 $cont==1;
             }else{
                 if (preg_match('`[0-9]`',$a[0])){
                     $si=false;
                     $cont==1;
             }else{
                 return "NO";
             }
         } 
     }
         else{
             if (preg_match('`[0-9]`',$a[$cont])){  
         }else{
          
             if($a[$cont]=="." or $a[$cont]=="-"){
                $cont++;
             }else{
                     return "NO";
                } 
             }

         }
         
         $cont++;
     }return $c;
     }
     else{
         return "NO";
}
    
}