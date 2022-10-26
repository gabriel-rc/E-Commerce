<?php 
include("connection.php");

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if(!empty($dados['cadUsuario'])){
	$query_cliente = "INSERT INTO Cliente (cpf, email, senha, nome, datanasc) VALUES ('" . $dados['cpf'] . "', '" . $dados['email'] . "', '" . $dados['senha'] . "', '" . $dados['nome'] . "', '" . $dados['data-nasc'] . "')";
	$query_tcep = "INSERT INTO tCEP (cep, endereco, cidade, bairro, uf) VALUES ('" . $dados['cep'] . "', '" . $dados['endereco'] . "', '" . $dados['cidade'] . "', '" . $dados['bairro'] . "', '" . $dados['estado'] . "')";

	$cad_cliente = $conn->prepare($query_cliente);
	$cad_cliente->execute();

	$last_id = $conn->lastInsertId();

	$cad_cliente = $conn->prepare($query_tcep);
	$cad_cliente->execute();

	$query_endereco = "INSERT INTO Endereco (clienteID, cep, num, complemento) VALUES ('" . $last_id . "', '" . $dados['cep'] . "', '" . $dados['num'] . "', '" . $dados['complemento'] . "')";
	$query_telefone = "INSERT INTO Telefone (clienteID, telefone) VALUES ('" . $last_id . "', '" . $dados['telefone'] . "')";

	$cad_cliente = $conn->prepare($query_endereco);
	$cad_cliente->execute();

	$cad_cliente = $conn->prepare($query_telefone);
	$cad_cliente->execute();

	if($cad_cliente->rowCount()){
		echo "Usuário cadastrado com sucesso!<br>";
	}else{
		echo "Erro: Usuário NÃO cadastrado!<br>";
	}

	header('Location: criar-conta.php');
}


?>