<?php

require_once "./class/Conexao.php";
require_once "./class/Crud.php";

// Consumindo métodos do CRUD genérico

// Atribui uma conexão PDO
$pdo = Conexao::getInstance();

// Atribui uma instância da classe Crud, passando como parâmetro a conexão PDO e o nome da tabela
$crud = Crud::getInstance($pdo, 'contatos');

// Exclui o registro do usuário com id 1
$arrayCondicao = array('id=' => 1);
$retorno   = $crud->delete($arrayCondicao);

echo "<script>alert('Registro excluido com sucesso')</script>";