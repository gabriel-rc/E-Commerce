	<!-- cadastro de contas cliente --> 
<?php 
include("connection.php");
require "php/ie.php";

function validaCPF($cpf) {

    // Extrai somente os números
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

	/* recebe dados do formulário */
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	/* cadastra no banco ao clicar no botão se não for vazio */
if(!empty($dados['cadUsuario'])){
	$empty_input = false;

		/* remove do array todos os espaços em branco antes e depois. */
	$dados = array_map('trim', $dados);	

		/* indica que recebeu campo vazio dos input */
	if(in_array("", $dados)){
		$empty_input = true;
	}elseif(!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)){	/* verifica se o email possui .com.br */
		$empty_input = true;
		?>
		<script type="text/javascript">
			alert("Informe um e-mail válido!");
		</script>
		
		<?php
	}
		/* verifica se o CPF ja esta cadastrado */
	$stmt = $conn->prepare("SELECT * from PF WHERE cpf=?");
	$stmt -> bindValue(1 , $dados['cpf']);
	$stmt->execute(); 
	$count = $stmt->rowcount();

		/* verifica se o CNPJ ja esta cadastrado */
	$stmt2 = $conn->prepare("SELECT * from PJ WHERE cnpj=?");
	$stmt2 -> bindValue(1 , $dados['cpf']);
	$stmt2->execute(); 
	$count2 = $stmt2->rowcount();

		/* verifica se o email ja esta cadastrado */
	$stmt3 = $conn->prepare("SELECT * from Cliente WHERE email=?");
	$stmt3 -> bindValue(1 , $dados['email']);
	$stmt3->execute(); 
	$count3 = $stmt3->rowcount();

	if( $count > 0 )	//Se o cpf ja estiver no BD ele não cadastra
	{
	  ?>
	 	<script type="text/javascript">
			alert("Esse CPF já se encontra cadastrado!\nPor favor, insira um válido.");
		</script>
	   <?php  
	}
	elseif($count2 > 0){
		//Se o CNPJ estiver cadastrado no BD ele não cria a conta.
		{
	 		 ?>
	 		<script type="text/javascript">
				alert("Esse CNPJ já se encontra cadastrado!\nPor favor, insira um válido.");
			</script>
	  	 <?php  
		}
	}
	elseif($count3 > 0){
		//Se o email ja estiver no BD ele não cadastra
		{
	 		 ?>
	 		<script type="text/javascript">
				alert("Esse E-mail já se encontra cadastrado!\nPor favor, insira um válido.");
			</script>
	  	 <?php  
		}
	}	
	else{
		if(($dados['radio-group'] == 'Pessoa-Juridica') and (!isset($_POST['check-insento'])) and (fn_validar_ie($dados['inscricao'], $dados['estado']) === false)){
			?>
			<script type="text/javascript">
				alert("Inscrição Estadual inválida, por favor, insira novamente!");
			</script>
			<?php 
		}
		
		elseif($empty_input){
			/* cadastro no BD	*/
		$dados['senha'] = password_hash($dados['senha'], PASSWORD_BCRYPT);
		$query_cliente = "INSERT INTO Cliente (email, senha) VALUES ('" . $dados['email'] . "', '" . $dados['senha'] . "')";
		$query_tcep = "INSERT INTO tCEP (cep, endereco, cidade, bairro, uf) VALUES ('" . $dados['cep'] . "', '" . $dados['endereco'] . "', '" . $dados['cidade'] . "', '" . $dados['bairro'] . "', '" . $dados['estado'] . "')";
		
		$cad_cliente = $conn->prepare($query_cliente);
		$cad_cliente->execute();

		$last_id = $conn->lastInsertId();

		$cad_cliente = $conn->prepare($query_tcep);
		$cad_cliente->execute();

		$query_endereco = "INSERT INTO Endereco (clienteID, cep, num, complemento) VALUES ('" . $last_id . "', '" . $dados['cep'] . "', '" . $dados['num'] . "', '" . $dados['complemento'] . "')";

		$query_enderecoF = "INSERT INTO Endereco (clienteID, cep, num, complemento) VALUES ('" . $last_id . "', '" . $dados['cep'] . "', '" . $dados['num'] . "', '" . $dados['complemento'] . "')";

		$query_telefone = "INSERT INTO Telefone (clienteID, telefone) VALUES ('" . $last_id . "', '" .  preg_replace( '/[^0-9]/is', '',$dados['telefone']) . "')";

			/* Radio = Pessoa Física, grava na tb PF */
		if ($dados['radio-group'] == 'Pessoa-Fisica'){
			// valida o cpf pelo back end
			if (validaCPF($dados['cpf']) === false) {
				?>
			 	<script type="text/javascript">
					alert("CPF inválido, por favor, insira novamente!");
				</script>
			   <?php  
			}else{
				$query_fisica = "INSERT INTO PF (clienteID, cpf, nome, datanasc) VALUES ('" . $last_id . "', '" . preg_replace( '/[^0-9]/is', '', $dados['cpf'] ). "', '" . $dados['nome'] . "', '" . $dados['data-nasc'] . "')";
				$cad_cliente = $conn->prepare($query_fisica);
				$cad_cliente->execute();

				$cad_cliente = $conn->prepare($query_endereco);
				$cad_cliente->execute();

				$cad_cliente = $conn->prepare($query_telefone);
				$cad_cliente->execute();
				
				$query_espec = "UPDATE Cliente SET espec ='F' WHERE clienteID='" . $last_id . "'";
				$cad_cliente = $conn->prepare($query_espec);
				$cad_cliente->execute();
			}
		}else{
			/* Radio = Pessoa Jurídica, grava na tb PJ */
			if (isset($_POST['check-insento'])){	// Se for isento, grava no BD como isento.
				$query_fisica2 = "INSERT INTO PJ (clienteID, cnpj, ie, razaoSoc) VALUES ('" . $last_id . "', '" . preg_replace( '/[^0-9]/is', '', $dados['cpf'] ) . "', '" . "Isento" . "', '" . $dados['razaoSoc'] . "')";
				$cad_cliente = $conn->prepare($query_fisica2);
				$cad_cliente->execute();
			}else{
				$query_fisica2 = "INSERT INTO PJ (clienteID, cnpj, ie, razaoSoc) VALUES ('" . $last_id . "', '" . preg_replace( '/[^0-9]/is', '', $dados['cpf'] ) . "', '" .  preg_replace( '/[^0-9]/is', '',$dados['inscricao']) . "', '" . $dados['razaoSoc'] . "')";
				$cad_cliente = $conn->prepare($query_fisica2);
				$cad_cliente->execute();
			}
			
			$cad_cliente = $conn->prepare($query_enderecoF);
			$cad_cliente->execute();

			$cad_cliente = $conn->prepare($query_telefone);
			$cad_cliente->execute();
			$query_espec = "UPDATE Cliente SET espec ='J' WHERE clienteID='" . $last_id . "'";
				$cad_cliente = $conn->prepare($query_espec);
				$cad_cliente->execute();
		}
			/* destroi os dados dos inputs se foi cadastrado com sucesso */
		if($cad_cliente->rowCount()){
			unset($dados);
			?>
			<script type="text/javascript">
				alert("Conta cadastrada com sucesso!");
			</script>
			<?php
		}
	}
	}	
}
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Criar conta | Alt Solutions</title>
		<link rel="stylesheet" type="text/css" href="css/estilo.css">
		<link rel="stylesheet" type="text/css" href="css/normalize.css">
		<script src="js/ie.js"></script>
		<script type="text/javascript" src="js/ajax.js"></script>
		<link rel="icon" href="favicon.png">
		<script type="text/javascript">
			/* Máscara telefone */
		function mascara(o,f){
		    v_obj=o
		    v_fun=f
		    setTimeout("execmascara()",1)
		}
		function execmascara(){
		    v_obj.value=v_fun(v_obj.value)
		}
		function mtel(v){
		    v=v.replace(/\D/g,""); //Remove tudo o que não é dígito
		    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parenteses em volta dos dois primeiros dígitos
		    v=v.replace(/(\d)(\d{4})$/,"$1-$2"); //Coloca hífen entre o quarto e o quinto dígitos
		    return v;
		}
		function id( el ){
			return document.getElementById( el );
		}
		window.onload = function(){
			id('telefone').onkeyup = function(){
				mascara( this, mtel );
			}
		}
			/* Máscara CPF/CNPJ */
		function formatarCampo(campoTexto) {
		    if (campoTexto.value.length <= 11) {
		        campoTexto.value = mascaraCpf(campoTexto.value);
		    } else {
		        campoTexto.value = mascaraCnpj(campoTexto.value);
		    }
		}
		function retirarFormatacao(campoTexto) {
		    campoTexto.value = campoTexto.value.replace(/(\.|\/|\-)/g,"");
		}
		function mascaraCpf(valor) {
		    return valor.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g,"\$1.\$2.\$3\-\$4");
		}
		function mascaraCnpj(valor) {
		    return valor.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/g,"\$1.\$2.\$3\/\$4\-\$5");
		}
			/* Exibir Senha input */
		function mouseoverPass(obj) {
		  var obj = document.getElementById('senha');
		  obj.type = "text";
		}
		function mouseoutPass(obj) {
		  var obj = document.getElementById('senha');
		  obj.type = "password";
		}
	    function mouseoverPassConfirm(obj) {
		  var obj = document.getElementById('senha-confirm');
		  obj.type = "text";
		}
		function mouseoutPassConfirm(obj) {
		  var obj = document.getElementById('senha-confirm');
		  obj.type = "password";
		}
	    		/* verifica CPF/CNPJ */
	    	function validaCpfCnpj(val) {
		    if (val.length == 14) {
		        var cpf = val.trim();
		     
		        cpf = cpf.replace(/\./g, '');
		        cpf = cpf.replace('-', '');
		        cpf = cpf.split('');
		        
		        var v1 = 0;
		        var v2 = 0;
		        var aux = false;
		        
		        for (var i = 1; cpf.length > i; i++) {
		            if (cpf[i - 1] != cpf[i]) {
		                aux = true;   
		            }
		        } 
		        
		        if (aux == false) {
		            return false; 
		        } 
		        
		        for (var i = 0, p = 10; (cpf.length - 2) > i; i++, p--) {
		            v1 += cpf[i] * p; 
		        } 
		        
		        v1 = ((v1 * 10) % 11);
		        
		        if (v1 == 10) {
		            v1 = 0; 
		        }
		        
		        if (v1 != cpf[9]) {
		            return false; 
		        } 
		        
		        for (var i = 0, p = 11; (cpf.length - 1) > i; i++, p--) {
		            v2 += cpf[i] * p; 
		        } 
		        
		        v2 = ((v2 * 10) % 11);
		        
		        if (v2 == 10) {
		            v2 = 0; 
		        }
		        
		        if (v2 != cpf[10]) {
		            return false; 
		        } else {   
		            return true; 
		        }
		    } else if (val.length == 18) {
		        var cnpj = val.trim();
		        
		        cnpj = cnpj.replace(/\./g, '');
		        cnpj = cnpj.replace('-', '');
		        cnpj = cnpj.replace('/', ''); 
		        cnpj = cnpj.split(''); 
		        
		        var v1 = 0;
		        var v2 = 0;
		        var aux = false;
		        
		        for (var i = 1; cnpj.length > i; i++) { 
		            if (cnpj[i - 1] != cnpj[i]) {  
		                aux = true;   
		            } 
		        } 
		        
		        if (aux == false) {  
		            return false; 
		        }
		        
		        for (var i = 0, p1 = 5, p2 = 13; (cnpj.length - 2) > i; i++, p1--, p2--) {
		            if (p1 >= 2) {  
		                v1 += cnpj[i] * p1;  
		            } else {  
		                v1 += cnpj[i] * p2;  
		            } 
		        } 
		        
		        v1 = (v1 % 11);
		        
		        if (v1 < 2) { 
		            v1 = 0; 
		        } else { 
		            v1 = (11 - v1); 
		        } 
		        
		        if (v1 != cnpj[12]) {  
		            return false; 
		        } 
		        
		        for (var i = 0, p1 = 6, p2 = 14; (cnpj.length - 1) > i; i++, p1--, p2--) { 
		            if (p1 >= 2) {  
		                v2 += cnpj[i] * p1;  
		            } else {   
		                v2 += cnpj[i] * p2; 
		            } 
		        }
		        
		        v2 = (v2 % 11); 
		        
		        if (v2 < 2) {  
		            v2 = 0;
		        } else { 
		            v2 = (11 - v2); 
		        } 
		        
		        if (v2 != cnpj[13]) {   
		            return false; 
		        } else {  
		            return true; 
		        }
		    } else {
		        return false;
		    }
		 }
		 	/* Mensagem se inválido CPF/CNPJ */
		 function validarCPFCNPJ(el){
			if( !validaCpfCnpj(el.value) ){
				alert("CPF/CNPJ " + el.value + " inválido!");
				// apaga o valor
				el.value = "";
			}
		}
			/* Verifica as senhas se são iguais */
		function validarSenha() {
		  var senha1 = document.getElementById("senha");
		  var senha2 = document.getElementById("senha-confirm");
		  var s1 = senha1.value;
		  var s2 = senha2.value;
		  if (s1 != s2) {
		    alert("Senhas diferentes, verifique o valor digitado.");
		    return false;
		  } else 
		    	return true;
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
				/* apenas números */
			function onlynumber(evt) {
			   var theEvent = evt || window.event;
			   var key = theEvent.keyCode || theEvent.which;
			   key = String.fromCharCode( key );
			   //var regex = /^[0-9.,]+$/;
			   var regex = /^[0-9.]+$/;
			   if( !regex.test(key) ) {
			      theEvent.returnValue = false;
			      if(theEvent.preventDefault) theEvent.preventDefault();
			   }
			}
			function valida_ie() {
			    var inscricao = document.getElementById('inscricao').value;
			    var estado = document.getElementById('estado').value;

			    if(inscricao == ""){
			    }
			    else{
				    if (CheckIE(inscricao, estado)){

				    }else{
				        alert('A Inscrição Estadual informada está incorreta!');
				        document.getElementById('inscricao').value='';
				    }
			    }

			}
			function TestaLogin(){

            $.ajax({ 
                url: 'criar-conta.php', 
                type: 'POST',
                dataType:'json',                
                data: {"Cpf" : $("#cpf").val()}, 
                success: function(data) { 

                /*** Não faz nada pois está ok*/
           		} 


        }); 

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
						?>
			            	<li><a href="login.php" class="default-btn">Login</a></li>
						<?php 
							}else{
								header ("Location: cliente-page.php");
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
			<section>
				<div class="creat-account-container">
					<div class="minibanner-creat-account">
						<img class="img-creat-account" src="img/banner-creat-account2.png" alt="pessoa com notebook">
						<img class="img-creat-account box-creat-account" src="img/box-creat-account.png" alt="Caixa">
						<img class="img-creat-account truck-creat-account" src="img/caminhao.png" alt="Caminhao">
					</div>
					<div class="creat-account-content">
						
						<form class="form-criar-conta" action="criar-conta.php" method="POST">
							<h1>Crie sua conta</h1>
							<input type="text" name="nome" placeholder="Nome*" value="<?php 
							if (isset($dados['nome'])) {
								echo $dados['nome'];
							}
							?>" required>
							<input type="email" name="email" placeholder="E-mail*" value="<?php 
							if (isset($dados['email'])) {
								echo $dados['email'];
							}
							?>" required>
							<input type="date" name="data-nasc" max="2100-12-31" min="1399-01-01" value="<?php 
							if (isset($dados['data-nasc'])) {
								echo $dados['data-nasc'];
							}
							?>" required>
							<input type="text" name="endereco" placeholder="Endereço*" value="<?php 
							if (isset($dados['endereco'])) {
								echo $dados['endereco'];
							}
							?>"required>
							<div class="endereco-div">
								<input type="text" name="cep" placeholder="CEP*" id="cep-form" maxlength="9"  onblur="getDados()" onkeydown="javascript: fMasc( this, mCEP );" required>
								<input type="text" name="num" placeholder="Núm*" id="num-form" onkeypress="return onlynumber();" maxlength="5" value="<?php 
							if (isset($dados['num'])) {
								echo $dados['num'];
							}
							?>"required>
								<input type="text" name="complemento" placeholder="Complemento" id="comp-form" value="<?php 
							if (isset($dados['complemento'])) {
								echo $dados['complemento'];
							}
							?>">
							</div>
							<div class="uf-city">
								<select id="estado" name="estado" value="<?php 
							if (isset($dados['estado'])) {
								echo $dados['estado'];
							}
							?>">
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
								<input type="text" name="cidade" placeholder="Cidade*" id="city-element"  value="<?php 
							if (isset($dados['cidade'])) {
								echo $dados['cidade'];
							}
							?>"required>
								<input type="text" name="bairro" placeholder="Bairro*" value="<?php 
							if (isset($dados['bairro'])) {
								echo $dados['bairro'];
							}
							?>" required>
							</div>
							<input type="text" name="telefone" id="telefone" placeholder="Telefone*"  minlength="14" maxlength="15"  value="<?php 
							if (isset($dados['telefone'])) {
								echo $dados['telefone'];
							}
							?>"required>
							<div class="radio-div">
							  <input type="radio" id="pessoa-fisica" name="radio-group" value="Pessoa-Fisica" checked >
							  <label for="pessoa-fisica">Pessoa Física</label>
							  <input type="radio" id="pessoa-juridica" name="radio-group" value="Pessoa-Juridica">
							  <label for="pessoa-juridica">Pessoa Jurídica</label>
							</div>
							<input type="text" name="cpf" onfocus="javascript: retirarFormatacao(this);" onblur="javascript: formatarCampo(this); javascript:  validarCPFCNPJ(this);" maxlength="18" placeholder="CPF/CNPJ*" value="<?php 
							if (isset($dados['cpf'])) {
								echo $dados['cpf'];
							}
							?>" required />
							<div id="inscricao-pj">
								<input type="text" name="ie" id="ie" placeholder="Inscrição estadual*"/>
							</div>
							<div id="inscricao-juridica">
								<input type="text" name="inscricao" id="inscricao" placeholder="Inscrição estadual*"  onblur="valida_ie();"/>
								<div id="isenção-div">
									<input type="checkbox" name="check-insento" id="check-insento" onclick="desabilitar(this.checked)">
									<label for="check-insento">Isento</label>
								</div>
								<input type="text" name="razaoSoc" id="razaoSoc" placeholder="Razao Social*"/>
							</div>
							
							<div class="password-div">
								<input type="password" name="senha" id="senha" placeholder="Senha*" minlength="8" required>
								<img class="eye-form" src="img/ico/eye.png" onmouseover="mouseoverPass();" onmouseout="mouseoutPass();"/>
							</div>
							<div class="password-div-confirm">
								<input type="password" name="senha-confirm" id="senha-confirm" placeholder="Confirme a senha*" minlength="8" onblur="validatePassword(this)" required>
								<img class="eye-form" src="img/ico/eye.png" onmouseover="mouseoverPassConfirm();" onmouseout="mouseoutPassConfirm();"/>
							</div>
							<input type="submit" value="Criar Conta" name="cadUsuario" onclick="return validarSenha()">
							<div id="politicas-div">
								<p>Ao criar uma conta, você concorda com as Condições de Uso da AltSolutions. Por favor verifique a <a href="politica-termos.php#politica" class="politicas-link">Política de Privacidade</a> e os <a href="politica-termos.php#termos" class="politicas-link">Termos de Uso.</a></p>
							</div>
							<a href="login.php" class="login-link criar-conta-link">Já possui conta? <strong>Faça login!</strong></a>
						</form>
					</div>
				</div>
			</section>
		</main>
		<footer>
			<div class="footer footer-conta">
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
			/* acrescenta input IE caso selecione PJ */
			document.getElementById("pessoa-juridica").onclick = function(){
				document.getElementById("inscricao-juridica").style.display = "block";
			}
			document.getElementById("pessoa-fisica").onclick = function(){
				document.getElementById("inscricao-juridica").style.display = "none";
				document.getElementById("inscricao").value='';
				document.getElementById("razaoSoc").value='';
				document.getElementById("check-insento").checked = false;
				document.getElementById('inscricao').disabled = false;
			}
			// desativa campo IE se checkbo ativa
			function desabilitar(selecionado) {
				document.getElementById("inscricao").value='';
			    document.getElementById('inscricao').disabled = selecionado;
			}
		</script>
	</body>
</html>