<?php require_once "Conexao.class.php";
require_once "Crud.class.php";

// Recebe o parametro de pesquisa se existir
$id = (isset($_GET['id'])) ? $_GET['id'] : '';
// Consumindo métodos do CRUD genérico

// Atribui uma conexão PDO
$pdo = Conexao::getInstance();

// Atribui uma instância da classe Crud, passando como parâmetro a conexão PDO e o nome da tabela
$crud = Crud::getInstance($pdo, 'contatos');

// Consulta os dados do usuário com id 1 e privilegio A
$sql = "SELECT * FROM contatos WHERE id = ?";
$arrayParam = array($id);
$dados = $crud->getSQLGeneric($sql, $arrayParam, FALSE);

print_r($dados);

/*//Loop foreach percorre a array para exibir os dados
print "<table border='1'>";
print "<tr>";
print "<td>Id</td>";
print "<td>Nome</td>";
print "<td>Email</td>";
print "<td>Telefone</td>";
print "</tr>";
foreach ($lista_contato as $contato):
    print "<tr>";
    print "<td><a href='#'>{$contato->id}</a></td>";
    print "<td>{$contato->nome}</td>";
    print "<td>{$contato->email}</td>";
    print "<td>{$contato->telefone}</td>";
    print "</tr>";
endforeach;
print "</table>";*/