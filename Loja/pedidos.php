<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Seus Pedidos | Alt Solutions</title>
		<link rel="stylesheet" type="text/css" href="css/estilo.css">
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
								header ("Location: ../login.php");
						?>
			            	<li><a href="login.php" class="default-btn">Login</a></li>
						<?php 
							}else{
								include 'resources/autenticador.php';
								require 'resources/ControlPedido.php';
								$cp=new ControlPedido();
								$p=$cp->buscaPedido($c);
								if(isset($_GET['canc'])){
									$res=0;
									foreach($p as $pedido){
										if($pedido->pedidoID==$_GET['canc'])
											$res=$pedido;
									}
									if(!is_int($res)){
										$p=new Pedido();
										$p->pedidoID=$res->pedidoID;
										$p->dataCancelado=1;
										$cp->atualizaPedido($p);
										header ("Location: pedidos.php");

									}
								}
							//	print_r($p);

						?>
							<li><a href="cliente-page.php">Sua conta</a></li>
						<?php 
							}
						?>
			        </ul>
    			</nav>
			</div>
		</header>

		<main>
			<div class="pedidos-div pedidos-menu"><a href="cliente-page.php">Sua conta</a> > Seus pedidos</div>
			<div class="pedidos-content">				
				<div class="pedidos-div2"><img src="img/ico/pedido-box.png"> <h1>PEDIDOS (<?php echo count($p)?>)</h1></div>
				<table class="table-pedidos">
				  <thead>
				    <tr>
				      <th scope="col" class="first">#Pedido</th>
				      <th scope="col">Data</th>
				      <th scope="col">Itens</th>
				      <th scope="col">Situação</th>			      
				      <th scope="col">Total</th>
				      <th scope="col">Pagamento</th>
				      <th scope="col"></th>
				      <th scope="col" class="last"></th>
				    </tr>
				  </thead>
				  <tbody>
					<?php 
						foreach($p as $pedido){
					?>	
						<tr>
						<td data-label="pedido" class="pedido"><?php echo $pedido->pedidoID?></td>
						<td data-label="data"><?php 
						echo date('d/m/y',strtotime($pedido->dataPendente))?></td>
						<td data-label="itens"><?php echo count($pedido->itemPedido)?></td>
						<td data-label="situation"><div class="situation-prod"><?php if(isset($pedido->dataCancelado)){?>
							<img src="img/ico/produto-button3.png">
						<?php }else if(isset($pedido->dataProcessamento)){ ?>
							<img src="img/ico/produto-button1.png"></div>
							<?php }else{  ?>
							<img src="img/ico/produto-button2.png"></div>
							<?php }?></td>
						<td data-label="total">R$ <?php $soma=$pedido->entrega->freteID->freteValor;
	
						foreach($pedido->itemPedido as $itemPedido)
							$soma+=$itemPedido->qtdeProduto * $itemPedido->valorProd;
						echo number_format($soma,2,",",".");
						?></td>
						<td data-label="forma-pagamento" class="card-logo2">
						  <img src="img/ico/mastercard-logo.png"  alt="forma-pagamento">			      	
						</td>
						<td data-label="detail"><button class="detail-button" onclick="window.location.href='detalhes.php?p=<?php echo$pedido->pedidoID?>'">Detalhes</button></td>
						<td data-label="cancelar-action"><?php if(!isset($pedido->dataCancelado)){ ?><button class="cancel-button" onclick="window.location.href='pedidos.php?canc=<?php echo$pedido->pedidoID?>'"><img src="img/ico/close.png" class="cadastro-ico" alt="cancelar"></button><?php }?></td>
					  </tr>
					<?php } ?>
				  </tbody>
				</table>
			</div>
			

			<div class="buttons-pedidos">
				<form action="cliente-page.php">
				    <input type="submit" value="Voltar" />
				</form>
			</div>
		</main>

			<footer>
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