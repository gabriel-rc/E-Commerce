
var OrdZero = '0'.charCodeAt(0);

function CharToInt(ch)
{
return ch.charCodeAt(0) - OrdZero;
}

function IntToChar(intt)
{
return String.fromCharCode(intt + OrdZero);
}

function CheckIEAC(inscricao){
if (inscricao.length != 13)
return false;
var b = 4, soma = 0;

for (var i = 0; i <= 10; i++)
{
soma += CharToInt(inscricao.charAt(i)) * b;
--b;
if (b == 1) { b = 9; }
}
dig = 11 - (soma % 11);
if (dig >= 10) { dig = 0; }
resultado = (IntToChar(dig) == inscricao.charAt(11));
if (!resultado) { return false; }

b = 5;
soma = 0;
for (var i = 0; i <= 11; i++)
{
soma += CharToInt(inscricao.charAt(i)) * b;
--b;
if (b == 1) { b = 9; }
}
dig = 11 - (soma % 11);
if (dig >= 10) { dig = 0; }
if (IntToChar(dig) == inscricao.charAt(12)) { return true; } else { return false; }
} //AC

function CheckIEAL(inscricao)
{
if (inscricao.length != 9)
  return false;
var b = 9, soma = 0;
for (var i = 0; i <= 7; i++)
{
   soma += CharToInt(inscricao.charAt(i)) * b;
   --b;
}
soma *= 10;
dig = soma - Math.floor(soma / 11) * 11;
if (dig == 10) { dig = 0; }
return (IntToChar(dig) == inscricao.charAt(8));
} //AL

function CheckIEAM(inscricao)
{
if (inscricao.length != 9)
  return false;
var b = 9, soma = 0;
for (var i = 0; i <= 7; i++)
{
  soma += CharToInt(inscricao.charAt(i)) * b;
  b--;
}
if (soma < 11) { dig = 11 - soma; } 
else { 
   i = soma % 11;
   if (i <= 1) { dig = 0; } else { dig = 11 - i; }
}
return (IntToChar(dig) == inscricao.charAt(8));
} //am

function CheckIEAP(inscricao)
{
if (inscricao.length != 9)
  return false;
var p = 0, d = 0, i = inscricao.substring(1, 8);
if ((i >= 3000001) && (i <= 3017000))
{
  p =5;
  d = 0;
}
else if ((i >= 3017001) && (i <= 3019022))
{
  p = 9;
  d = 1;
}
b = 9;
soma = p;
for (var i = 0; i <= 7; i++)
{
  soma += CharToInt(inscricao.charAt(i)) * b;
  b--;
}
dig = 11 - (soma % 11);
if (dig == 10)
{
   dig = 0;
}
else if (dig == 11)
{
   dig = d;
}
return (IntToChar(dig) == inscricao.charAt(8));
} //ap

function CheckIEBA(inscricao)
{
if (inscricao.length != 8)
  return false;
die = inscricao.substring(0, 8);
var nro = new Array(8);
var dig = -1;
for (var i = 0; i <= 7; i++)
{
  nro[i] = CharToInt(die.charAt(i));
}
var NumMod = 0;
if (String(nro[0]).match(/[0123458]/))
   NumMod = 10;
else
   NumMod = 11;
b = 7;
soma = 0;
for (i = 0; i <= 5; i++)
{
  soma += nro[i] * b;
  b--;
}
i = soma % NumMod;
if (NumMod == 10)
{
  if (i == 0) { dig = 0; } else { dig = NumMod - i; }
}
else
{
  if (i <= 1) { dig = 0; } else { dig = NumMod - i; }
}
resultado = (dig == nro[7]);
if (!resultado) { return false; }
b = 8;
soma = 0;
for (i = 0; i <= 5; i++)
{
  soma += nro[i] * b;
  b--;
}
soma += nro[7] * 2;
i = soma % NumMod;
if (NumMod == 10)
{
  if (i == 0) { dig = 0; } else { dig = NumMod - i; }
}
else 
{
  if (i <= 1) { dig = 0; } else { dig = NumMod - i; }
}
return (dig == nro[6]);
} //ba

function CheckIECE(inscricao)
{
if (inscricao.length > 9)
  return false;
die = inscricao;
if (inscricao.length < 9)
{
  while (die.length <= 8)
   die = '0' + die;
}
var nro = Array(9);
for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(die[i]);
b = 9;
soma = 0;
for (i = 0; i <= 7; i++)
{
  soma += nro[i] * b;
  b--; 
}
dig = 11 - (soma % 11);
if (dig >= 10)
  dig = 0;
return (dig == nro[8]);
} //ce

