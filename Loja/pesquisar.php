<?php
	include_once 'connection.php';

	$url = 'https://altsolutions.tech/gerenciador/resources/ProdLoja.php?buscar';
	$dadosProduto = file_get_contents($url);

	//Nome produtos para exibição da página
	$valor_pesquisar = $_GET['procurar-produto'];	
	$qtde_produtos=0;
?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title><?php echo $valor_pesquisar ?> | Alt Solutions</title>
		<link rel="stylesheet" type="text/css" href="css/reset.css">
		<link rel="stylesheet" type="text/css" href="css/estilo-index.css">
		<link rel="stylesheet" type="text/css" href="css/normalize.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
			                <input type="text" id="txtBusca" name="procurar-produto" placeholder="O que você procura?" required>
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
						?>
			            	<li><a href="login.php" class="default-btn">Login</a></li>
						<?php 
							}else{

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
			<!-- Exibindo Resultados/Número de resultados encontrados -->
			<div class="vitrine-title result">
				<h2>Resultado(s) para "<?php echo $_GET['procurar-produto'];?>"</h2>				
			</div>
			<section class="container"> <!-- conteudo da home -->
				<?php				
					$jsonObj 		= json_decode($dadosProduto);
					$dataProduto 	= $jsonObj->dados;

					// cria um novo array para receber primeiro os elementos não nulos (qtde = 0).
					$crescent_prod = array();

					// recebe no array somente os elementos NÃO nulos.
					foreach ($dataProduto as $prod){
						if (!empty($prod->prodNF))
							array_push($crescent_prod, $prod);					
					}

					// recebe no final do array somente os NULOS.
					foreach ($dataProduto as $prod){
						if (empty($prod->prodNF))
							array_push($crescent_prod, $prod);					
					}
									
					$qtd 			= 30;
					$atual 			= (isset($_GET['pg'])) ? intval($_GET['pg']) : 1;
					$pagArquivo		= array_chunk($crescent_prod, $qtd);


					$contar 		= count($pagArquivo);
					
					$resultado 		= $pagArquivo[$atual-1];

				?>
				<!-- laço para passar por todos os produtos e acrescentar na vitrine -->
				<?php
				foreach ($resultado  as $e){
					if (stripos($e->nome, $valor_pesquisar) !== false) {				
			    		if (empty($e->prodNF)) {
							?>
							<div class="item">
								<a onclick="window.location.href='detalhes-produto.php?produto=<?php echo $e->nome?>&descricao=<?php echo $e->descricao?>&valor=<?php echo $e->valorVenda?>&diretorio=<?php echo "https://$e->imagem"; ?>&peso=<?php echo $e->peso?>&categoria=<?php echo $e->categoria?>'">
									<img id="img-prod" src='<?php echo "https://$e->imagem"; ?>' alt="Imagem do Produto">
									<h2><?php echo "$e->nome";?></h2>
									<p class="price">INDISPONÍVEL</p>
									<p style="height: 80px; overflow: hidden;"><?php echo "$e->descricao";?></p>
								</a>
								<div id="product-buttons">
									<button onclick="window.location.href='add-to-cart.php?id=<?php echo $e->produtoID ?>&produto=<?php echo $e->nome?>&qtde=1&preco=<?php echo $e->valorVenda?>'" class="add-button">Adicionar<img src="img/ico/carrinho.png" class="index-cart" alt="Carrinho de compras"></button>
									<button
										onclick="window.location.href='detalhes-produto.php?produto=<?php echo $e->nome?>&descricao=<?php echo $e->descricao?>&valor=<?php echo $e->valorVenda?>&diretorio=<?php echo "https://$e->imagem"; ?>&peso=<?php echo $e->peso?>&categoria=<?php echo $e->categoria?>'"
										class="details-button">Detalhes<img src="img/ico/details.png" class="index-cart" alt="Caixa">
									</button>
								</div>
							</div>	
							<?php
							$qtde_produtos++;
						}else{
							?>
							<div class="item">
								<a onclick="window.location.href='detalhes-produto.php?produto=<?php echo $e->nome?>&descricao=<?php echo $e->descricao?>&valor=<?php echo $e->valorVenda?>&diretorio=<?php echo "https://$e->imagem"; ?>&peso=<?php echo $e->peso?>&categoria=<?php echo $e->categoria?>'">
									<img id="img-prod" src='<?php echo "https://$e->imagem"; ?>' alt="Imagem do Produto">
									<h2><?php echo "$e->nome";?></h2>
									<p class="price">R$ <?php echo number_format($e->valorVenda, 2, ",", ".");?></p>
									<p style="height: 80px; overflow: hidden;"><?php echo "$e->descricao";?></p>
								</a>
								<div id="product-buttons">
									<button onclick="window.location.href='add-to-cart.php?id=<?php echo $e->produtoID ?>&produto=<?php echo $e->nome?>&qtde=1&preco=<?php echo $e->valorVenda?>'" class="add-button">Adicionar<img src="img/ico/carrinho.png" class="index-cart" alt="Carrinho de compras"></button>
									<button
										onclick="window.location.href='detalhes-produto.php?produto=<?php echo $e->nome?>&descricao=<?php echo $e->descricao?>&valor=<?php echo $e->valorVenda?>&diretorio=<?php echo "https://$e->imagem"; ?>&peso=<?php echo $e->peso?>&categoria=<?php echo $e->categoria?>'"
										class="details-button">Detalhes<img src="img/ico/details.png" class="index-cart" alt="Caixa">
									</button>
								</div>
							</div>
							<?php
							$qtde_produtos++;
						}
					}elseif (stripos($e->categoria, $valor_pesquisar) !== false){
						if (empty($e->prodNF)) {
							?>
							<div class="item">
								<a onclick="window.location.href='detalhes-produto.php?produto=<?php echo $e->nome?>&descricao=<?php echo $e->descricao?>&valor=<?php echo $e->valorVenda?>&diretorio=<?php echo "https://$e->imagem"; ?>&peso=<?php echo $e->peso?>&categoria=<?php echo $e->categoria?>'">
									<img id="img-prod" src='<?php echo "https://$e->imagem"; ?>' alt="Imagem do Produto">
									<h2><?php echo "$e->nome";?></h2>
									<p class="price">INDISPONÍVEL</p>
									<p style="height: 80px; overflow: hidden;"><?php echo "$e->descricao";?></p>
								</a>
								<div id="product-buttons">
									<button onclick="window.location.href='add-to-cart.php?id=<?php echo $e->produtoID ?>&produto=<?php echo $e->nome?>&qtde=1&preco=<?php echo $e->valorVenda?>'" class="add-button">Adicionar<img src="img/ico/carrinho.png" class="index-cart" alt="Carrinho de compras"></button>
									<button
										onclick="window.location.href='detalhes-produto.php?produto=<?php echo $e->nome?>&descricao=<?php echo $e->descricao?>&valor=<?php echo $e->valorVenda?>&diretorio=<?php echo "https://$e->imagem"; ?>&peso=<?php echo $e->peso?>&categoria=<?php echo $e->categoria?>'"
										class="details-button">Detalhes<img src="img/ico/details.png" class="index-cart" alt="Caixa">
									</button>
								</div>
							</div>	
							<?php
							$qtde_produtos++;
						}else{
							?>
							<div class="item">
								<a onclick="window.location.href='detalhes-produto.php?produto=<?php echo $e->nome?>&descricao=<?php echo $e->descricao?>&valor=<?php echo $e->valorVenda?>&diretorio=<?php echo "https://$e->imagem"; ?>&peso=<?php echo $e->peso?>&categoria=<?php echo $e->categoria?>'">
									<img id="img-prod" src='<?php echo "https://$e->imagem"; ?>' alt="Imagem do Produto">
									<h2><?php echo "$e->nome";?></h2>
									<p class="price">R$ <?php echo number_format($e->valorVenda, 2, ",", ".");?></p>
									<p style="height: 80px; overflow: hidden;"><?php echo "$e->descricao";?></p>
								</a>
								<div id="product-buttons">
									<button onclick="window.location.href='add-to-cart.php?id=<?php echo $e->produtoID ?>&produto=<?php echo $e->nome?>&qtde=1&preco=<?php echo $e->valorVenda?>'" class="add-button">Adicionar<img src="img/ico/carrinho.png" class="index-cart" alt="Carrinho de compras"></button>
									<button
										onclick="window.location.href='detalhes-produto.php?produto=<?php echo $e->nome?>&descricao=<?php echo $e->descricao?>&valor=<?php echo $e->valorVenda?>&diretorio=<?php echo "https://$e->imagem"; ?>&peso=<?php echo $e->peso?>&categoria=<?php echo $e->categoria?>'"
										class="details-button">Detalhes<img src="img/ico/details.png" class="index-cart" alt="Caixa">
									</button>
								</div>
							</div>
							<?php
							$qtde_produtos++;
						}
					}
				}
				?>
			</section>
				<div class="vitrine-title result">
					<h2>Total de resultados: <?php echo $qtde_produtos;?></h2>
				</div>
			<!-- PAGINAÇÃO -->
			<div class="link_page">
			<?php
				echo "<a href='pesquisar.php?procurar-produto=$valor_pesquisar&pg=1'>Primeira</a> ";
				for($i = 1; $i <= $contar; $i++){
					if($i == $atual){
						echo "<a style='background-color:#d48802' href='pesquisar.php?procurar-produto=$valor_pesquisar&pg=$i'>$i</a> ";
					}else{
						echo "<a href='pesquisar.php?procurar-produto=$valor_pesquisar&pg=$i'>$i</a> ";
					}
				}
				$i = $i-1;
				echo "<a href='pesquisar.php?procurar-produto=$valor_pesquisar&pg=$i'>Última</a> ";
			?>
			</div>
		</main>
		<footer>
			<div class="footer">
				<div class="footer-links">
					<div class="description">
						<h2>Sobre</h2>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					</div>
					<div>
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
					<div>
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