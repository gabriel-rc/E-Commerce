<?php
	include_once 'connection.php';
	
	$url = 'https://altsolutions.tech/gerenciador/resources/ProdLoja.php?buscar';
	$dadosProduto = file_get_contents($url);
	$qtde_produtos=0;

	$jsonObj 		= json_decode($dadosProduto);
	$dataProduto 	= $jsonObj->dados;
?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Alt Solutions</title>
		<link rel="stylesheet" type="text/css" href="css/reset.css">
		<link rel="stylesheet" type="text/css" href="css/estilo-index.css">
		<link rel="stylesheet" type="text/css" href="css/normalize.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="img/favicon.png">
	</head>
	<body>
		<!-- Menu Nav -->
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
			<!-- Carrosel -->
			<div id="slider-wrapper">
			  <div class="inner-wrapper">
			    <input checked type="radio" name="slide" class="control" id="Slide1" />
			    <label for="Slide1" id="s1"></label>
			    <input type="radio" name="slide" class="control" id="Slide2" />
			    <label for="Slide2" id="s2"></label>
			    <input type="radio" name="slide" class="control" id="Slide3" />
			    <label for="Slide3" id="s3"></label>
			    <input type="radio" name="slide" class="control" id="Slide4" />
			    <label for="Slide4" id="s4"></label>
			    <div class="overflow-wrapper">
			      <a class="slide" href=""><img src="img/mainbanner.jpg" alt="imagem banner com dois controles" /></a>
			      <a class="slide" href=""><img src="img/mainbanner2.jpg" alt="diversos consoles" /></a>
			      <a class="slide" href=""><img src="img/mainbanner3.jpg" alt="controles em um fundo amarelo" /></a>
			      <a class="slide" href=""><img src="img/mainbanner4.jpg" alt="controles em um fundo de futebol" /></a>
			    </div>
			  </div>
			</div>
			<!-- Categorias -->
			<div class="categoria-title"><h2><a name="categorias-index"></a>Categorias</h2></div>
			<div class="div-categoria">
				<div class="categoria-index">
					<a href="pesquisar.php?procurar-produto=Eletrônicos">
						<h2>Eletrônicos</h2>
						<img src="./img/categoria/console.jpg">
					</a>
				</div>
				<div class="categoria-index">
					<a href="pesquisar.php?procurar-produto=Fone">
						<h2>Fones</h2>
						<img src="./img/categoria/fones.jpg">
					</a>
				</div>
				<div class="categoria-index">
					<a href="pesquisar.php?procurar-produto=Mouse">
						<h2>Mouses</h2>
						<img src="./img/categoria/mouse.png">
					</a>
				</div>
			</div>
			<!-- Novidades Alt-Solutions -->
			<div class="categoria-title"><h2>Novidades Alt-Solutions</h2></div>
			<div class="div-novidades">
				<?php
				$ultimo = array_slice($dataProduto, -3);
				foreach($ultimo as $nov){
				?>	
				<div class="novidade-index">
					<a onclick="window.location.href='detalhes-produto.php?produto=<?php echo $nov->nome?>&descricao=<?php echo $nov->descricao?>&valor=<?php echo $nov->valorVenda?>&diretorio=<?php echo "https://$nov->imagem"; ?>&peso=<?php echo $nov->peso?>&categoria=<?php echo $nov->categoria?>'">
						
						<img src='<?php echo "https://$nov->imagem"; ?>' alt="Imagem do Produto">
						<h2 id="nov-h2"><?php echo "$nov->nome";?></h2>
						
					</a>
				</div>
				<?php	
				}
				?>
			</div>
			<!-- vitrine -->
			<div class="vitrine-title"><h2></h2></div>
			<section class="container">
				<?php		
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
					
					$qtd 			= 8;
					$atual 			= (isset($_GET['pg'])) ? intval($_GET['pg']) : 1;
					$pagArquivo		= array_chunk($crescent_prod, $qtd);
					$contar 		= count($pagArquivo);
					$resultado 		= $pagArquivo[$atual-1];
				?>
				<?php
					// laço para passar por todos os produtos e acrescentar na vitrine
					foreach ($resultado as $e){		
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
						}				
						?>
		
					<?php
					$qtde_produtos++;
					}
					?>
			</section>
			<!-- PAGINAÇÃO -->
			<div class="link_page">
			<?php
				echo "<a href='index.php?pg=1'>Primeira</a> ";
				for($i = 1; $i <= $contar; $i++){
					if($i == $atual){
						printf('<a style="background-color:#d48802" href="index.php?pg=1">%s</a>', $i);
					}else{
						printf('<a href="?pg=%s">%s</a>', $i, $i);
					}
				}
				$i = $i-1;
				echo "<a href='index.php?pg=$i'>Última</a> ";
			?>
			</div>
		</main>
		<!-- Footer -->
		<footer>			
			<div class="footer">
				<a href="#categorias-index"><div id="inicio-ancora">Voltar ao início</div></a>
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