function CheckIEDF(inscricao)
{
if (inscricao.length != 13)
  return false;
var nro = new Array(13);
for (var i = 0; i <= 12; i++)
  nro[i] = CharToInt(inscricao.charAt(i));
b = 4;
soma = 0;
for (i = 0; i <= 10; i++)
{
  soma += nro[i] * b;
  b--;
  if (b == 1)
   b = 9;
}
dig = 11 - (soma % 11);
if (dig >= 10)
  dig = 0;
resultado = (dig == nro[11]);
if (!resultado)
  return false;  
b = 5;
soma = 0;
for (i = 0; i <= 11; i++)
{
  soma += nro[i] * b;
  b--;
  if (b == 1)
   b = 9;
}
dig = 11 - (soma % 11);
if (dig >= 10)
  dig = 0;
return (dig == nro[12]);
}
// CHRISTOPHE T. C. <wG @ codingz.info>
function CheckIEES(inscricao)
{
if (inscricao.length != 9)
  return false;
var nro = new Array(9);
for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(inscricao.charAt(i)); 
b = 9;
soma = 0;
for (i = 0; i <= 7; i++)
{
  soma += nro[i] * b;
  b--;
}
i = soma % 11;
if (i < 2)
  dig = 0;
else
  dig = 11 - i;
return (dig == nro[8]);
}

function CheckIEGO(inscricao)
{
if (inscricao.length != 9)
  return false;
s = inscricao.substring(0, 2);
if ((s == '10') || (s == '11') || (s == '15'))
{
  var nro = new Array(9);
  for (var i = 0; i <= 8; i++)
   nro[i] = CharToInt(inscricao.charAt(i));
  n = Math.floor(inscricao / 10);
  if (n = 11094402)
  {
   if ((nro[8] == 0) || (nro[8] == 1))
return true;
  }
  b = 9;
  soma = 0;
  for (i = 0; i <= 7; i++)
  {
   soma += nro[i] * b;
   b--;
  }
  i = soma % 11;
  if (i == 0)
   dig = 0;
  else
  {
   if (i == 1)
   {
if ((n >= 10103105) && (n <= 10119997))
  dig = 1;
else
  dig = 0;
   }
   else
dig = 11 - i;
  }
  return (dig == nro[8]);
}
}

function CheckIEMA(inscricao)
{
if (inscricao.length != 9)
  return false;
var nro = new Array(9); 
for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(inscricao.charAt(i));
b = 9;
soma = 0;
for (i = 0; i <= 7; i++)
{
  soma += nro[i] * b;
  b--;
}
i = soma % 11;
if (i <= 1)
  dig = 0;
else
  dig = 11 - i;
return (dig == nro[8]);
}

function CheckIEMT(inscricao)
{
if (inscricao.length < 9)
  return false;
die = inscricao;
if (die.length < 11)
{
  while (die.length <= 10)
   die = '0' + die;
  var nro = new Array(11);
  for (var i = 0; i <= 10; i++)
   nro[i] = CharToInt(die[i]);
  b = 3;
  soma = 0;
  for (i = 0; i <= 9; i++)
  {
   soma += nro[i] * b;
   b--;
   if (b == 1)
b = 9;
  }
  i = soma % 11;
  if (i <= 1)
   dig = 0;
  else
   dig = 11 - i;
  return (dig == nro[10]);
}
} //muito

function CheckIEMS(inscricao)
{
if (inscricao.length != 9)
  return false;
if (inscricao.substring(0,2) != '28')
  return false;
var nro = new Array(9);
for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(inscricao.charAt(i));
b = 9;
soma = 0;
for (i = 0; i <= 7; i++)
{
  soma += nro[i] * b;
  b--;
}
i = soma % 11;
if (i <= 1)
  dig = 0;
else
  dig = 11 - i;
return (dig == nro[8]);
} //ms

function CheckIEPA(inscricao)
{
if (inscricao.length != 9)
  return false;
if (inscricao.substring(0, 2) != '15')
  return false;
var nro = new Array(9);
for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(inscricao.charAt(i));
b = 9;
soma = 0;
for (i = 0; i <= 7; i++)
{
  soma += nro[i] * b;
  b--;
}
i = soma % 11;
if (i <= 1)
  dig = 0;
else
  dig = 11 - i;
return (dig == nro[8]);
} //pra

