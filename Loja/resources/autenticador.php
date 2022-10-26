<?php
   if(isset($_COOKIE["cliente"])){
        $clientejson = $_COOKIE["cliente"];
        $cliente=json_decode($clientejson);

   }
 
if (empty($cliente->id) or empty($cliente->senha))
   include "logout.php";

include "conectarbd.php";
$valida_login = mysqli_query($connmysqli, "SELECT * FROM Cliente where clienteID='$cliente->id'");
$linhas_v = mysqli_num_rows($valida_login);


if($linhas_v == 0){
   mysqli_close($connmysqli);
   include "logout.php";
}
else
{
   $autenticar=mysqli_fetch_assoc($valida_login);
   if(strcmp($cliente->senha,$autenticar['senha'])==0){
      require 'ControlCliente.php';
      $cc= new ControlCliente();
      $c= $cc->buscarCliente($cliente->id);
      mysqli_close($connmysqli);
      
   }else{
      mysqli_close($connmysqli);
      include "logout.php";
   }
}
   

?>