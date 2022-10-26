<?php 

session_start();
	$url = 'https://altsolutions.tech/gerenciador/resources/ProdLoja.php?buscar';
	$dadosProduto = file_get_contents($url);
	$jsonObj 		= json_decode($dadosProduto);
	$dataProduto 	= $jsonObj->dados;

if(empty($_SESSION['cart'])){
	$_SESSION['cart'] = array();
}

if(in_array($_GET['produto'], $_SESSION['cart'])){
	$produto = $_GET['produto'];

	$key = array_search($produto , $_SESSION['cart']);
	if($key!==false){
		$_SESSION['cart'][$key+1] = $_SESSION['cart'][$key+1]+1;

		foreach ($dataProduto as $key) {
			foreach($key->prodNF as $key2){
				$key3 = array_search($produto , $_SESSION['cart']);
				if($key->nome == $produto){
			 		$limit = $key2->qtdeDisp;

			 		if($_SESSION['cart'][$key3+1]>$limit){
			 			$_SESSION['cart'][$key3+1] = $limit;
			 		}
			 		$_SESSION['cart'][$key3+1] = $_SESSION['cart'][$key3+1];

				}
				
			}
		}
		/*
		if(empty($limit)){			
			echo "<script>confirm('Produto: $produto, não está disponivel no estoque! \\n\\nDeseja ser avisado quando estiver disponivel novamente?');</script>"; 
			$nome_produto = $produto;
		}
		*/
	}
}else{
	$produto = $_GET['produto'];
	foreach ($dataProduto as $key) {
		foreach($key->prodNF as $key2){
			if($key->nome == $produto)
				$limit = $key2->qtdeDisp;
		}
	}
	if(empty($limit)){		
		echo "<script> alert('Produto: $produto, não está disponivel no estoque! \\n\\nDeseja ser avisado quando estiver disponivel novamente?');</script>";
		echo "<script>window.location.href='contato.php?mensagem=Olá, eu gostaria de ser avisado quando $produto, estiver disponível novamente!'</script>";				
	}else{
		array_push($_SESSION['cart'], $_GET['produto'], $_GET['qtde'], $_GET['preco']);
	}
}
?>
<meta charset="utf-8"/>
<meta http-equiv="refresh" content="0; URL='carrinho.php'"/>
<body style="background-color: #1a1a1a;">
</body>