function CheckIEPB(inscricao)
{
if (inscricao.length != 9)
  return false;
var nro = new Array(9);
for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(inscricao.charAt(i));
b = 9;
soma = 0;
for (i = 0; i <= 7; i++)
{
  soma += nro[i] * b;
  b--;  
}
i = soma % 11;
if (i <= 1)
  dig = 0;
else
  dig = 11 - i;
return (dig == nro[8]);
} //pb

function CheckIEPR(inscricao)
{
if (inscricao.length != 10)
  return false;
var nro = new Array(10);
for (var i = 0; i <= 9; i++)
  nro[i] = CharToInt(inscricao.charAt(i));
b = 3;
soma = 0;
for (i = 0; i <= 7; i++)
{
  soma += nro[i] * b;
  b--;
  if (b == 1)
   b = 7;
}
i = soma % 11;
if (i <= 1)
  dig = 0;
else
  dig = 11 - i;
resultado = (dig == nro[8]);
if (!resultado)
  return false;
b = 4;
soma = 0;
for (i = 0; i <= 8; i++)
{
  soma += nro[i] * b;
  b--;
  if (b == 1)
   b = 7;
}
i = soma % 11;
if (i <= 1)
  dig = 0;
else
  dig = 11 - i;
return (dig == nro[9]);
} //pr

function CheckIEPE(inscricao)
{
if (inscricao.length != 14)
  return false;
var nro = new Array(14);
for (var i = 0; i <= 13; i++)
  nro[i] = CharToInt(inscricao.charAt(i));
b = 5;
soma = 0;
for (i = 0; i <= 12; i++)
{
  soma += nro[i] * b;
  b--;
  if (b == 0)
   b = 9;
}
dig = 11 - (soma % 11);
if (dig > 9)
  dig = dig - 10;
return (dig == nro[13]);
} //pe

function CheckIEPI(inscricao)
{
if (inscricao.length != 9)
  return false;
var nro = new Array(9);
for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(inscricao.charAt(i));
b = 9;
soma = 0;
for (i = 0; i <= 7; i++)
{
  soma += nro[i] * b;
  b--;
}
i = soma % 11;
if (i <= 1)
  dig = 0;
else
  dig = 11 - i;
return (dig == nro[8]);
} //pi

function CheckIERJ(inscricao)
{
if (inscricao.length != 8)
  return false;
var nro = new Array(8);
for (var i = 0; i <= 7; i++)
  nro[i] = CharToInt(inscricao.charAt(i));
b = 2;
soma = 0;
for (i = 0; i <= 6; i++)
{
  soma += nro[i] * b;
  b--;
  if (b == 1)
   b = 7;
}
i = soma % 11;
if (i <= 1)
  dig = 0;
else
  dig = 11 - i;
return (dig == nro[7]);
} //rj
// CHRISTOPHE T. C. <wG @ codingz.info>
function CheckIERN(inscricao)
{
if (inscricao.length != 9)
  return false;
var nro = new Array(9);
for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(inscricao.charAt(i));
b = 9;
soma = 0;
for (i = 0; i <= 7; i++)
{
  soma += nro[i] * b;
  b--;
}
soma *= 10;
dig = soma % 11;
if (dig == 10)
  dig = 0;
return (dig == nro[8]);
} //rn

function CheckIERS(inscricao)
{
if (inscricao.length != 10)
  return false;
i = inscricao.substring(0, 3);
if ((i >= 1) && (i <= 467))
{
  var nro = new Array(10);
  for (var i = 0; i <= 9; i++)
   nro[i] = CharToInt(inscricao.charAt(i));
  b = 2;
  soma = 0;
  for (i = 0; i <= 8; i++)
  {
   soma += nro[i] * b;
   b--;
   if (b == 1)
b = 9;
  }
  dig = 11 - (soma % 11);
  if (dig >= 10)
   dig = 0;
  return (dig == nro[9]);
} //if i&&i
} //rs




function CheckIEROantigo(inscricao)
{
if (inscricao.length != 9) {
 return false;
}

var nro = new Array(9);
b=6;
soma =0;

for( var i = 3; i <= 8; i++) {

    nro[i] = CharToInt(inscricao.charAt(i));

        if( i != 8 ) {
            soma = soma + ( nro[i] * b );
            b--;
        }

}

dig = 11 - (soma % 11);
if (dig >= 10)
  dig = dig - 10;

return (dig == nro[8]);

} //ro-antiga





