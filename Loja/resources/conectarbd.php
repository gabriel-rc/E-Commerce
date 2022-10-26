<?php

//Nome do servidor, usuário, senha e nome da base de dados do Banco de Dados da Loja
$servidor = "nome_servidor";
$usuario = "usuario";
$senha = "senha";
$db = "nome_base";

$connmysqli = new mysqli($servidor, $usuario, $senha, $db);
if (mysqli_connect_errno($connmysqli)) {
	die("Erro de conexão ao servidor:" . mysqli_connect_error());
	

}

try {
	$connPDO = new PDO("mysql:host=$servidor;dbname=" . $db, $usuario, $senha);
	
} catch (Exception $e) {
	die("ERRO: Por favor tente novamente. Caso o problema persista, entre em contato com o administrador: <br>");
}

?>