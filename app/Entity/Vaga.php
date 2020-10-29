<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;

class Vaga {

    /**
     * Identificador unico da vaga
     * @var integer
     */
    public $id;

    /**
     * Titulo da vaga
     * @var string
     */
    public $titulo;

    /**
     * Descripción da vaga (pode conter html)
     * @var string
     */
    public $descricao;

    /**
     * Define se a vaga ativa
     * @var integer (s/n)
     */
    public $ativo;

    /**
     * Data de publicacao da vaga
     * @var string
     */
    public $data;


    /**
     * Método responsavel por cadastrar uma nova vaga no banco
     * @return boolean
     */
    public function cadastrar() {
        //DEFINIR A DATA
        $this->data = date('Y-m-d H:i:s');
        //INSERIR A VAGA NO BANCO
        $obDatabase = new Database('vagas');
        //Se probo funcionamiento de conexion
        //echo "<pre>"; print_r($obDatabase); echo "</pre>"; exit;
        $this-> id = $obDatabase->insert([
                        'titulo'    => $this->titulo,
                        'descricao' => $this->descricao,
                        'ativo'     => $this->ativo,
                        'data'      => $this->data 
                    ]);
        //Probar que los datos fueron insertados
        //echo "<pre>"; print_r($this); echo "</pre>"; exit;

        //RETORNAR SUCCESSO
        return true;
    }


    /**
     * Método responsable de la eliminación de las vagas de la base de datos
     * @return boolean
     */
    public function excluir(){
        return (new Database('vagas'))->delete('id = '.$this->id);
    }






    /**
     * Metodo para actualizar la vaga en la base de datos
     * @return boolean
     */
    public function atualizar() {
        return (new Database('vagas'))->update('id = '.$this->id,[
                                                                    'titulo'    => $this->titulo,
                                                                    'descricao' => $this->descricao,
                                                                    'ativo'     => $this->ativo,
                                                                    'data'      => $this->data  
                                                                ]);
    }







    /**
     * Metodo responsable de obtener las vagas d el abase de datos
     * @param string $where
     * @param string $order 
     * @param string $limit
     * @return array
     */
    public static function getVagas($where=null, $order=null, $limit=null) {
        return (new Database('vagas'))->select($where,$order,$limit)
                                      ->fetchAll(PDO::FETCH_CLASS,self::class);
    }


    /**
     * Método responsable de buscar una vaga en base  a su ID
     * @param integer $id
     * @return Vaga
     */
    public static function getVaga($id) {
        return (new Database('vagas'))->select('id = '.$id)
                                      ->fetchObject(self::class);
      }




}

?>