function CheckIERO(inscricao)
{

if (inscricao.length != 14) {
 return false;
}

var nro = new Array(14);
b=6;
soma=0;

        for(var i=0; i <= 4; i++) {
    
            nro[i] = CharToInt(inscricao.charAt(i));

        
                soma = soma + ( nro[i] * b );
                b--;

        }

        b=9;
        for(var i=5; i <= 13; i++) {
    
            nro[i] = CharToInt(inscricao.charAt(i));

                if ( i != 13 ) {        
                soma = soma + ( nro[i] * b );
                b--;
                }

        }

                        dig = 11 - ( soma % 11);
                            
                            if (dig >= 10)
                                  dig = dig - 10;

                                    return(dig == nro[13]);
                        
} //ro nova





function CheckIERR(inscricao)
{
if (inscricao.length != 9)
  return false;
if (inscricao.substring(0,2) != '24')
  return false;
var nro = new Array(9);
for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(inscricao.charAt(i));
var soma = 0;
var n = 0;
for (i = 0; i <= 7; i++)
  soma += nro[i] * ++n;
dig = soma % 9;
return (dig == nro[8]);
} //rr

function CheckIESC(inscricao)
{
if (inscricao.length != 9)
  return false;
var nro = new Array(9);
for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(inscricao.charAt(i));
b = 9;
soma = 0;
for (i = 0; i <= 7; i++)
{
  soma += nro[i] * b;
  b--;
}
i = soma % 11;
if (i <= 1)
  dig = 0;
else
  dig = 11 - i;
return (dig == nro[8]);
} //sc

// CHRISTOPHE T. C. <wG @ codingz.info>

function CheckIESP(inscricao)
{
if (((inscricao.substring(0,1)).toUpperCase()) == 'P')
{
  s = inscricao.substring(1, 9);
  var nro = new Array(12);
  for (var i = 0; i <= 7; i++)
   nro[i] = CharToInt(s[i]);
  soma = (nro[0] * 1) + (nro[1] * 3) + (nro[2] * 4) + (nro[3] * 5) +
   (nro[4] * 6) + (nro[5] * 7) + (nro[6] * 8) + (nro[7] * 10);
  dig = soma % 11;
  if (dig >= 10)
   dig = 0;
  resultado = (dig == nro[8]);
  if (!resultado)
   return false;
}
else
{
  if (inscricao.length < 12)
   return false;
  var nro = new Array(12);
  for (var i = 0; i <= 11; i++)
   nro[i] = CharToInt(inscricao.charAt(i));
  soma = (nro[0] * 1) + (nro[1] * 3) + (nro[2] * 4) + (nro[3] * 5) +
   (nro[4] * 6) + (nro[5] * 7) + (nro[6] * 8) + (nro[7] * 10);
  dig = soma % 11;
  if (dig >= 10)
   dig = 0;
  resultado = (dig == nro[8]);
  if (!resultado)
   return false;
  soma = (nro[0] * 3) + (nro[1] * 2) + (nro[2] * 10) + (nro[3] * 9) +
   (nro[4] * 8) + (nro[5] * 7) + (nro[6] * 6)  + (nro[7] * 5) +
   (nro[8] * 4) + (nro[9] * 3) + (nro[10] * 2);
  dig = soma % 11;
  if (dig >= 10)
   dig = 0;
  return (dig == nro[11]);
}
} //sp

function CheckIESE(inscricao)
{
if (inscricao.length != 9)
  return false;
var nro = new Array(9);
for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(inscricao.charAt(i));
b = 9;
soma = 0;
for (i = 0; i <= 7; i++)
{
  soma += nro[i] * b;
  b--;
}
dig = 11 - (soma % 11);
if (dig >= 10)
  dig = 0;
return (dig == nro[8]);
} //se



function CheckIETO(inscricao)
{
if (inscricao.length != 9) {
 return false;
}

var nro = new Array(9);
b=9;
soma=0;

for (var i=0; i <= 8; i++ ) {

nro[i] = CharToInt(inscricao.charAt(i));

if(i != 8) {
soma = soma + ( nro[i] * b );
b--;
}


}

ver = soma % 11;

if ( ver < 2 )

dig=0;

if ( ver >= 2 )
dig = 11 - ver;

return(dig == nro[8]);
} //to





