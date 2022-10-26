<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Resumo da compra | Alt Solutions</title>
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="icon" href="favicon.png">
    <script>
        function toggleDiv() {
        if(document.getElementById("adress").style.display == 'none') {
          document.getElementById("adress").style.display = 'block';
          document.getElementById("payment").style.display = 'none';
        } else {
          document.getElementById("adress").style.display = 'none';
          document.getElementById("payment").style.display = 'block';
        }          
      }

      function toggleDivAdress(){
        if(document.getElementById("payment").style.display == 'block'){
          document.getElementById("payment").style.display = 'none';
          document.getElementById("adress").style.display = 'block';
        } 
      }
      /* Máscara CEP */
      function fMasc(objeto,mascara) {
        obj=objeto
        masc=mascara
        setTimeout("fMascEx()",1)
      }
      function fMascEx() {
        obj.value=masc(obj.value)
      }
      function mCEP(cep){
        cep=cep.replace(/\D/g,"")
        cep=cep.replace(/^(\d{5})(\d)/,"$1-$2")
        return cep
      }
      /* Máscaras Cartão */
    function mascara(o,f){
        v_obj=o
        v_fun=f
        setTimeout("execmascara()",1)
    }
    function execmascara(){
        v_obj.value=v_fun(v_obj.value)
    }
    function mcc(v){
        v=v.replace(/\D/g,"");
        v=v.replace(/^(\d{4})(\d)/g,"$1 $2");
        v=v.replace(/^(\d{4})\s(\d{4})(\d)/g,"$1 $2 $3");
        v=v.replace(/^(\d{4})\s(\d{4})\s(\d{4})(\d)/g,"$1 $2 $3 $4");
        return v;
    }
    function id( el ){
      return document.getElementById( el );
    }
    window.onload = function(){
      id('cc').onkeypress = function(){
        mascara( this, mcc );
      }
    }

    function mascara_data(campo, valor){
      var mydata = '';
      mydata = mydata + valor;
      if (mydata.length == 2){
        mydata = mydata + '/';
        campo.value = mydata;
      }
    }   
    function getEndereco(){
      var end="realizar-pedido.php?id=";
      var e=document.getElementById("adress-select");
      end+= e.options[e.selectedIndex].value;
      
      window.location.replace(end);
      
    } 
    
    
    </script>

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
                include 'resources/ControlPedido.php';
                include 'resources/valida.php';
                function encontraIdPorNome($nome,$array){
                
            
                foreach ( $array as $element ) {
                    if ( strcmp($nome , $element->nome)==0 ) {
                        return $element->produtoID;
                    }
                }
            
                return false;
              }
                session_start();

                if(empty($_SESSION['cart'])){
                  header("Location: index.php");;
                }
                $url = 'https://altsolutions.tech/gerenciador/resources/ProdLoja.php?buscar';
	              $dadosProduto = file_get_contents($url);
	              $jsonObj 		= json_decode($dadosProduto);
	              $dataProduto 	= $jsonObj->dados;
                $subtotal=0;
                $frete=0;
                $peso=0;
                
                for($i=0;$i<count($_SESSION['cart']);$i+=3){
                  $subtotal+=$_SESSION['cart'][$i+1]*$_SESSION['cart'][$i+2];
                  $peso+=$dataProduto[array_search($_SESSION['cart'][$i],$dataProduto)]->peso*$_SESSION['cart'][$i+1];
                }
                if(isset($_GET['id']) && !(strcmp($_GET['id'],"empty")==0)){
                  foreach($c->endereco as $endereco){
                    if($endereco->enderecoID==$_GET['id']){
                      $end=$endereco;
                      
                    }
                  }
                  $cp=new ControlPedido();
                  $preco=$cp->calculaFrete($end->cep,$peso);
                  
                  if(!is_string($preco)){
                    $frete=$preco;
                    
                  }else
                    echo $fretecalc;
                 // print_r($_POST);
                  if(isset($_POST['forma-pag']) && strcmp('cartao',$_POST['forma-pag'])==0 ){
                    if(!luhn_check($_POST['cc']) || (date("y")>substr($_POST['date-card'],3,2))||(date("y")==substr($_POST['date-card'],3,2)&&(date("m")>substr($_POST['date-card'],0,2)))||(substr($_POST['date-card'],0,2)>"12")||substr($_POST['date-card'],0,2)<1){
                      $erro="Cartão Inválido";
                    }else if(strlen($_POST['cvv-code'])>0 && strlen($_POST['cc'])>0 && strlen($_POST['date-card'])>0 && strlen($_POST['card-name'])>0){
                      //valida cartão
                      $p=new Pedido();
                      $p->clienteID=$c->id;
                      for($i=0;$i<count($_SESSION['cart']);$i+=3){
                          $ip=new ItemPedido();
                          $ip->produtoID= encontraIdPorNome($_SESSION['cart'][$i],$dataProduto);//$dataProduto[array_search($_SESSION['cart'][$i],$dataProduto)]->produtoID;
                          $ip->qtdeProduto=$_SESSION['cart'][$i+1];
                          $ip->valorProd=$_SESSION['cart'][$i+2];
                          array_push($p->itemPedido,$ip);

                      }
                   //   print_r($dataProduto);
                    //  print_r($p->itemPedido);
                      $entr=new Entrega();
                      $entr->cep=$end->cep;
                      $entr->numero=$end->numero;
                      $entr->logradouro=$end->logradouro;
                      $entr->complemento=$end->complemento;
                      $entr->bairro=$end->bairro;
                      $entr->cidade=$end->cidade;
                      $entr->uf=$end->uf;
                      $p->entrega=$entr;
                      $cp->realizaPedido($p);
                    
                      unset($_SESSION['cart']);
                      header('location: pedidos.php');
                    }
                  }
                }
                
                
                $total=$frete+$subtotal;
                
               
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

