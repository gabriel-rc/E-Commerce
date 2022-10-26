<?php
// obt�m os valores digitados
$email = trim($_POST["email"]);
$senha = strval( $_POST["password"]);

// acesso ao banco de dados
include "conectarbd.php";
$reslogin = mysqli_query($connmysqli, "SELECT * FROM Cliente where email='$email'");
$login_linhas = mysqli_num_rows($reslogin);

// testa se a consulta retornou algum registro
if($login_linhas!=0){
    $cliente=mysqli_fetch_array($reslogin);
    $id=$cliente['clienteID'];
    $senhadb=$cliente['senha'];
    if(password_verify(strval($_POST["password"]),$senhadb)){
        $senha=$senhadb;
        $cliente=(object) [
            'id'=>"$id",
            'senha'=>"$senha"
            
        ];
        setcookie ("cliente",json_encode($cliente),0,"/" );   
   
        header ("Location: ../index.php");
    }else{
        header ("Location: ../login.php");
      //  echo "Usuário ou senha inválidos";
      //  echo "id $id senha $senhadb";
       // print_r($_POST);
       // print_r(password_verify(strval($_POST["password"]),$senhadb)?"s":"n");
    }
    
}
else
{
    header ("Location: ../login.php");
    echo "Usuário ou senha inválidos";
    
}
mysqli_close($connmysqli);
?>

