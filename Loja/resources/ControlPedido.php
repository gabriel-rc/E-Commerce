<?php
include "Pedido.php";
class ControlPedido{
    private function conectar(){
        $servidor = "localhost";
        $usuario = "u398141602_Qrta_Shopping";
        $senha = 'F!OZ8$X1]Xa';
        $db = "u398141602_AS_Loja";

        $connmysqli = new mysqli($servidor, $usuario, $senha, $db);
        if (mysqli_connect_errno($connmysqli)) {
          return("Erro de conexão ao servidor:" . mysqli_connect_error());
        }
        return $connmysqli;

    }
    
    
    public function realizaPedido($pedido){
        function encontraPesoPorId($id,$array){
                
            
            foreach ( $array as $element ) {
                if ( strcmp($id , $element->produtoID)==0 ) {
                    return $element->peso;
                }
            }
        }
        $conectar=self::conectar();
        if(is_string($conectar)){
            return("Erro de conexão");
        }
        $sql="INSERT INTO Pedido (clienteID,pendente) VALUES ('$pedido->clienteID',CURDATE())";
        $res=$conectar->query($sql);
        if($res){
            $sql="SELECT MAX(pedidoID) FROM Pedido WHERE clienteID='$pedido->clienteID'";
            $res=$conectar->query($sql);
            $id=mysqli_fetch_row($res);
            $url = 'https://altsolutions.tech/gerenciador/resources/ProdLoja.php?buscar';
	        $dadosProduto = file_get_contents($url);
	        $jsonObj = json_decode($dadosProduto);
	        $dataProduto = $jsonObj->dados;    
            $peso=0;
            foreach($pedido->itemPedido as $item){
                $peso+=encontraPesoPorId($item->produtoID,$dataProduto);
            }$cf=new ControlFrete();
            $endereco=$pedido->entrega;
            $frete=$cf->realizaFrete($endereco->cep,$peso);
            print_r($frete);
            $sql="INSERT INTO Frete (freteID,freteValor,fretePrazo) VALUES ('$id[0]',$frete,'18')";//mexer
            $res=$conectar->query($sql);
            $entrega=$pedido->entrega;
            $sql="INSERT INTO Entrega (pedidoID,freteID,CEP,num,complemento) VALUES ('$id[0]','$id[0]','$entrega->cep','$entrega->numero','".$entrega->complemento."')";//mexer
            $res=$conectar->query($sql);
            $res=0;
            // if(!self::realizaPagamento($dados));
            $sql="UPDATE Pedido SET processamento=CURDATE() WHERE pedidoID='$id[0]'";
            $res=$conectar->query($sql);
            $produtos=$pedido->itemPedido;
            for($i=0;$i<count($pedido->itemPedido);$i++){
                $produtos[$i]->pedidoID=$id[0];     
            }
            $res=self::alterarQuantidade($produtos);//mexer alterar quantidade
            
           
            
            $conectar->close();
            return ($res);
        }
       
        
       
       $conectar->close();
        //insert
    }
    public function atualizaPedido(Pedido $var){//recebe pedido
        //update
        $conectar=self::conectar();
        if(is_string($conectar)){
            return("Erro de conexão");
        }
        if(isset($var->pedidoNF)){
            $aux="pedidoNF='$var->pedidoNF'";
        }else if(isset($var->dataProcessamento)){
            $aux="processamento=CURDATE()";
        } else if(isset($var->dataCancelado)){
            $aux="cancelado=CURDATE()";
        }else if(isset($var->classif)){
            $aux="classif='$var->classif'";
        }
        if(!isset($aux))
            return -1;
        $sql="UPDATE Pedido SET $aux WHERE pedidoID='$var->pedidoID'";
        $res=$conectar->query($sql);
        $conectar->close();
        return $res;
    }
    public function alterarQuantidade($produtos){
        //insert api
        $conectar=self::conectar();
        if(is_string($conectar)){
            return("Erro de conexão");
        }
        for($i=0;$i<count($produtos);$i++){
            //print_r($produtos[$i]->produtoID);
            $sql="INSERT INTO itemPedido (pedidoID,produtoID,qtdeProduto,valorProd) VALUES ('".$produtos[$i]->pedidoID."','".$produtos[$i]->produtoID."','".$produtos[$i]->qtdeProduto."','".$produtos[$i]->valorProd."')";//mexer
            $res=$conectar->query($sql);
          //  print_r($res);
        }
        $conectar->close();
        return $res;
        
    }
    public function buscaPedido($var){
        $conectar=self::conectar();
        if(is_string($conectar)){
            return("Erro de conexão");
        }

        $pedidos=array();
        if(isset($var->id)){//caso objeto CLiente
            $sql="SELECT * FROM Pedido WHERE clienteID='$var->id'";

        }else if(strcmp($var,"CANCELADO")==0){//caso cancelado
            $sql="SELECT * FROM Pedido WHERE cancelado IS NOT NULL";
        }else if(strcmp($var,"NF")==0){//CASO sem NF
            $sql="SELECT * FROM Pedido WHERE pedidoNF IS NULL";
        }else if(strcmp($var,"TRANS")==0){//em transporte
            $sql="SELECT * FROM Pedido WHERE cancelado IS NOT NULL AND processamento IS NOT NULL AND freteID NOT IN(SELECT concluido FROM Frete WHERE concluido IS NOT NULL)";
        }else{//Pedidos no último mês
            $sql="SELECT * FROM Pedido WHERE BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE()";
        }
        $res=$conectar->query($sql);
        if(mysqli_num_rows($res)>0){
            while($busca=mysqli_fetch_assoc($res)){
                $pedido= new Pedido();
                $pedido->pedidoID=$busca['pedidoID'];
                $pedido->pedidoNF=$busca['pedidoNF'];
                $pedido->clienteID=$busca['clienteID'];
                $pedido->dataPendente=$busca['pendente'];
                $pedido->dataCancelado=$busca['cancelado'];
                $pedido->dataProcessamento=$busca['processamento'];
                $pedido->classif=$busca['classif'];
                array_push($pedidos,$pedido);
            }
        }
 
        for($i=0;$i<count($pedidos);$i++){
            
            $sql="SELECT pedidoID,freteID,E.CEP as CEP,num, complemento,ENDERECO,CIDADE,BAIRRO,UF FROM Entrega E join tCEP C on E.CEP=C.CEP WHERE pedidoID='".$pedidos[$i]->pedidoID."'";
            $res=$conectar->query($sql);
            
            if(mysqli_num_rows($res)>0){
                $busca=mysqli_fetch_assoc($res);
                $entrega=new Entrega();
                $entrega->freteID=$pedidos[$i]->pedidoID;
                $entrega->cep=$busca['CEP'];
                $entrega->logradouro=$busca['ENDERECO'];
                $entrega->numero=$busca['num'];
                $entrega->complemento=$busca['complemento'];
                $entrega->bairro=$busca['BAIRRO'];
                $entrega->cidade=$busca['CIDADE'];
                $entrega->uf=$busca['UF'];
                $pedidos[$i]->entrega=$entrega;
            }
            $sql="SELECT * FROM Frete WHERE freteID='".($pedidos[$i])->pedidoID."'";
            $res=$conectar->query($sql);
            if(mysqli_num_rows($res)>0){
                $busca=mysqli_fetch_assoc($res);
                $frete=new Frete();
                $frete->freteID=$pedidos[$i]->pedidoID;
                $frete->freteValor=$busca['freteValor'];
                $frete->fretePrazp=$busca['fretePrazo'];
                $frete->dataAguarda=$busca['aguarda'];
                $frete->dataRetirando=$busca['retirado'];
                $frete->dataTransp=$busca['transportadora'];
                $frete->dataRotaEntrega=$busca['rotaEntrega'];
                $frete->dataConcluido=$busca['concluido'];
                $pedidos[$i]->entrega->freteID=$frete;
            }
            $sql="SELECT * FROM itemPedido WHERE pedidoID='".$pedidos[$i]->pedidoID."'";
            $res=$conectar->query($sql);
            if(mysqli_num_rows($res)>0){
                while($busca=mysqli_fetch_assoc($res)){
                    $item= new ItemPedido();
                    $item->pedidoID=$pedidos[$i]->pedidoID;
                    $item->produtoID=$busca['produtoID'];
                    $item->qtdeProduto=$busca['qtdeProduto'];
                    $item->valorProd=$busca['valorProd'];
                    array_push($pedidos[$i]->itemPedido,$item);
                }
            }
        }
        $conectar->close();
        return $pedidos;
    }
    public function calculaFrete($endereco,$peso){
        $cf=new ControlFrete();
        return $cf->calculaFrete($endereco,$peso);
        
    } 
    public function realizaPagamento($dados){
        //insert
        $cp=new ControlPagamento();
       return $cp->realizaPagamento($dados);
    }
    public function verificaFrete(Frete $var){
        $cf=new ControlFrete();
        $res=$cf->verificaFrete($var->freteID);
        return $res;
    }
    public function atualizaFrete(Frete $var){
        $con=self::conectar();
        if(is_string($conectar)){
            return("Erro de conexão");
        }
        $sql="UPDATE Frete SET transportadora='$var->dataTransp',rotaEntrega='$var->dataRotaEntrega',concluido='$var->dataConcluido' WHERE freteID='$var->freteID'";
        $res=$conectar->query($sql);
        $con->close();
        return $res;
    }
    

}
class ControlPagamento{
    public function realizaPagamento($dados){
        
        $res=self::verificaDados($dados);
        if($res==false)
            return $res;
        return self::processaPagamento($dados);
    }
    public function verificaDados($dados){
        //get api
       
        $params=['Number'=>$dados->numero, 'Month'=>$dados->mes, 'Year'=>$dados->ano];
        $defaults = array(
            CURLOPT_URL => 'https://altsolutions.tech/gerenciador/resources/api-cartao/api-cartao.phhp?valida',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
        ); 
        $curl = curl_init();
        curl_setopt_array($curl, ( $defaults)); 
        $res=curl_exec($curl);
        curl_close($curl);
        return $res;
    }

