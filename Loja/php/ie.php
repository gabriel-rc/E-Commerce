<?php
function fn_validar_ie($inscricao, $estado) {
	
	if(strtoupper($inscricao) == "ISENTO") { 
		return true;
	}
	else {

		$estado = strtoupper($estado);
		$inscricao = preg_replace("/[^0-9]/", "", $inscricao);
		
		switch ($estado) {
			//Acre
			case 'AC':
				if (strlen($inscricao) != 13){return false;}
				else{
					if(substr($inscricao, 0, 2) != '01'){return false;}
					else{
						$b = 4;
						$soma = 0;
						for ($i=0;$i<=10;$i++){
							$soma += $inscricao[$i] * $b;
							$b--;
							if($b == 1){$b = 9;}
						}
						$dig = 11 - ($soma % 11);
						if($dig >= 10){$dig = 0;}
						if( !($dig == $inscricao[11]) ){return false;}
						else{
							$b = 5;
							$soma = 0;
							for($i=0;$i<=11;$i++){
								$soma += $inscricao[$i] * $b;
								$b--;
								if($b == 1){$b = 9;}
							}
							$dig = 11 - ($soma % 11);
							if($dig >= 10){$dig = 0;}

							return ($dig == $inscricao[12]);
						}
					}
				}
				break;

			// Alagoas
			case 'AL':
				if (strlen($inscricao) != 9){return false;}
				else{
					if(substr($inscricao, 0, 2) != '24'){return false;}
					else{
						$b = 9;
						$soma = 0;
						for($i=0;$i<=7;$i++){
							$soma += $inscricao[$i] * $b;
							$b--;
						}
						$soma *= 10;
						$dig = $soma - ( ( (int)($soma / 11) ) * 11 );
						if($dig == 10){$dig = 0;}

						return ($dig == $inscricao[8]);
					}
				}
				break;

			//Amazonas
			case 'AM':
				if (strlen($inscricao) != 9){return false;}
				else{
					$b = 9;
					$soma = 0;
					for($i=0;$i<=7;$i++){
						$soma += $inscricao[$i] * $b;
						$b--;
					}
					if($soma <= 11){$dig = 11 - $soma;}
					else{
						$r = $soma % 11;
						if($r <= 1){$dig = 0;}
						else{$dig = 11 - $r;}
					}

					return ($dig == $inscricao[8]);
				}
				break;

			//Amapá
			case 'AP':
				if (strlen($inscricao) != 9){return false;}
				else{
					if(substr($inscricao, 0, 2) != '03'){return false;}
					else{
						$i = substr($inscricao, 0, -1);
						if( ($i >= 3000001) && ($i <= 3017000) ){$p = 5; $d = 0;}
						elseif( ($i >= 3017001) && ($i <= 3019022) ){$p = 9; $d = 1;}
						elseif ($i >= 3019023){$p = 0; $d = 0;}

						$b = 9;
						$soma = $p;
						for($i=0;$i<=7;$i++){
							$soma += $inscricao[$i] * $b;
							$b--;
						}
						$dig = 11 - ($soma % 11);
						if($dig == 10){$dig = 0;}
						elseif($dig == 11){$dig = $d;}

						return ($dig == $inscricao[8]);
					}
				}
				break;

			//Bahia
			case 'BA':
				if (strlen($inscricao) != 8){return false;}
				else{

					$arr1 = array('0','1','2','3','4','5','8');
					$arr2 = array('6','7','9');

					$i = substr($inscricao, 0, 1);

					if(in_array($i, $arr1)){$modulo = 10;}
					elseif(in_array($i, $arr2)){$modulo = 11;}

					$b = 7;
					$soma = 0;
					for($i=0;$i<=5;$i++){
						$soma += $inscricao[$i] * $b;
						$b--;
					}

					$i = $soma % $modulo;
					if ($modulo == 10){
						if ($i == 0) { $dig = 0; } else { $dig = $modulo - $i; }
					}else{
						if ($i <= 1) { $dig = 0; } else { $dig = $modulo - $i; }
					}
					if( !($dig == $inscricao[7]) ){return false;}
					else{
						$b = 8;
						$soma = 0;
						for($i=0;$i<=5;$i++){
							$soma += $inscricao[$i] * $b;
							$b--;
						}
						$soma += $inscricao[7] * 2;
						$i = $soma % $modulo;
						if ($modulo == 10){
							if ($i == 0) { $dig = 0; } else { $dig = $modulo - $i; }
						}else{
							if ($i <= 1) { $dig = 0; } else { $dig = $modulo - $i; }
						}

						return ($dig == $inscricao[6]);
					}
				}
				break;

			//Ceará
			case 'CE':
				if (strlen($inscricao) != 9){return false;}
				else{
					$b = 9;
					$soma = 0;
					for($i=0;$i<=7;$i++){
						$soma += $inscricao[$i] * $b;
						$b--;
					}
					$dig = 11 - ($soma % 11);

					if ($dig >= 10){$dig = 0;}

					return ($dig == $inscricao[8]);
				}
				break;

			// Distrito Federal
			case 'DF':
				if (strlen($inscricao) != 13){return false;}
				else{
					if( substr($inscricao, 0, 2) != '07' ){return false;}
					else{
						$b = 4;
						$soma = 0;
						for ($i=0;$i<=10;$i++){
							$soma += $inscricao[$i] * $b;
							$b--;
							if($b == 1){$b = 9;}
						}
						$dig = 11 - ($soma % 11);
						if($dig >= 10){$dig = 0;}

						if( !($dig == $inscricao[11]) ){return false;}
						else{
							$b = 5;
							$soma = 0;
							for($i=0;$i<=11;$i++){
								$soma += $inscricao[$i] * $b;
								$b--;
								if($b == 1){$b = 9;}
							}
							$dig = 11 - ($soma % 11);
							if($dig >= 10){$dig = 0;}

							return ($dig == $inscricao[12]);
						}
					}
				}
				break;

			//Espirito Santo
			case 'ES':
				if (strlen($inscricao) != 9){return false;}
				else{
					$b = 9;
					$soma = 0;
					for($i=0;$i<=7;$i++){
						$soma += $inscricao[$i] * $b;
						$b--;
					}
					$i = $soma % 11;
					if ($i < 2){$dig = 0;}
					else{$dig = 11 - $i;}

					return ($dig == $inscricao[8]);
				}
				break;

			//Goias
			case 'GO':
				if (strlen($inscricao) != 9){return false;}
				else{
					$s = substr($inscricao, 0, 2);

					if( !( ($s == 10) || ($s == 11) || ($s == 15) ) ){return false;}
					else{
						$n = substr($inscricao, 0, 7);

						if($n == 11094402){
							if($inscricao[8] != 0){
								if($inscricao[8] != 1){
									return false;
								}else{return true;}
							}else{return 1;}
						}else{
							$b = 9;
							$soma = 0;
							for($i=0;$i<=7;$i++){
								$soma += $inscricao[$i] * $b;
								$b--;
							}
							$i = $soma % 11;
							if ($i == 0){$dig = 0;}
							else{
								if($i == 1){
									if(($n >= 10103105) && ($n <= 10119997)){$dig = 1;}
									else{$dig = 0;}
								}else{$dig = 11 - $i;}
							}

							return ($dig == $inscricao[8]);
						}
					}
				}
				break;

			// Maranhão
			case 'MA':
				if (strlen($inscricao) != 9){return false;}
				else{
					if(substr($inscricao, 0, 2) != 12){return false;}
					else{
						$b = 9;
						$soma = 0;
						for($i=0;$i<=7;$i++){
							$soma += $inscricao[$i] * $b;
							$b--;
						}
						$i = $soma % 11;
						if ($i <= 1){$dig = 0;}
						else{$dig = 11 - $i;}

						return ($dig == $inscricao[8]);
					}
				}
				break;

			// Mato Grosso
			case 'MT':
				if (strlen($inscricao) != 11){return false;}
				else{
					$b = 3;
					$soma = 0;
					for($i=0;$i<=9;$i++){
						$soma += $inscricao[$i] * $b;
						$b--;
						if($b == 1){$b = 9;}
					}
					$i = $soma % 11;
					if ($i <= 1){$dig = 0;}
					else{$dig = 11 - $i;}

					return ($dig == $inscricao[10]);
				}
				break;

			// Mato Grosso do Sul
			case 'MS':
				if (strlen($inscricao) != 9){return false;}
				else{
					if(substr($inscricao, 0, 2) != 28){return false;}
					else{
						$b = 9;
						$soma = 0;
						for($i=0;$i<=7;$i++){
							$soma += $inscricao[$i] * $b;
							$b--;
						}
						$i = $soma % 11;
						if ($i == 0){$dig = 0;}
						else{$dig = 11 - $i;}

						if($dig > 9){$dig = 0;}

						return ($dig == $inscricao[8]);
					}
				}
				break;

			//Minas Gerais
			case 'MG':
				if (strlen($inscricao) != 13){return false;}
				else{
					$ie2 = substr($inscricao, 0, 3) . '0' . substr($inscricao, 3);

					$b = 1;
					$soma = "";
					for($i=0;$i<=11;$i++){
						$soma .= $ie2[$i] * $b;
						$b++;
						if($b == 3){$b = 1;}
					}
					$s = 0;
					for($i=0;$i<strlen($soma);$i++){
						$s += $soma[$i];
					}
					$i = substr($ie2, 9, 2);
					$dig = $i - $s;
					if($dig != $inscricao[11]){return false;}
					else{
						$b = 3;
						$soma = 0;
						for($i=0;$i<=11;$i++){
							$soma += $inscricao[$i] * $b;
							$b--;
							if($b == 1){$b = 11;}
						}
						$i = $soma % 11;
						if($i < 2){$dig = 0;}
						else{$dig = 11 - $i;};

						return ($dig == $inscricao[12]);
					}
				}
				break;

			//Pará
			case 'PA':
				if (strlen($inscricao) != 9){return false;}
				else{
					if(substr($inscricao, 0, 2) != 15){return false;}
					else{
						$b = 9;
						$soma = 0;
						for($i=0;$i<=7;$i++){
							$soma += $inscricao[$i] * $b;
							$b--;
						}
						$i = $soma % 11;
						if ($i <= 1){$dig = 0;}
						else{$dig = 11 - $i;}

						return ($dig == $inscricao[8]);
					}
				}
				break;

			//Paraíba
			case 'PB':
				if (strlen($inscricao) != 9){return false;}
				else{
					$b = 9;
					$soma = 0;
					for($i=0;$i<=7;$i++){
						$soma += $inscricao[$i] * $b;
						$b--;
					}
					$i = $soma % 11;
					if ($i <= 1){$dig = 0;}
					else{$dig = 11 - $i;}

					if($dig > 9){$dig = 0;}

					return ($dig == $inscricao[8]);
				}
				break;

			//Paraná
			case 'PR':
				if (strlen($inscricao) != 10){return false;}
				else{
					$b = 3;
					$soma = 0;
					for($i=0;$i<=7;$i++){
						$soma += $inscricao[$i] * $b;
						$b--;
						if($b == 1){$b = 7;}
					}
					$i = $soma % 11;
					if ($i <= 1){$dig = 0;}
					else{$dig = 11 - $i;}

					if ( !($dig == $inscricao[8]) ){return false;}
					else{
						$b = 4;
						$soma = 0;
						for($i=0;$i<=8;$i++){
							$soma += $inscricao[$i] * $b;
							$b--;
							if($b == 1){$b = 7;}
						}
						$i = $soma % 11;
						if($i <= 1){$dig = 0;}
						else{$dig = 11 - $i;}

						return ($dig == $inscricao[9]);
					}
				}
				break;

			//Pernambuco
			case 'PE':
				if (strlen($inscricao) == 9){
					$b = 8;
					$soma = 0;
					for($i=0;$i<=6;$i++){
						$soma += $inscricao[$i] * $b;
						$b--;
					}
					$i = $soma % 11;
					if ($i <= 1){$dig = 0;}
					else{$dig = 11 - $i;}

					if ( !($dig == $inscricao[7]) ){return false;}
					else {
						$b = 9;
						$soma = 0;
						for($i=0;$i<=7;$i++){
							$soma += $inscricao[$i] * $b;
							$b--;
						}
						$i = $soma % 11;
						if ($i <= 1){$dig = 0;}
						else{$dig = 11 - $i;}

						return ($dig == $inscricao[8]);
					}
				}
				elseif(strlen($inscricao) == 14){
					$b = 5;
					$soma = 0;
					for($i=0;$i<=12;$i++){
						$soma += $inscricao[$i] * $b;
						$b--;
						if($b == 0){$b = 9;}
					}
					$dig = 11 - ($soma % 11);
					if($dig > 9){$dig = $dig - 10;}

					return ($dig == $inscricao[13]);
				}
				else {
					return false;
				}
				break;

			//Piauí
			case 'PI':
				if (strlen($inscricao) != 9){return false;}
				else{
					$b = 9;
					$soma = 0;
					for($i=0;$i<=7;$i++){
						$soma += $inscricao[$i] * $b;
						$b--;
					}
					$i = $soma % 11;
					if($i <= 1){$dig = 0;}
					else{$dig = 11 - $i;}
					if($dig >= 10){$dig = 0;}

					return ($dig == $inscricao[8]);
				}
				break;

			// Rio de Janeiro
			case 'RJ':
				if (strlen($inscricao) != 8){return false;}
				else{
					$b = 2;
					$soma = 0;
					for($i=0;$i<=6;$i++){
						$soma += $inscricao[$i] * $b;
						$b--;
						if($b == 1){$b = 7;}
					}
					$i = $soma % 11;
					if ($i <= 1){$dig = 0;}
					else{$dig = 11 - $i;}

					return ($dig == $inscricao[7]);
				}
				break;

			//Rio Grande do Norte
			case 'RN':
				if( !( (strlen($inscricao) == 9) || (strlen($inscricao) == 10) ) ){return false;}
				else{
					$b = strlen($inscricao);
					if($b == 9){$s = 7;}
					else{$s = 8;}
					$soma = 0;
					for($i=0;$i<=$s;$i++){
						$soma += $inscricao[$i] * $b;
						$b--;
					}
					$soma *= 10;
					$dig = $soma % 11;
					if($dig == 10){$dig = 0;}

					$s += 1;
					return ($dig == $inscricao[$s]);
				}
				break;

			// Rio Grande do Sul
			case 'RS':
				if (strlen($inscricao) != 10){return false;}
				else{
					$b = 2;
					$soma = 0;
					for($i=0;$i<=8;$i++){
						$soma += $inscricao[$i] * $b;
						$b--;
						if ($b == 1){$b = 9;}
					}
					$dig = 11 - ($soma % 11);
					if($dig >= 10){$dig = 0;}

					return ($dig == $inscricao[9]);
				}
				break;

			// Rondônia
			case 'RO':
				if (strlen($inscricao) == 9){
					$b=6;
					$soma =0;
					for($i=3;$i<=7;$i++){
						$soma += $inscricao[$i] * $b;
						$b--;
					}
					$dig = 11 - ($soma % 11);
					if($dig >= 10){$dig = $dig - 10;}

					return ($dig == $inscricao[8]);
				}
				elseif(strlen($inscricao) == 14){
					$b=6;
					$soma=0;
					for($i=0;$i<=12;$i++) {
						$soma += $inscricao[$i] * $b;
						$b--;
						if($b == 1){$b = 9;}
					}
					$dig = 11 - ( $soma % 11);
					if ($dig > 9){$dig = $dig - 10;}

					return ($dig == $inscricao[13]);
				}
				else{return false;}
				break;

			//Roraima
			case 'RR':
				if (strlen($inscricao) != 9){return false;}
				else{
					if(substr($inscricao, 0, 2) != 24){return false;}
					else{
						$b = 1;
						$soma = 0;
						for($i=0;$i<=7;$i++){
							$soma += $inscricao[$i] * $b;
							$b++;
						}
						$dig = $soma % 9;

						return ($dig == $inscricao[8]);
					}
				}
				break;

			//Santa Catarina
			case 'SC':
				if (strlen($inscricao) != 9){return false;}
				else{
					$b = 9;
					$soma = 0;
					for($i=0;$i<=7;$i++){
						$soma += $inscricao[$i] * $b;
						$b--;
					}
					$dig = 11 - ($soma % 11);
					if ($dig <= 1){$dig = 0;}

					return ($dig == $inscricao[8]);
				}
				break;

			//São Paulo
			case 'SP':
				if( strtoupper( substr($inscricao, 0, 1) )  == 'P' ){
					if (strlen($inscricao) != 13){return false;}
					else{
						$b = 1;
						$soma = 0;
						for($i=1;$i<=8;$i++){
							$soma += $inscricao[$i] * $b;
							$b++;
							if($b == 2){$b = 3;}
							if($b == 9){$b = 10;}
						}
						$dig = $soma % 11;
						return ($dig == $inscricao[9]);
					}
				}else{
					if (strlen($inscricao) != 12){return false;}
					else{
						$b = 1;
						$soma = 0;
						for($i=0;$i<=7;$i++){
							$soma += $inscricao[$i] * $b;
							$b++;
							if($b == 2){$b = 3;}
							if($b == 9){$b = 10;}
						}
						$dig = $soma % 11;
						if($dig > 9){$dig = 0;}

						if($dig != $inscricao[8]){return false;}
						else{
							$b = 3;
							$soma = 0;
							for($i=0;$i<=10;$i++){
								$soma += $inscricao[$i] * $b;
								$b--;
								if($b == 1){$b = 10;}
							}
							$dig = $soma % 11;

							return ($dig == $inscricao[11]);
						}
					}
				}
				break;

			//Sergipe
			case 'SE':
				if (strlen($inscricao) != 9){return false;}
				else{
					$b = 9;
					$soma = 0;
					for($i=0;$i<=7;$i++){
						$soma += $inscricao[$i] * $b;
						$b--;
					}
					$dig = 11 - ($soma % 11);
					if ($dig > 9){$dig = 0;}

					return ($dig == $inscricao[8]);
				}
				break;

			//Tocantins
			case 'TO':
				if (strlen($inscricao) != 11){return false;}
				else{
					$s = substr($inscricao, 2, 2);
					if( !( ($s=='01') || ($s=='02') || ($s=='03') || ($s=='99') ) ){return false;}
					else{
						$b=9;
						$soma=0;
						for($i=0;$i<=9;$i++){
							if( !(($i == 2) || ($i == 3)) ){
								$soma += $inscricao[$i] * $b;
								$b--;
							}
						}
						$i = $soma % 11;
						if($i < 2){$dig = 0;}
						else{$dig = 11 - $i;}

						return ($dig == $inscricao[10]);
					 }
				}
				break;

			default:
				return false;
				break;
		}
	}
}
?>