<div class="checkout-container">        
  <div class="left-container">  

    <div class="adress-container" id="adress">
      <div class="title-container">
        <h2>Endereço</h2>
      </div>

      <div class="adress-content">
        <?php if(isset($erro)) echo $erro; ?>
        <h2 class="title-pedido">Informações do cliente</h2>
        <select name="adress" id="adress-select" onchange="getEndereco()">
          <option value="empty">Selecione um endereço*</option>
          <?php foreach($c->endereco as $endereco)?>
          <option <?php if(isset($_GET['id'])){if($_GET['id']==$endereco->enderecoID)echo"selected";}?> value="<?php echo $endereco->enderecoID; ?>"><?php echo $endereco->logradouro; ?></option>
          <?php ?>
        </select>      

        <div class="endereco-div-pedido">
          <input type="text" id="cep-form" value="<?php if(isset($end)) echo $end->cep; ?>" name="cep" placeholder="CEP*" maxlength="9" readonly  onblur="getDados()" onkeydown="javascript: fMasc( this, mCEP );" required>
          <input type="text" id="num-form" name="num" id="city-element-pedido" value="<?php if(isset($end)) echo $end->numero; ?>" readonly placeholder="Núm*" required>
          <input type="text" id="comp-form" name="comp" id="city-element-pedido" value="<?php if(isset($end)) echo $end->complemento; ?>" readonly placeholder="Complemento">
        </div>       

        <div class="uf-city-pedido">
        <select name="estado"  readonly id="estado-pedido">
          <?php if(isset($end)) echo "<option value='$end->uf'>$end->uf</option>"; ?>
            
            <option value="empty">UF*</option>
            <option value="AC">AC</option>
            <option value="AL">AL</option>
            <option value="AP">AP</option>
            <option value="AM">AM</option>
            <option value="BA">BA</option>
            <option value="CE">CE</option>
            <option value="DF">DF</option>
            <option value="ES">ES</option>
            <option value="GO">GO</option>
            <option value="MA">MA</option>
            <option value="MT">MT</option>
            <option value="MS">MS</option>
            <option value="MG">MG</option>
            <option value="PA">PA</option>
            <option value="PB">PB</option>
            <option value="PR">PR</option>
            <option value="PE">PE</option>
            <option value="PI">PI</option>
            <option value="RJ">RJ</option>
            <option value="RN">RN</option>
            <option value="RS">RS</option>
            <option value="RO">RO</option>
            <option value="RR">RR</option>
            <option value="SC">SC</option>
            <option value="SP">SP</option>
            <option value="SE">SE</option>
            <option value="TO">TO</option>
          </select>
          <input type="text" readonly value="<?php if(isset($end)) echo $end->cidade; ?>" name="city" id="city-element-pedido" placeholder="Cidade*">
        </div>
        

        <form action="alterar-cadastro.php">
          <button type="submit" class="another-adress">Outro endereço <img src="img/ico/plus.png" class="func-ico" alt="adicao"></button>
        </form>
        
        <h3 class="h3-frete">Selecione o modo de envio</h3>
        <select name="frete" id="frete">
          <option value="frete1">Padrão</option>
          <option value="frete2">Expresso</option>
          <option value="frete3">Outro</option>
        </select>
      </div>

      <div class="button-div">
        <button type="button" <?php if($frete==0) echo"disabled";?> onclick="toggleDiv()" >Pagamento <img src="img/ico/right.png" class="cadastro-ico" alt="seta para direita"></button>
      </div>
    </div>  
    <form method="post" name="pag" action="realizar-pedido.php?id=<?php if(isset($_GET['id'])) echo $_GET['id'];?>" >
      <div class="payment-container" id="payment">
        <div class="title-container">
          <h2>Pagamento</h2>
        </div>
        <div class="payment-content" >
          <h3 class="h3-pag">Forma de pagamento</h3>
          <div class="radio-div-pedido switch-field">
            <input type="radio" id="cartao" name="forma-pag" value="cartao" checked/>
            <label for="cartao"><img src="img/ico/card.png" alt="icone-cartao"> Cartão </label>
            <input type="radio" disabled id="boleto" name="forma-pag" value="boleto"/>
            <label for="boleto"><img src="img/ico/Bar-Code.png" alt="icone-cartao"> Boleto</label>
          </div>
          
          <div class="card-logo">
            <img src="img/ico/visa-logo.png" alt="visa-logo">
            <img src="img/ico/mastercard-logo.png" alt="master-card-logo">
            <img src="img/ico/american-express.png" alt="american-express-logo" style="height: 30px; width: 30px;">
            <img src="img/ico/elo-logo.jpg" alt="elo-logo" style="height: 25px; width: 50px;">
          </div>

          <h3>NÚMERO DO CARTÃO</h3>
          <div class="credit-input" id="credit-input">
            <input type="tel" name="cc" id="cc" maxlength="19" placeholder="Número do cartão*">
            <img src="img/ico/Credit-Card.png" alt="icone-cartao">
          </div>               

          <div class="credit-card-title">
            <h3>DATA DE VALIDADE</h3>
            <h3>CVV</h3>
          </div>

          <div class="credit-card" id="credit-card">                  
            <input id="date-card" onkeypress="return event.charCode >= 48 && event.charCode <= 57" type="text" name="date-card" placeholder="MM/AA*" onkeyup="mascara_data(this, this.value)" id="date" maxlength="5">
          </div>

          <div class="credit-card" >                  
            <input  id="cvv-card" onkeypress="return event.charCode >= 48 && event.charCode <= 57" type="text" name="cvv-code" placeholder="CVV*" maxlength="3">
          </div>  
                        

          <h3>NOME IGUAL NO CARTÃO</h3>
          <input type="text" name="card-name" id="card-name" placeholder="Nome*">

          <h3>Parcelas</h3>
          <select id="parcelas">
            <?php for($i=1;$i<=3;$i++){
            ?>
              <option value="<?php echo $i;?>"><?php echo $i."x  R$".number_format($total/$i,2,",","."); ?></option>
            <?php 
            }
            ?>
          </select>
        </div>

        <div class="button-div">
          <button type="button" class="back-btn" onclick="toggleDivAdress()"><img src="img/ico/left.png" class="cadastro-ico" alt="seta para esquerda"> Endereço</button>
          <button  type="submit"  class="complete-purchase">Finalizar Compra</button>
        </div>
      </div>
    </form>
    </div>

  <div class="right-container">

    <div class="sumario-container">
      <div class="title-container">
       <h2>Resumo do pedido</h2>
      </div>

      <div class="sumario-content">
        <span class="input-label">Subtotal:</span>
        <label class="type-sumario"><?php echo number_format($subtotal,2,",","."); ?></label>
        <br>
        <span class="input-label">Frete:</span>
        <label class="type-sumario">+ <?php echo number_format($frete,2,",","."); ?></label>
        <br>
        <div class="totaspan">
          <span class="input-label input-label-total total">Total do pedido:</span>
          <label class="type-sumario total"><?php echo number_format($total,2,",","."); ?></label>
        </div>              
      </div>
    </div>

    <div class="cart-container">
      <div class="title-container">
       <h2>carrinho</h2>
      </div>
      <div class="sumario-content">
        <?php
        for($i=0;$i<count($_SESSION['cart']);$i+=3){
        ?>
        <div class="product-container">
             
          <div class="product-information">
            <h3 class="product-title"><?php echo $_SESSION['cart'][$i]; ?></h3>
            <h3 class="product-qtde">Qtde: </h3>
            <label class="numer-qtde"><?php echo $_SESSION['cart'][$i+1]; ?></label>
            <h3 class="product-qtde">Preço: </h3>
            <label class="numer-qtde"><?php echo number_format($_SESSION['cart'][$i+2],2,",","."); ?></label>
          </div>

        </div>   
        <?php
        }
        ?>           
        <button onclick="window.location.href='carrinho.php'" type="button" class="edit-cart-btn">Editar carrinho <img src="img/ico/carrinho.png" class="cadastro-ico" alt="carrinho"></button>
      </div>
    </div>

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
    <script type="text/javascript">
      document.getElementById("boleto").onclick = function(){
        document.getElementById("cc").disabled = true;
        document.getElementById("date-card").disabled = true;
        document.getElementById("cvv-card").disabled = true;
        document.getElementById("card-name").disabled = true;
        document.getElementById("parcelas").disabled = true;
        document.getElementById("credit-input").style.backgroundColor = "#5d5d5d";
        document.getElementById("cc").style.backgroundColor = "#5d5d5d";  

        document.getElementById("cc").value = "";
        document.getElementById("date-card").value = "";
        document.getElementById("cvv-card").value = "";
        document.getElementById("card-name").value = "";      
      }
      document.getElementById("cartao").onclick = function(){
        document.getElementById("cc").disabled = false;
        document.getElementById("date-card").disabled = false;
        document.getElementById("cvv-card").disabled = false;
        document.getElementById("card-name").disabled = false;
        document.getElementById("parcelas").disabled = false; 
        document.getElementById("credit-input").style.backgroundColor = "white";
        document.getElementById("cc").style.backgroundColor = "white";         
      }
    </script>
  </body>
</html>