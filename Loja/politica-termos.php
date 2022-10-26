<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Condições de Uso | Alt Solutions</title>
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
			<div id="termos-content">
				<div class="politica-privacidade">
					<a name="politica"></a><h2>Política de Privacidade</h2>
					<p>A sua privacidade é importante para nós. É política do AltSolutions respeitar a sua privacidade em relação a qualquer informação sua que possamos coletar no site 		AltSolutions, e outros sites que possuímos e operamos.
						Solicitamos informações pessoais apenas quando realmente precisamos delas para lhe fornecer um serviço. Fazemo-lo por meios justos e legais, com o seu conhecimento e consentimento. Também informamos por que estamos coletando e como será usado.
						Apenas retemos as informações coletadas pelo tempo necessário para fornecer o serviço solicitado. Quando armazenamos dados, protegemos dentro de meios comercialmente aceitáveis para evitar perdas e roubos, bem como acesso, divulgação, cópia, uso ou modificação não autorizados.
						Não compartilhamos informações de identificação pessoal publicamente ou com terceiros, exceto quando exigido por lei.
						O nosso site pode ter links para sites externos que não são operados por nós. Esteja ciente de que não temos controle sobre o conteúdo e práticas desses sites e não podemos aceitar responsabilidade por suas respectivas políticas de privacidade.
						Você é livre para recusar a nossa solicitação de informações pessoais, entendendo que talvez não possamos fornecer alguns dos serviços desejados.
						O uso continuado de nosso site será considerado como aceitação de nossas práticas em torno de privacidade e informações pessoais. Se você tiver alguma dúvida sobre como lidamos com dados do usuário e informações pessoais, entre em contacto conosco.
						<h3>Compromisso do Usuário</h3>
						O usuário se compromete a fazer uso adequado dos conteúdos e da informação que o AltSolutions oferece no site e com caráter enunciativo, mas não limitativo:
						A) Não se envolver em atividades que sejam ilegais ou contrárias à boa fé a à ordem pública;
						B) Não difundir propaganda ou conteúdo de natureza racista, xenofóbica, Onde Bola ou azar, qualquer tipo de pornografia ilegal, de apologia ao terrorismo ou contra os direitos humanos;
						C) Não causar danos aos sistemas físicos (hardwares) e lógicos (softwares) do AltSolutions, de seus fornecedores ou terceiros, para introduzir ou disseminar vírus informáticos ou quaisquer outros sistemas de hardware ou software que sejam capazes de causar danos anteriormente mencionados.
					</p>
				</div>
				<div class="termos-uso">
					<a name="termos"></a><h2>Termos de Uso</h2>
					<p>
						<h3>1. Termos</h3>
						Ao acessar ao site AltSolutions, concorda em cumprir estes termos de serviço, todas as leis e regulamentos aplicáveis e concorda que é responsável pelo cumprimento de todas as leis locais aplicáveis. Se você não concordar com algum desses termos, está proibido de usar ou acessar este site. Os materiais contidos neste site são protegidos pelas leis de direitos autorais e marcas comerciais aplicáveis.
						<h3>2. Uso de Licença</h3>
						É concedida permissão para baixar temporariamente uma cópia dos materiais (informações ou software) no site AltSolutions , apenas para visualização transitória pessoal e não comercial. Esta é a concessão de uma licença, não uma transferência de título e, sob esta licença, você não pode: 
						1.	modificar ou copiar os materiais; 
						2.	usar os materiais para qualquer finalidade comercial ou para exibição pública (comercial ou não comercial); 
						3.	tentar descompilar ou fazer engenharia reversa de qualquer software contido no site AltSolutions; 
						4.	remover quaisquer direitos autorais ou outras notações de propriedade dos materiais; ou 
						5.	transferir os materiais para outra pessoa ou espelhar os materiais em qualquer outro servidor.
						Esta licença será automaticamente rescindida se você violar alguma dessas restrições e poderá ser rescindida por AltSolutions a qualquer momento. Ao encerrar a visualização desses materiais ou após o término desta licença, você deve apagar todos os materiais baixados em sua posse, seja em formato eletrônico ou impresso.
						<h3>3. Isenção de responsabilidade</h3>
						1.	Os materiais no site da AltSolutions são fornecidos 'como estão'. AltSolutions não oferece garantias, expressas ou implícitas, e, por este meio, isenta e nega todas as outras garantias, incluindo, sem limitação, garantias implícitas ou condições de comercialização, adequação a um fim específico ou não violação de propriedade intelectual ou outra violação de direitos.
						2.	Além disso, o AltSolutions não garante ou faz qualquer representação relativa à precisão, aos resultados prováveis ou à confiabilidade do uso dos materiais em seu site ou de outra forma relacionado a esses materiais ou em sites vinculados a este site.
						<h3>4. Limitações</h3>
						Em nenhum caso o AltSolutions ou seus fornecedores serão responsáveis por quaisquer danos (incluindo, sem limitação, danos por perda de dados ou lucro ou devido a interrupção dos negócios) decorrentes do uso ou da incapacidade de usar os materiais em AltSolutions, mesmo que AltSolutions ou um representante autorizado da AltSolutions tenha sido notificado oralmente ou por escrito da possibilidade de tais danos. Como algumas jurisdições não permitem limitações em garantias implícitas, ou limitações de responsabilidade por danos conseqüentes ou incidentais, essas limitações podem não se aplicar a você.
						<h3>5. Precisão dos materiais</h3>
						Os materiais exibidos no site da AltSolutions podem incluir erros técnicos, tipográficos ou fotográficos. AltSolutions não garante que qualquer material em seu site seja preciso, completo ou atual. AltSolutions pode fazer alterações nos materiais contidos em seu site a qualquer momento, sem aviso prévio. No entanto, AltSolutions não se compromete a atualizar os materiais.
						<h3>6. Links</h3>
						O AltSolutions não analisou todos os sites vinculados ao seu site e não é responsável pelo conteúdo de nenhum site vinculado. A inclusão de qualquer link não implica endosso por AltSolutions do site. O uso de qualquer site vinculado é por conta e risco do usuário.
						Modificações
						O AltSolutions pode revisar estes termos de serviço do site a qualquer momento, sem aviso prévio. Ao usar este site, você concorda em ficar vinculado à versão atual desses termos de serviço.
						Lei aplicável
						Estes termos e condições são regidos e interpretados de acordo com as leis do AltSolutions e você se submete irrevogavelmente à jurisdição exclusiva dos tribunais naquele estado ou localidade.
					</p>
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