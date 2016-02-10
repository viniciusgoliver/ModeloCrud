<?php

// Require das Class Necessárias
require_once "class/Defines.php";
require_once "class/Conexao.php";
require_once "class/Migration.php";

try{

    // Atribui uma conexão PDO
    $pdo = Conexao::getInstance();

    // Atribui uma instância da classe Migrate, passando como parâmetro a conexão PDO e o nome da tabela
    $dados_antigos = Migration::getInstance($pdo, DB_DADOS_ANTIGOS);
    $produtos = Migration::getInstance($pdo, DB_PRODUTOS);
    $tamanhos = Migration::getInstance($pdo, DB_TAMANHOS);
    $cores = Migration::getInstance($pdo, DB_CORES);
    $produtos_cores = Migration::getInstance($pdo, DB_PRODUTOS_CORES);
    $produtos_tamanhos = Migration::getInstance($pdo, DB_PRODUTOS_TAMANHOS);

    //Chama o método getAll() passando o parametra da tabela que retorna um array de objetos
    $lista_dados_antigos = $dados_antigos->getAll();

    $idProduto = 0;
    $idTamanho = 0;
    $idCor = 0;
    $idProdutoCor = 0;

    //Loop foreach percorre a array para exibir os dados
    foreach ($lista_dados_antigos as $reg):

        // Persistencia Objeto Produtos
        $produtos->setTableName(DB_PRODUTOS);
        $arrayProdutos = array('codigo' => $reg->codigo, 'titulo' => $reg->titulo);
        if($produtos->getExists(array('titulo=' => $reg->titulo)) == 0){
            $idProduto++;
            $retornoProdutos = $produtos->insert($arrayProdutos);
        }

        // Persistencia Objeto Tamanhos
        $tamanhos->setTableName(DB_TAMANHOS);
        $arrayTamanhos = array('titulo' => $reg->tamanho);
        if($tamanhos->getExists(array('titulo=' => $reg->tamanho)) == 0){
            $idTamanho++;
            $retornoTamanhos = $tamanhos->insert($arrayTamanhos);
        }

        // Persistencia Objeto Cores
        $arrayCores = array('titulo' => $reg->cor);
        $cores->setTableName(DB_CORES);
        if($cores->getExists(array('titulo=' => $reg->cor)) == 0){
            $idCor++;
            $retornoCores = $cores->insert($arrayCores);
        }

        // Persistencia Objeto Produtos Cores
        $arrayProdutosCores = array('id_cor' => $idCor, 'id_produto' => $idProduto);
        $produtos_cores->setTableName(DB_PRODUTOS_CORES);

        if($produtos_cores->getExists(array('id_cor=' => $idCor, 'id_produto=' => $idProduto)) == 0) {
            $idProdutoCor++;
            $retornoProdutosCores = $produtos_cores->insert($arrayProdutosCores);
        }

        // Persistencia Objeto Produtos Tamanhos
        $arrayProdutosTamanhos = array('id_produto_cor' => $idProdutoCor, 'id_tamanho' => $idTamanho);
        $produtos_tamanhos->setTableName(DB_PRODUTOS_TAMANHOS);

        if($produtos_tamanhos->getExists(array('id_produto_cor=' => $idProdutoCor, 'id_tamamho=' => $idTamanho)) == 0) {
            $retornoProdutosTamanhos = $produtos_tamanhos->insert($arrayProdutosTamanhos);
        }

    endforeach;
    print "<script>alert('Migração Concluída')</script>";

}catch(PDOException $erro){
    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>";
}

?>
