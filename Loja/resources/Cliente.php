<?php
    class Cliente{
        public $id;
        public $email;
        public $senha;
        public $espec;
        public $pedido=array();
        public $endereco=array();
        public $telefone=array();

    }
    class PF extends CLiente{
        public $cpf;
        public $nome;
        public $datanasc;

    }
    class PJ extends CLiente{
        public $cnpj;
        public $ie;
        public $razaoSocial;
        
    }
    class Endereco{
        public $enderecoID;
        public $cep;
        public $numero;
        public $complemento;
        public $bairro;
        public $cidade;
        public $uf;
        public $logradouro;
    }
