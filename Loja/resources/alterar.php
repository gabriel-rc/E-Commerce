<?php
//print_r($_COOKIE['cliente']);
//print_r($_POST);
require 'ControlCliente.php';
    if(isset($_POST)){
        $cliente=$_POST;
        $cc=new ControlCliente();
        $c=json_decode($_COOKIE['cliente']);
        $c=$cc->buscarCliente($c->id);
        if(isset($cliente['delete-tel'])){
            $cc->removerTelefone(((object)['id'=>$c->id,'telefone'=>$cliente['tel-select']]));
        
        }else if(isset($cliente['delete-ad'])){
            
            for($i=0;$i<count($c->endereco);$i++){
                if($cliente['ad-select']==$c->endereco[$i]->enderecoID){
                    $endereco=$c->endereco[$i];
                    break;
                }
            }
            if(isset($endereco->enderecoID))
                $cc->removerEndereco($endereco->enderecoID);
        }else{
            $calt=new Cliente();
            $calt->id=$c->id;
            if(isset($cliente['password'])&&isset($cliente['password-confirm']) && strlen($cliente['password'])>=8){
                $senha=$_POST['password'];
                if(strcmp($senha,$_POST['password-confirm'])==0){
                    $calt->senha=$senha;
                }
            }
            if(isset($cliente['tel']) && strlen(preg_replace("/[^0-9]/", "",$cliente['tel']))>9){
                $calt->telefone=preg_replace("/[^0-9]/", "",$cliente['tel']);
            }
            if(strlen($cliente['city'])>0 && strlen($cliente['state'])>0 && strlen($cliente['cep'])>0 && strlen($cliente['bairro'])>0 && strlen($cliente['log'])>0 && strlen($cliente['num'])>0){
                $end=new Endereco();
                $end->cep=$cliente['cep'];
                $end->numero=$cliente['num'];
                $end->complemento=$cliente['comp'];
                $end->bairro=$cliente['bairro'];
                $end->cidade=$cliente['city'];
                $end->uf=$cliente['state'];
                $end->logradouro=$cliente['log'];
                array_push($calt->endereco,$end);
                

            }
            $cc->alterarCliente($calt);
        }
    }
    
    header("Location: ../alterar-cadastro.php");
?>