//inscri????o estadual antiga
function CheckIETOantigo(inscricao)
{

 if ( inscricao.length != 11 ) {
    return false;

}


var nro = new Array(11);
b=9;
soma=0;

s = inscricao.substring(2, 4);

    if( s != '01' || s != '02' || s != '03' || s != '99' ) {


        for ( var i=0; i <= 10; i++) 
        {

            nro[i] = CharToInt(inscricao.charAt(i));    

            if( i != 3 || i != 4) {

            soma = soma + ( nro[i] * b );
            b--;
            
            } // if ( i != 3 || i != 4 )

        } //fecha for


            resto = soma % 11;        
            
                if( resto < 2 ) {    

                    dig = 0;

                }


                if ( resto >= 2 ) {

                    dig = 11 - resto;

                }            

                return (dig == nro[10]);

    } // fecha if


}//fecha fun????o CheckIETOantiga






function CheckIEMG(inscricao)
{
if (inscricao.substring(0,2) == 'PR')
  return true;
if (inscricao.substring(0,5) == 'ISENT')
  return true;
if (inscricao.length != 13)
  return false;
dig1 = inscricao.substring(11, 12);
dig2 = inscricao.substring(12, 13);
inscC = inscricao.substring(0, 3) + '0' + inscricao.substring(3, 11);
insc=inscC.split('');
npos = 11;
i = 1;
ptotal = 0;
psoma = 0;
while (npos >= 0)
{
  i++;
  psoma = CharToInt(insc[npos]) * i;  
  if (psoma >= 10)
   psoma -= 9;
  ptotal += psoma;
  if (i == 2)
   i = 0;
  npos--;
}
nresto = ptotal % 10;
if (nresto == 0)
  nresto = 10;
nresto = 10 - nresto;
if (nresto != CharToInt(dig1))
  return false;
npos = 11;
i = 1;
ptotal = 0;
is=inscricao.split('');
while (npos >= 0)
{
  i++;
  if (i == 12)
   i = 2;
  ptotal += CharToInt(is[npos]) * i;
  npos--;
}
nresto = ptotal % 11;
if ((nresto == 0) || (nresto == 1))
  nresto = 11;
nresto = 11 - nresto;  
return (nresto == CharToInt(dig2));
}





function CheckIE(inscricao, estado)
{
inscricao = inscricao.replace(/\./g, '');
inscricao = inscricao.replace(/\\/g, '');
inscricao = inscricao.replace(/\-/g, '');
inscricao = inscricao.replace(/\//g, '');
if ( inscricao == 'ISENTO') 
  return true;
switch (estado)
{
  case 'MG': return CheckIEMG(inscricao); break;
  case 'AC': return CheckIEAC(inscricao); break;
  case 'AL': return CheckIEAL(inscricao); break;
  case 'AM': return CheckIEAM(inscricao); break;
  case 'AP': return CheckIEAP(inscricao); break;
  case 'BA': return CheckIEBA(inscricao); break;
  case 'CE': return CheckIECE(inscricao); break;
  case 'DF': return CheckIEDF(inscricao); break;
  case 'ES': return CheckIEES(inscricao); break;
  case 'GO': return CheckIEGO(inscricao); break;
  case 'MA': return CheckIEMA(inscricao); break;
  case 'muito': return CheckIEMT(inscricao); break;
  case 'MS': return CheckIEMS(inscricao); break;
  case 'pra': return CheckIEPA(inscricao); break;
  case 'PB': return CheckIEPB(inscricao); break;
  case 'PR': return CheckIEPR(inscricao); break;
  case 'PE': return CheckIEPE(inscricao); break;
  case 'PI': return CheckIEPI(inscricao); break;
  case 'RJ': return CheckIERJ(inscricao); break;
  case 'RN': return CheckIERN(inscricao); break;
  case 'RS': return CheckIERS(inscricao); break;
  case 'RO': return ((CheckIERO(inscricao)) || (CheckIEROantigo(inscricao))); break;
  case 'RR': return CheckIERR(inscricao); break;
  case 'SC': return CheckIESC(inscricao); break;
  case 'SP': return CheckIESP(inscricao); break;
  case 'SE': return CheckIESE(inscricao); break;
  case 'TO': return ((CheckIETO(inscricao)) || (CheckIETOantigo(inscricao))); break;//return CheckIETO(inscricao); break;         
}
}