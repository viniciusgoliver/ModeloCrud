<?php

require_once "./class/Conexao.php";
require_once "./class/Crud.php";

// Consumindo m�todos do CRUD gen�rico

// Atribui uma conex�o PDO
$pdo = Conexao::getInstance();

// Atribui uma inst�ncia da classe Crud, passando como par�metro a conex�o PDO e o nome da tabela
$crud = Crud::getInstance($pdo, 'contatos');

// Inseri os dados do usu�rio
$arrayContato = [
    'nome' => 'Vin�cius G. Oliveira',
    'email' => 'vinicius.oliver@gmail.com',
    'telefone' => '(51) 9737.5979'
];

$arrayCondicao = array('id=' => 1);
$retorno   = $crud->update($arrayContato, $arrayCondicao);

echo "<script>alert('Registro atualizado com sucesso')</script>";