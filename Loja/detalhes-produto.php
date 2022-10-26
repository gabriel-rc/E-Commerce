<!-- Recebe valores da URL e atribui às variaveis -->
<?php
  $nome = $_GET['produto'];
  $valorVenda = $_GET['valor'];
  $descricao = $_GET['descricao'];
  $diretorio = $_GET['diretorio'];
  $peso = $_GET['peso'];
  $categoria = $_GET['categoria'];
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title><?php echo $nome ?> | AltSolutions</title>
    <link rel="stylesheet" type="text/css" href="css/estilo-detalhes-produto.css">
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
    <!-- Conteúdo da página -->
    <main>
      <div class = "card-wrapper">
      <div class = "card">
        <!-- card esquerda -->
        <div class = "product-imgs">
          <div class = "img-display">
            <div class = "img-showcase">
              <img src = "<?php echo "$diretorio" ?>" alt = "<?php echo $nome ?>">
              <img src = "<?php echo "$diretorio" ?>" alt = "<?php echo $nome ?>">
              <img src = "<?php echo "$diretorio" ?>" alt = "<?php echo $nome ?>">
              <img src = "<?php echo "$diretorio" ?>" alt = "<?php echo $nome ?>">
            </div>
          </div>
          <div class = "img-select">
            <div class = "img-item">
              <a href = "#" data-id = "1">
                <img src = "<?php echo "$diretorio" ?>" alt = "<?php echo $nome ?>">
              </a>
            </div>
            <div class = "img-item">
              <a href = "#" data-id = "2">
                <img src = "<?php echo "$diretorio" ?>" alt = "<?php echo $nome ?>">
              </a>
            </div>
            <div class = "img-item">
              <a href = "#" data-id = "3">
                <img src = "<?php echo "$diretorio" ?>" alt = "<?php echo $nome ?>">
              </a>
            </div>
            <div class = "img-item">
              <a href = "#" data-id = "4">
                <img src = "<?php echo "$diretorio" ?>" alt = "<?php echo $nome ?>">
              </a>
            </div>
          </div>
        </div>
        <!-- card direita -->
        <div class = "product-content">
          <h2 class = "product-title"><?php echo $nome ?></h2>
          <a onclick="window.location.href = 'index.php'" class = "product-link">Ver outros produtos</a>

          <div class = "product-price">
            <p class = "new-price">Preço: <span>R$<?php echo number_format($valorVenda, 2, ",", ".") ?></span></p>
          </div>
          <div class = "product-detail">
            <h2>Descrição: </h2>
            <p><?php echo $descricao ?></p>
            <ul>
              <li>Peso: <span><?php echo $peso ?>g</span></li>
              <li>Categoria: <span><?php echo $categoria ?></span></li>
            </ul>
          </div>

          <div class = "purchase-info">
            <button onclick="window.location.href='add-to-cart.php?produto=<?php echo $nome?>&qtde=1&preco=<?php echo $valorVenda?>'" type = "button" class = "btn">Adicionar ao carrinho</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Troca imagem do produto ao clicar -->
    <script type="text/javascript">
          const imgs = document.querySelectorAll('.img-select a');
          const imgBtns = [...imgs];
          let imgId = 1;

          imgBtns.forEach((imgItem) => {
              imgItem.addEventListener('click', (event) => {
                  event.preventDefault();
                  imgId = imgItem.dataset.id;
                  slideImage();
              });
          });
          function slideImage(){
              const displayWidth = document.querySelector('.img-showcase img:first-child').clientWidth;
              document.querySelector('.img-showcase').style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;
          }
          window.addEventListener('resize', slideImage);
      </script>
    </main>
    <!-- Footer da página -->
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