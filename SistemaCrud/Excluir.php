<?php

require_once "./class/Conexao.php";
require_once "./class/Crud.php";

// Consumindo m�todos do CRUD gen�rico

// Atribui uma conex�o PDO
$pdo = Conexao::getInstance();

// Atribui uma inst�ncia da classe Crud, passando como par�metro a conex�o PDO e o nome da tabela
$crud = Crud::getInstance($pdo, 'contatos');

// Exclui o registro do usu�rio com id 1
$arrayCondicao = array('id=' => 1);
$retorno   = $crud->delete($arrayCondicao);

echo "<script>alert('Registro excluido com sucesso')</script>";