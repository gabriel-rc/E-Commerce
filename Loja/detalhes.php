<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<title>Dados cadastrados | Alt Solutions</title>
	<link rel="stylesheet" type="text/css" href="css/estilo-detalhes-pedido.css">
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="icon" href="favicon.png">

</head>

<body>
<header> 
			<div class="principal-menu-nav">
				<nav>
	      			<input type="checkbox" id="check">
	      			<label for="check" class="checkbtn">
	        			<i class="fas fa-bars"></i>
	      			</label>
	     			<label class="logo"><a href="index.php" class="logo-link"><img src="img/logo.png" alt="Logo da loja"></a></label>
	      			<ul>
			            <li>
			              <form class="search-bar" method="GET" action="pesquisar.php">
			                <input type="text" id="txtBusca" name="procurar-produto" placeholder="O que você procura?" required="yes">
			                <button class="search-btn"><img src="img/ico/lupa.png" class="index-lupa" alt="Lupa"></button>
			              </form>
			            </li>
			            <li>
			              <a href="carrinho.php" class="cart-link"><img src="img/ico/carrinho.png" class="index-cart-menu" alt="Carrinho de compras"></a>
			            </li>
			            <li><a href="index.php">Home</a></li>
			          	<li id="sua-conta-li"><a href="cliente-page.php">Sua conta</a></li>
			            <li><a href="sobre.php">Sobre</a></li>
			            <li><a href="contato.php">Contato</a></li>
			            <?php 
							
							if(!isset($_COOKIE['cliente'])){
								header ("Location: login.php");
						?>
			            	<li><a href="login.php" class="default-btn">Login</a></li>
						<?php 
							}else{
								include 'resources/autenticador.php';
								require 'resources/ControlPedido.php';
								$cp=new ControlPedido();
								$p=$cp->buscaPedido($c);
								if(isset($_GET['p'])){
									$res=0;
									foreach($p as $pedido){
										if($pedido->pedidoID==$_GET['p'])
											$res=$pedido;
										
									}
									if(is_int($res))
									header ("Location: pedidos.php");
								}else
									header ("Location: pedidos.php");
						?>
							<li><a href="cliente-page.php">Sua conta</a></li>
						<?php 
							$url = 'https://altsolutions.tech/gerenciador/resources/ProdLoja.php?buscar';
							$dadosProduto = file_get_contents($url);
							$jsonObj = json_decode($dadosProduto);
							$dataProduto = $jsonObj->dados;
							function encontraNomePorId($id,$array){
                
            
								foreach ( $array as $element ) {
									if ( strcmp($id , $element->produtoID)==0 ) {
										return $element->nome;
									}
								}
							}  
							}
						?>
			        </ul>
    			</nav>
			</div>
		</header> 

	<main>


		<div class="title-detail">
			<h1>Detalhes do pedido</h1>
		</div>


		<div class="detail-content">
			<div class="adress-detail">
				<h3>Endereço de Envio</h3>
				<p><?php $e=$res->entrega;
						echo "$e->logradouro $e->numero 
						$e->bairro 
						$e->cidade,	$e->uf $e->cep
						Brasil"?>
					</p>
			</div>
			<div class="payment-detail">
				<h3>Forma de Pagamento</h3>
				<p>Cartão de Crédito</p>
			</div>
			<div class="price-detail">
				<h3>Resumo do Pedido</h3>
				<p>Subtotal do(s) item(ns):R$ <?php $subtotal=0;
					foreach($res->itemPedido as $item){
						$subtotal+=$item->valorProd*$item->qtdeProduto;
					}
					echo number_format($subtotal,2,",",".");
				?>
					<br>
					Frete e manuseio:R$ <?php $frete=$res->entrega->freteID->freteValor;
					echo number_format($frete,2,",","."); ?>
					<br>
					Total:R$ <?php echo number_format(($subtotal+$frete),2,",",".") ?></p>
			</div>

		</div>

		<br>

		<div class="detail-table">
			<table>

			<tr>
				<th>Produto</th>
				<th>Quantidade</th>
				<th>Preço</th>
			</tr>
			<?php foreach($res->itemPedido as $item){?>
			<tr>
				<td><?php echo encontraNomePorId($item->produtoID,$dataProduto)?> </td>
				<td><?php echo $item->qtdeProduto?></td>
				<td>R$<?php echo number_format($item->valorProd,2,",",".")?></td>
			</tr>
			<?php }?>
			</table>

		</div>

		<br>

		<div class="btn-voltar">
			<button onclick="window.location.href='pedidos.php'">
				<img src="./img/ico/back.png" class="img-voltar">
			</button>
		</div>
		

	</main>

	<footer> <!-- Footer -->
			<div class="footer">
			<div class="footer-links">
				<div class="footer-description">
					<h2>Sobre</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				</div>
				<div class="footer-link1">
					<h2>Categorias</h2>
					<ul class="footer-cat1">
						<li><a href="pesquisar.php?procurar-produto=Eletrônicos">Eletrônicos</a></li>
			            <li><a href="pesquisar.php?procurar-produto=Informática">Informática</a></li>
			            <li><a href="pesquisar.php?procurar-produto=Telefone">Telefones</a></li>
			            <li><a href="pesquisar.php?procurar-produto=Jogos">Jogos</a></li>
			            <li><a href="pesquisar.php?procurar-produto=Vídeos">Vídeos</a></li>
			            <li><a href="pesquisar.php?procurar-produto=Acessórios">Acessórios</a></li>
					</ul>
				</div>
				<div class="footer-link2">
					<h2>Links Rápidos</h2>
					<ul class="footer-cat2">
						<li><a href="sobre.php">Sobre nós</a></li>
						<li><a href="contato.php">Entre em contato</a></li>
						<li><a href="politica-termos.php">Política de privacidade</a></li>
					</ul>
				</div>

			</div>
			<div class="footer-copyright">
				<p>Copyright &copy; 2021 All Rights Reserved by Quinteto RTA.</p>
			</div>
		</div>
		</footer>
</body>

</html>