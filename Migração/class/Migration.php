<?php

/***************************************************************************************************************
 * @author Vin�cius G. Oliveira                                                                                  *
 * Data: 03/12/2015                                                                                              *
 * T�tulo: Migrate Gen�rico de Dados                                                                             *
 * Descri��o: A Classe de Migration gen�rico foi contruida com o objetivo de auxlilar nas opera��es Migracao de BD *
 * possui funcionalidades de CRUD onde as mesmas podem ser executadas nos principais SGBDs, Instru��es SELECT    *
 * s�o recebidas integralmente via par�metro.                                                                    *
 *************************************************************************************************************/

header('Content-Type: text/html; charset=utf-8');

class Migration {

    // Atributo para guardar uma conex�o PDO
    private $pdo = null;

    // Atributo onde ser� guardado o nome da tabela
    private $tabela = null;

    // Atributo est�tico que cont�m uma inst�ncia da pr�pria classe
    private static $migrate = null;

    /*
    * M�todo privado construtor da classe
    * @param $conexao = Conex�o PDO configurada
    * @param $tabela = Nome da tabela
    */
    private function __construct($conexao, $tabela=NULL){

        if (!empty($conexao)):
            $this->pdo = $conexao;
        else:
            echo "<h3>Conex�o inexistente!</h3>";
            exit();
        endif;

        if (!empty($tabela)) $this->tabela =$tabela;
    }

    /*
    * M�todo p�blico est�tico que retorna uma inst�ncia da classe Migration
    * @param $conexao = Conex�o PDO configurada
    * @param $tabela = Nome da tabela
    * @return Atributo contendo inst�ncia da classe Migration
    */
    public static function getInstance($conexao, $tabela=NULL){

        // Verifica se existe uma inst�ncia da classe
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
    * M�todo para setar o nome da tabela na propriedade $tabela
    * @param $tabela = String contendo o nome da tabela
    */
    public function setTableName($tabela){
        if(!empty($tabela)){
            $this->tabela = $tabela;
        }
    }

    /*
    * M�todo privado para constru��o da instru��o SQL de INSERT
    * @param $arrayDados = Array de dados contendo colunas e valores
    * @return String contendo instru��o SQL
    */
    private function buildInsert($arrayDados){

        // Inicializa vari�veis
        $sql = "";
        $campos = "";
        $valores = "";

        // Loop para montar a instru��o com os campos e valores
        foreach($arrayDados as $chave => $valor):
            $campos .= $chave . ', ';
            $valores .= '?, ';
        endforeach;

        // Retira v�rgula do final da string
        $campos = (substr($campos, -2) == ', ') ? trim(substr($campos, 0, (strlen($campos) - 2))) : $campos ;

        // Retira v�rgula do final da string
        $valores = (substr($valores, -2) == ', ') ? trim(substr($valores, 0, (strlen($valores) - 2))) : $valores ;

        // Concatena todas as vari�veis e finaliza a instru��o
        $sql .= "INSERT INTO {$this->tabela} (" . $campos . ")VALUES(" . $valores . ")";

        // Retorna string com instru��o SQL
        return trim($sql);
    }

    /*
    * M�todo p�blico para inserir os dados na tabela
    * @param $arrayDados = Array de dados contendo colunas e valores
    * @return Retorna resultado booleano da instru��o SQL
    */
    public function insert($arrayDados){
        try {

            // Atribui a instru��o SQL construida no m�todo
            $sql = $this->buildInsert($arrayDados);

            // Passa a instru��o para o PDO
            $stm = $this->pdo->prepare($sql);

            // Loop para passar os dados como par�metro
            $cont = 1;
            foreach ($arrayDados as $valor):
                $stm->bindValue($cont, $valor);
                $cont++;
            endforeach;

            // Executa a instru��o SQL e captura o retorno
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

        // Inicializa vari�veis
        $sql = "";
        $valCampos= "";

        // Loop para montar a instru��o com os campos e valores
        foreach($arrayCondicao as $chave => $valor):
            $valCampos .= $chave . "'".$valor."'".' AND ';
        endforeach;

        // Retira a palavra AND do final da string
        $valCampos = (substr($valCampos, -4) == 'AND ') ? trim(substr($valCampos, 0, (strlen($valCampos) - 4))) : $valCampos ;

        // Concatena todas as vari�veis e finaliza a instru��o
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