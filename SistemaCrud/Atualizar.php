<?php

require_once "./class/Conexao.php";
require_once "./class/Crud.php";

// Consumindo métodos do CRUD genérico

// Atribui uma conexão PDO
$pdo = Conexao::getInstance();

// Atribui uma instância da classe Crud, passando como parâmetro a conexão PDO e o nome da tabela
$crud = Crud::getInstance($pdo, 'contatos');

// Inseri os dados do usuário
$arrayContato = [
    'nome' => 'Vinícius G. Oliveira',
    'email' => 'vinicius.oliver@gmail.com',
    'telefone' => '(51) 9737.5979'
];

$arrayCondicao = array('id=' => 1);
$retorno   = $crud->update($arrayContato, $arrayCondicao);

echo "<script>alert('Registro atualizado com sucesso')</script>";