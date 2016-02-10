<?php

require_once "./class/Conexao.php";
require_once "./class/Crud.php";

try{
    // Consumindo m�todos do CRUD gen�rico

    // Atribui uma conex�o PDO
    $pdo = Conexao::getInstance();

    // Atribui uma inst�ncia da classe Crud, passando como par�metro a conex�o PDO e o nome da tabela
    $crud = Crud::getInstance($pdo, 'contatos');

    $lista_contatos = $crud->getAll();

    //Loop foreach percorre a array para exibir os dados
    print "<table border='1'>";
    print "<tr>";
    print "<td>Id</td>";
    print "<td>Nome</td>";
    print "<td>Email</td>";
    print "<td>Telefone</td>";
    print "</tr>";
    foreach ($lista_contatos as $reg):
        print "<tr>";
        print "<td><a href='./Listar.php?id={$reg->id}'>{$reg->id}</a></td>";
        print "<td>{$reg->nome}</td>";
        print "<td>{$reg->email}</td>";
        print "<td>{$reg->telefone}</td>";
        print "</tr>";
    endforeach;
    print "</table>";

}catch(PDOException $erro){
    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>";
}