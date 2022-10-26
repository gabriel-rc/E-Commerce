<?php
    class Pedido{
        function __construct() {
            $this->entrega=array();
            $this->itemPedido=array();
        }
        public $itemPedido;
        public $entrega;
        public $pedidoID;
        public $pedidoNF;
        public $clienteID;
        public $dataPendente;
        public $dataCancelado;
        public $dataProcessamento;
        public $classif;

    }
    class Entrega{
        public $freteID;
        public $cep;
        public $logradouro;
        public $numero;
        public $complemento;
        public $bairro;
        public $cidade;
        public $uf;


    }
    class ItemPedido{
        public $pedidoID;
        public $produtoID;
        public $qtdeProduto;
        public $valorProd;
    }
    class Frete{
        public $freteID;
        public $freteValor;
        public $fretePrazo;
        public $dataAguarda;
        public $dataRetirado;
        public $dataTransp;
        public $dataRotaEntrega;
        public $dataConcluido;
    }
    