    public function processaPagamento($dados){
        $params=['Number'=>$dados->numero, 'Month'=>$dados->mes, 'Year'=>$dados->ano];
        $defaults = array(
            CURLOPT_URL => 'https://altsolutions.tech/gerenciador/resources/api-cartao/api-cartao.phhp?valida',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
        ); 
        $curl = curl_init();
        curl_setopt_array($curl, ( $defaults)); 
        $res=curl_exec($curl);
        curl_close($curl);
        return $res;

    }
}
class ControlFrete{
    public function calculaFrete($endereco,$peso){
        $url="https://altsolutions.tech/gerenciador/resources/api-frete.php?calc&cep='$endereco'&peso=$peso";
                 
                  
        $contents=file_get_contents($url);
     
        $res=json_decode(substr($contents,strpos($contents,'{'),strlen($contents)));
        if(isset($res->preco)){
            $res=$res->preco;
            if($res==-1)
                return "Sistema de frete com problema";
        }else
            return "Sistema de frete com problema";
        return $res;
    }
    public function realizaFrete($endereco, $peso){
        //insert
        $f=new ControlFrete();
        
        return $f->processaFrete($endereco,$peso);
    }
    public function verificaFrete($freteID){
        $url="https://altsolutions.tech/gerenciador/resources/api-frete.php?status&freteID='$freteID'";
                 
                  
        $contents=file_get_contents($url);
     
        $res=json_decode(substr($contents,strpos($contents,'{'),strlen($contents)));
        if(isset($res->preco)){
            $res=$res->preco;
            if($res==-1)
                return "Sistema de frete com problema";
        }else
            return "Sistema de frete com problema";
        
        return $res;
    }
    public function processaFrete($endereco, $peso){
        $url="https://altsolutions.tech/gerenciador/resources/api-frete.php?calc&cep='$endereco'&peso=$peso";
                 
                  
        $contents=file_get_contents($url);
     
        $res=json_decode(substr($contents,strpos($contents,'{'),strlen($contents)));
        if(isset($res->preco)){
            $res=$res->preco;
            if($res==-1)
                return "Sistema de frete com problema";
        }else
            return "Sistema de frete com problema";
        
       
        return $res;

    }
}