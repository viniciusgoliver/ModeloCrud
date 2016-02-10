<?php

/***************************************************************************************************************
 * @author Vinícius G. Oliveira                                                                                  *
 * Data: 03/12/2015                                                                                              *
 * Título: Migrate Genérico de Dados                                                                             *
 * Descrição: A Classe de Migration genérico foi contruida com o objetivo de auxlilar nas operações Migracao de BD *
 * possui funcionalidades de CRUD onde as mesmas podem ser executadas nos principais SGBDs, Instruções SELECT    *
 * são recebidas integralmente via parâmetro.                                                                    *
 *************************************************************************************************************/

header('Content-Type: text/html; charset=utf-8');

class Migration {

    // Atributo para guardar uma conexão PDO
    private $pdo = null;

    // Atributo onde será guardado o nome da tabela
    private $tabela = null;

    // Atributo estático que contém uma instância da própria classe
    private static $migrate = null;

    /*
    * Método privado construtor da classe
    * @param $conexao = Conexão PDO configurada
    * @param $tabela = Nome da tabela
    */
    private function __construct($conexao, $tabela=NULL){

        if (!empty($conexao)):
            $this->pdo = $conexao;
        else:
            echo "<h3>Conexão inexistente!</h3>";
            exit();
        endif;

        if (!empty($tabela)) $this->tabela =$tabela;
    }

    /*
    * Método público estático que retorna uma instância da classe Migration
    * @param $conexao = Conexão PDO configurada
    * @param $tabela = Nome da tabela
    * @return Atributo contendo instância da classe Migration
    */
    public static function getInstance($conexao, $tabela=NULL){

        // Verifica se existe uma instância da classe
        if(!isset(self::$migrate)):
            try {
                self::$migrate = new Migration($conexao, $tabela);
            } catch (Exception $e) {
                echo "Erro " . $e->getMessage();
            }
        endif;

        return self::$migrate;
    }

    /*
    * Método para setar o nome da tabela na propriedade $tabela
    * @param $tabela = String contendo o nome da tabela
    */
    public function setTableName($tabela){
        if(!empty($tabela)){
            $this->tabela = $tabela;
        }
    }

    /*
    * Método privado para construção da instrução SQL de INSERT
    * @param $arrayDados = Array de dados contendo colunas e valores
    * @return String contendo instrução SQL
    */
    private function buildInsert($arrayDados){

        // Inicializa variáveis
        $sql = "";
        $campos = "";
        $valores = "";

        // Loop para montar a instrução com os campos e valores
        foreach($arrayDados as $chave => $valor):
            $campos .= $chave . ', ';
            $valores .= '?, ';
        endforeach;

        // Retira vírgula do final da string
        $campos = (substr($campos, -2) == ', ') ? trim(substr($campos, 0, (strlen($campos) - 2))) : $campos ;

        // Retira vírgula do final da string
        $valores = (substr($valores, -2) == ', ') ? trim(substr($valores, 0, (strlen($valores) - 2))) : $valores ;

        // Concatena todas as variáveis e finaliza a instrução
        $sql .= "INSERT INTO {$this->tabela} (" . $campos . ")VALUES(" . $valores . ")";

        // Retorna string com instrução SQL
        return trim($sql);
    }

    /*
    * Método público para inserir os dados na tabela
    * @param $arrayDados = Array de dados contendo colunas e valores
    * @return Retorna resultado booleano da instrução SQL
    */
    public function insert($arrayDados){
        try {

            // Atribui a instrução SQL construida no método
            $sql = $this->buildInsert($arrayDados);

            // Passa a instrução para o PDO
            $stm = $this->pdo->prepare($sql);

            // Loop para passar os dados como parâmetro
            $cont = 1;
            foreach ($arrayDados as $valor):
                $stm->bindValue($cont, $valor);
                $cont++;
            endforeach;

            // Executa a instrução SQL e captura o retorno
            $retorno = $stm->execute();

            return $retorno;

        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

    /*
  * Metodo para consulta de todos os dados
  * @return $dados - Array com os registros retornados pela consulta
  */
    public function getAll(){
        try{
            $sql = "SELECT * FROM {$this->tabela}";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $dados = $stm->fetchAll(PDO::FETCH_OBJ);
            return $dados;
        }catch(PDOException $erro){
            echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>";
        }
    }

    /*
  * Metodo para consulta de todos os dados
  * @return $dados - Array com os registros retornados pela consulta
  */
    public function getExists($arrayCondicao){

        // Inicializa variáveis
        $sql = "";
        $valCampos= "";

        // Loop para montar a instrução com os campos e valores
        foreach($arrayCondicao as $chave => $valor):
            $valCampos .= $chave . "'".$valor."'".' AND ';
        endforeach;

        // Retira a palavra AND do final da string
        $valCampos = (substr($valCampos, -4) == 'AND ') ? trim(substr($valCampos, 0, (strlen($valCampos) - 4))) : $valCampos ;

        // Concatena todas as variáveis e finaliza a instrução
        $sql .= "SELECT * FROM {$this->tabela} WHERE " . $valCampos;

        try{
            $sqlFinal = trim($sql);
            $stm = $this->pdo->prepare($sqlFinal);
            $stm->execute();
            $dados = $stm->rowCount();
            return $dados;
        }catch(PDOException $erro){
            echo "<script>alert('Erro na linha: {$erro->getMessage()}')</script>";
        }
    }

}