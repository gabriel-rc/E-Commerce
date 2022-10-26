<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Dados cadastrados | Alt Solutions</title>
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
			                <input type="text" id="txtBusca" name="procurar-produto" placeholder="O que você procura?"  required="yes">
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
							include 'resources/autenticador.php';
						?>
			            	<li><a href="login.php" class="default-btn">Login</a></li>
						<?php 
							}else{
								include 'resources/autenticador.php'

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
		<div class="change-account-container">
			<h1>Dados Cadastrais</h1>
			<p>Altere seus dados para futuras compras!</p>
			<div class="change-account-content">
				<form class="account-form" action="resources/alterar.php" method="POST">
					<h2>Nome</h2>
					<input type="text" name="name" value="<?php 
					if(isset($c)){
						if(strcmp($c->espec,"F")==0)
							echo"$c->nome";
						else
							echo"$c->razaoSocial";
					}?>" placeholder="nome" >
					<h2>E-mail</h2>
					<input type="email" name="email" value="<?php if(isset($c->nome)){
						echo "$c->email";
					}?>" placeholder="e-mail" >
					<h2>Senha:</h2>
					<input type="password" name="password" placeholder="senha" minlength="8" >
					<h2>Confirmar Senha:</h2>
					<input type="password" name="password-confirm" placeholder="confirmar senha" minlength="8" >
					
					<h2>Telefone:</h2>

					<div class="mult-div">
						<select name="tel-select" id="tel-select">
							<?php 
							require 'resources/mask.php';
							foreach ($c->telefone as  $telefone) {
								
								echo '<option value="'.$telefone.'">'.Mask("(##)#####-####",$telefone).'</option>';
							}	
							?>
							
							
						</select>
						<button class="default-account-btn" name="delete-tel" type="submit" value="tel"><img src="img/ico/lixeira.png"
								class="cadastro-ico" alt="lata de lixo"></button>
					</div>

					<h2>Telefone:</h2>
					<input type="text" name="tel" pattern="\([0-9]{2}\)[\s][0-9]{5}-[0-9]{4}" placeholder="Telefone" >
					

					<h2>Endereço:</h2>

					<div class="mult-div">
						
						<select name="ad-select" id="ad-select">
						<?php 
							foreach ($c->endereco as $endereco) {
								echo '<option value="'.$endereco->enderecoID.'">'." $endereco->logradouro $endereco->numero,<br> $endereco->complemento"./* $endereco->bairro*/" $endereco->cidade $endereco->uf".'</option>';
							}	
							?>
							
							
						</select>
						<button  class="default-account-btn" name="delete-ad" type="submit" value="end"><img src="img/ico/lixeira.png"
								class="cadastro-ico" alt="lata de lixo"></button>
							
					</div>
					
					<h2>Cidade:</h2>
					<input type="text" name="city" placeholder="Cidade" >
					<h2>Estado:</h2>
					<input type="text" name="state" placeholder="Estado" >
					<h2>Cep:</h2>
					<input type="text" name="cep" placeholder="99999-999" pattern="[0-9]{5}-[0-9]{3}" >
					<h2>Bairro:</h2>
					<input type="text" name="bairro" placeholder="Bairro" >
					<h2>Logradouro:</h2>
					<input type="text" name="log" placeholder="Logradouro" >
					<h2>Número:</h2>
					<input type="text" name="num" placeholder="Número" >
					<h2>Complemento:</h2>
					<input type="text" name="comp" placeholder="Complemento" >

					
					


					<div class="account-btn">
						<input type="submit" value="Gravar">
						<button class="pedidos-btn" onclick="window.location.href='pedidos.php'">Pedidos</button>
						<a href="resources/logout.php"><input type="button" class="sair-btn" value="Sair"></a>
					</div>
				</form>
			</div>
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