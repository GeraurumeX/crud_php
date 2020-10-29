<?php

namespace App\Db;

use \PDO;
use \PDOException;

class Database {

    /**
     * Host de conexion a la base de datos
     * @var string
     */
    const HOST = 'localhost';

    /**
     * Nombre de la base de datos
     * @var string
     */
    const NAME = 'wdev_vagas';

    /**
     * Usuario de la base de datos
     * @var string
     */
    const USER = 'root';

    /**
     * Contraseña de la base de datos
     * @var string
     */
    const PASS = '';

    /**
     * Nombre de la tabla para ser manipulada
     * @var string
     */
    private $table;

    /**
     * Instancia de conexión a la base de datos
     * @var PDO
     */
    private  $connection;

    /**
     * Define a tabela e instancia e conexao
     *@param string $table
     */
    public function __construct($table = null) {
        $this->table = $table;
        $this->setConnection();
    }

    /**
     * Método responsable de la conexión a la base de datos
     */
    private function setConnection() {
        try {
                $this->connection = new PDO('mysql:host='.self::HOST.';dbname='.self::NAME,self::USER,self::PASS);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e) {
            die('ERROR: '.$e->getMessage());
        }
    }


    /**
     * Metodo responsable de ejecutar las queries dentro de la base de datos
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */

     public function execute($query,$params=[]) {
        try{
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        }catch(PDOException $e) {
            die('ERROR: '.$e->getMessage());
        }
     }




    /**
     * Metodo responsavel por inserir dados no banco
     * @param array $values [ field => value ]
     * @return integer ID inserido
     */
    public function insert($values) {
        //Dados da query
        $fields = array_keys($values);
        //Probar que los datos lo paso a array
        //echo "<pre>"; print_r($values); echo "</pre>"; exit;

        $binds = array_pad([],count($fields),'?');
        //Probar que pase 4 posiciones que son el numero de datos a ingresar
        //echo "<pre>"; print_r($binds); echo "</pre>"; exit;

        //Monta a query
        $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';


        //EXECUTA O INSERT
        $this->execute($query,array_values($values));

        //RETORNA O ID INSERIDO
        return $this->connection->lastInsertId();
    }


    /**
     * Método responsable de ejecutar una consulta en la base de datos
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public function select($where = null, $order= null, $limit=null, $fields = '*') {
        // Datos del query
        $where = strlen($where) ? 'WHERE '.$where:'';
        $order = strlen($order) ? 'ORDER BY '.$order:'';
        $limit = strlen($limit) ? 'LIMIT '.$limit:'';
        
        //Monta a query
        $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

        return $this->execute($query);
    }


    /**
     * Método responsable de las actualizaciones de las vagas en la base de datos
     * @param string $where
     * @param array $values [field => value]
     * @return boolean
     */
    public function update($where,$values) {
        //DADOS DA QUERY
        $fields = array_keys($values);

        //MONTA A QUERY
        $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;
        //echo $query;
        //exit;

        //EJECUTA EL QUERY
        $this->execute($query,array_values($values));

        //RETORNA SUCESSO
        return true;
    }


    /**
     * Método responsable de eliminar las vagas de la base de datos
     * @param string $where
     * @return boolean
     */
    public function delete($where){
        //MONTA A QUERY
        $query = 'DELETE FROM '.$this->table. ' WHERE '.$where;

        //EXECUTA A QUERY
        $this->execute($query);

        //RETORNA SUCESSO
        return true;
    }


}

?>