<?php
    include 'Cliente.php';
    

    class ControlCliente{
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
        
        public function buscarCliente($var){
            $conexao=self::conectar();
            if(is_string($conexao)){
                return("Erro de conexão");
            }
            
            $sql="SELECT * FROM Cliente WHERE clienteID=$var";
            $res=$conexao->query($sql);
            if(mysqli_num_rows($res)!=0){
                
                $busca=mysqli_fetch_assoc($res);
                if(strcmp($busca['espec'],"F")==0){
                    $cliente = new PF();
                    $cliente->id=$busca['clienteID'];
                    $cliente->email=$busca['email'];
                    $cliente->senha=$busca['senha'];
                    $cliente->espec=$busca['espec'];
                    $sql="SELECT * FROM PF WHERE clienteID=$var";
                    $res=$conexao->query($sql);
                    if(mysqli_num_rows($res)!=0){
                        $busca=mysqli_fetch_assoc($res);
                        $cliente->cpf=$busca['cpf'];
                        $cliente->nome=$busca['nome'];
                        $cliente->datanasc=$busca['datanasc'];
                    }
                }else{
                    $cliente = new PJ();
                    $cliente->id=$busca['clienteID'];
                    $cliente->email=$busca['email'];
                    $cliente->senha=$busca['senha'];
                    $cliente->espec=$busca['espec'];
                    $sql="SELECT * FROM PJ WHERE clienteID=$var";
                    $res=$conexao->query($sql);
                    if(mysqli_num_rows($res)!=0){
                        $busca=mysqli_fetch_assoc($res);
                        $cliente->cnpj=$busca['cnpj'];
                        $cliente->ie=$busca['ie'];
                        $cliente->razaoSocial=$busca['razaoSoc'];
                    }
                }
                $sql="SELECT * FROM Telefone WHERE clienteID=$var";
                $res=$conexao->query($sql);
                if(mysqli_num_rows($res)!=0){
                    while($busca=mysqli_fetch_assoc($res)){
                        array_push($cliente->telefone,$busca['telefone']);
                    }
                }
                $sql="SELECT * FROM Endereco WHERE clienteID=$var";
                $res=$conexao->query($sql);
                if(mysqli_num_rows($res)!=0){
                    while($busca=mysqli_fetch_assoc($res)){
                        $endereco= self::buscaCep($busca['cep']);
                        $endereco->numero=$busca['num'];
                        $endereco->complemento=$busca['complemento'];
                        $endereco->enderecoID=$busca['enderecoID'];
                        array_push($cliente->endereco,$endereco);
                    }
                }

            }
            $conexao->close();
            return $cliente;
        }
        private function buscaCep($var){
           $conexao= self::conectar();
           $endereco=new Endereco();
           $sql="SELECT * FROM tCEP WHERE CEP='$var'";
           $res=$conexao->query($sql);
           if(mysqli_num_rows($res)!=0){
                $busca=mysqli_fetch_assoc($res);
                $endereco->cep=$var;
                $endereco->bairro=$busca['BAIRRO'];
                $endereco->cidade=$busca['CIDADE'];
                $endereco->logradouro=$busca['ENDERECO'];
                $endereco->uf=$busca['UF'];

           }
           
           $conexao->close();
           return $endereco;

        
        }
        public function removerEndereco($var){//enderecoID como param
            
            $conexao= self::conectar();
            $r=0;
            $sql="SELECT * FROM Endereco WHERE enderecoID='$var'";
            $res=$conexao->query($sql);
            if(mysqli_num_rows($res)!=0){
                $busca=mysqli_fetch_assoc($res);
                $quantidade=self::buscaQuantidadeEndereco($busca['clienteID']);
                if($quantidade>1){
                    $sql="DELETE FROM Endereco WHERE enderecoID='$var'";
                    $res=$conexao->query($sql);
                    
                }
            }
            $conexao->close();
            return $res;
        }
        private function buscaQuantidadeEndereco($var){//clienteID como param
            $conexao= self::conectar();
            $quantidade=0;
            $sql="SELECT COUNT(*) as num FROM Endereco WHERE clienteID='$var'";
            $res=$conexao->query($sql);
            
            if($res->num_rows!=0){
                $busca=mysqli_fetch_row($res);
                $quantidade=$busca[0];
            }
            $conexao->close();
            return $quantidade;
        }
        public function removerTelefone($var){//recebe objeto com id cliente e telefone
            
            $conexao= self::conectar();
            $r=0;
            $sql="SELECT * FROM Telefone WHERE clienteID='$var->id'";
            $res=$conexao->query($sql);
            if(mysqli_num_rows($res)>1){
                $sql="DELETE FROM Telefone WHERE clienteID='$var->id' AND telefone='$var->telefone'";
                $res=$conexao->query($sql);
               
            }
            $conexao->close();
            return $res;
        }
        public function adicionarTelefone($var){//recebe objeto id cliente e telefone
            $conexao= self::conectar();
            $r=0;
            $sql="SELECT * FROM Telefone WHERE clienteID='$var->id' AND telefone='$var->telefone'";
            $res=$conexao->query($sql);
            if(mysqli_num_rows($res)==0){
                $sql="INSERT INTO Telefone (clienteID,telefone) VALUES('$var->id' ,'$var->telefone')";
                $res=$conexao->query($sql);
                
            }
            $conexao->close();
            return $res;
        }
        public function adicionarEndereco($var){//recebe Cliente
           
            $conexao= self::conectar();
            $r=0;
            $end = new Endereco();
            $end=$var->endereco[0];
            $sql="SELECT * FROM Endereco WHERE (clienteID='$var->id' AND cep='$end->cep' AND num='$end->numero' AND complemento='$end->complemento')";
            $res=$conexao->query($sql);
            
            if(mysqli_num_rows($res)==0){
                $sql="INSERT INTO Endereco (clienteID,cep,num,complemento) VALUES('$var->id' ,'$end->cep','$end->numero','$end->complemento')";
                $res=$conexao->query($sql);
                
                
            }
            $conexao->close();
            
            return $res;
        }
        public function alterarCliente(Cliente $var){//recebe cliente
            $r=0;
           if(isset($var->id)){
            $conexao= self::conectar();
            if(isset($var->senha)){
                $senha=password_hash(strval($var->senha),PASSWORD_BCRYPT);
                $sql="UPDATE Cliente SET senha='$senha' WHERE clienteID='$var->id'";
                $res=$conexao->query($sql);
                
                
            }
            if(isset($var->telefone)){
                $r=self::adicionarTelefone(((object)['id'=>$var->id,'telefone'=>$var->telefone]));
            }
            if(isset($var->endereco[0])){
                $r=self::adicionarEndereco($var);
             }
            $conexao->close();
           }
           
        }
        
    }
    