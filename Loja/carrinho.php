<?php
session_start();

$total = 0;
$cont = 0;

// se carrinho vazio ele vai ser redirecionado para index ao tentar acessa-lo.
if(empty($_SESSION['cart'])){
	header('Location: '.index.'.'.php);;
}

// se clicado no botão add executar função p/ adicionar ao carrinho.
if(isset($_GET['add']) == 1){
 addOnclick();
}
// função para adicionar ao carrinho +1.
function addOnClick(){
	$url = 'https://altsolutions.tech/gerenciador/resources/ProdLoja.php?buscar';
	$dadosProduto = file_get_contents($url);
	$jsonObj 		= json_decode($dadosProduto);
	$dataProduto 	= $jsonObj->dados;

	$prod = $_GET['add'];
	$qtde_add = $_GET['qtde']+1;

	foreach ($dataProduto as $key) {
		foreach($key->prodNF as $key2){
			if($key->nome == $prod){
				$limit = $key2->qtdeDisp;				
			}
			if(!isset($limit)){
					$limit = 100;
				}
		}
	}

	if($qtde_add > $limit){
		$qtde_add = $limit;
		echo "<script>alert('Produto: $prod \\nQuantidade máxima no estoque: $limit.');</script>"; 
	}	

	$key = array_search($prod , $_SESSION['cart']);
	if($key!==false){
	  $_SESSION['cart'][$key+1] = $qtde_add;
	}
	
}

// se clicado no botão del executar função p/ excluir do carrinho.
if(isset($_GET['del']) == 1){
 delOnclick();
}

// função para excluir do carrinho -1.
function delOnClick(){
	$prod = $_GET['del'];
	$qtde_del = $_GET['qtde']-1;

	if ($qtde_del< 2) {
		$qtde_del = 1;
	}

	$key = array_search($prod , $_SESSION['cart']);
	if($key!==false){
	  $_SESSION['cart'][$key+1] = $qtde_del;
	}
	
}

/* Se botão excluir carrinho foi clicado ativa a função removeAllOnClick para exclusão do array. */
if(isset($_GET['remove-all']) == 1){
 removeAllOnclick();
}

/* Função para excluir do array ao clicar no botão "Remover". */
function removeAllOnClick(){
	unset($_SESSION['cart']);
}

/* Se botão remover foi clicado ativa a função removeOnClick para exclusão no array. */
if(isset($_GET['remove']) == 1){
 removeOnclick();
}

/* Função para excluir do array ao clicar no botão "Remover". */
function removeOnClick(){
	$remove = $_GET['remove'];
	$qtde_remove = $_GET['qtde'];
	$price_remove = $_GET['price'];

	unset($_GET['remove']);
	unset($_GET['qtde']);
	unset($_GET['price']);

	$key = array_search($remove , $_SESSION['cart']);
	$key3 = array_search($price_remove , $_SESSION['cart']);

	/* Se encontrado valor passado pela Url no array, excluir e re-ordenar o array. */
	if($key!==false and $key3!==false){
	  unset($_SESSION['cart'][$key]);
	  unset($_SESSION['cart'][$key+1]);
	  unset($_SESSION['cart'][$key3]);

	  $_SESSION['cart'] = array_values($_SESSION['cart']);

	}
}
?>

<!DOCTYPE html>
<html lang="pt-br">

	<head>
		<meta charset="utf-8">
		<title>Carrinho | Alt Solutions</title>
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
			            <div class="search-bar-div">
			            	<form method="GET" action="pesquisar.php">
			              	<input type="text" id="txtBusca" name="procurar-produto" placeholder="O que você procura?" required="yes">
			               	<button class="search-btn"><img src="img/ico/lupa.png" class="index-lupa" alt="Lupa"></button>
			             	</form>
			            </div>			              
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
								if(empty($_SESSION['cart'])){
									header("Location: index.php");;
								  }
						?>
							<li><a href="cliente-page.php">Sua conta</a></li>
						<?php 
							}
						?>
			        </ul>
    			</nav>
			</div>
		</header>

		<div class="carrinho">
			<table class="carrinho-table">
        <tr>
          <th>Produto</th>
          <th>Quantidade</th>
          <th>Preço unitário</th>
          <th>Subtotal</th>
          <th>Opções</th>
        </tr>
        <?php
        if(isset($_SESSION['cart'])){
        	for ($i=0; $i < count($_SESSION['cart']); $i++) {
        ?>

        <td>
          <div class="cart-info">
            <div>
            	<p><?php echo $_SESSION['cart'][$i]; ?></p>
              <br/>
            </div>
          </div>
        </td>

        <td>  
        	<div class="div_qtde">
        		<a class="remove-button div_qtde qtde_button"  href="carrinho.php?del=<?php echo $_SESSION['cart'][$i] ?>&qtde=<?php echo $_SESSION['cart'][$i+1] ?>" style="text-decoration: none;" >-</a>
        		<p class="div_qtde"><?php echo $_SESSION['cart'][$i+1] ?></p>
        		<a class="remove-button div_qtde qtde_button qtde_button_right"  href="carrinho.php?add=<?php echo $_SESSION['cart'][$i] ?>&qtde=<?php echo $_SESSION['cart'][$i+1] ?>" style="text-decoration: none;" >+
        		</a>
        	</div>
        </td>

        <?php $i++; ?>
        <td><strong>R$<?php echo number_format($_SESSION['cart'][$i+1], 2, ",", "."); ?></strong></td>

        <td><span><strong>R$<?php echo number_format($subtotalprod = $_SESSION['cart'][$i+1] * $_SESSION['cart'][$i], 2, ",", "."); ?></strong></span></td>  

        <td>        	
        	<a class="remove-button" href="carrinho.php?remove=<?php echo $_SESSION['cart'][$i-1] ?>&qtde=<?php echo $_SESSION['cart'][$i] ?>&price=<?php echo $_SESSION['cart'][$i+1] ?>" style="text-decoration: none;" >Remover
        	</a> 
        </td>       
        </tr>

        <?php
        	$i++;
        	$sub_total = floatval($_SESSION['cart'][$i]);
        	$total = $total + $subtotalprod;
        	$cont = $cont + $_SESSION['cart'][$i-1];
        	}
        }
        ?>
       </table>

      <div class="total-price">
       	<a class="remove-button" href="carrinho.php?remove-all=0" id="excluir-carrinho" style="text-decoration: none;" >Excluir Carrinho</a>
	      <table>
	      	<tr>
	         	<td>Total (<?php echo $cont ?> itens):</td>
	          <td><strong>R$<?php echo number_format($total, 2, ",", ".");?></strong></td>
	         </tr>
	      </table>      
	      <div>
	        	<a href="realizar-pedido.php" class="checkout-btn">Realizar Pedido</a>
	      </div>
      </div>
    </div>

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