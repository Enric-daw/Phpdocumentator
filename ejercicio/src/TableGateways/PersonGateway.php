<?php
namespace Src\TableGateways;

class PersonGateway {
   /**
   * @access private
   * @var DatabaseConnector
   */
    private $db = null;


    /**
    * Constructor de la clase PersonController.php. 
    * @param $db base de datos donde vamos a conectarnos
    */
    public function __construct($db)
    {
        $this->db = $db;
    }


    /**
    * Funcionalidad que devuelve un array asociativo con todos los registros de la tabla person.
    * En caso de error al ejecutar la consulta, se muestra el mensaje del tipo de error.
    * @return Result
    */
    public function findAll()
    {
        $statement = "
            SELECT
                id, firstname, lastname, firstparent_id, secondparent_id
            FROM
                person;
        ";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }


     /**
     * Funcionalidad que busca un registro con la id especificada en la tabla person. 
     * En caso de error al ejecutar la consulta, se muestra el mensaje del tipo de error.     
     * @param $id int
     * @return Result
     */   
    public function find($id)
    {
        $statement = "
            SELECT
                id, firstname, lastname, firstparent_id, secondparent_id
            FROM
                person
            WHERE id = ?;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }


    /**
    * Funcionalidad que inserta un registro en la tabla person.
    * En caso de error al ejecutar la consulta, se muestra el mensaje del tipo de error.
    * @param $input Array    
    * @return int
    */
    public function insert(Array $input)
    {
        $statement = "
            INSERT INTO person
                (firstname, lastname, firstparent_id, secondparent_id)
            VALUES
                (:firstname, :lastname, :firstparent_id, :secondparent_id);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'firstname' => $input['firstname'],
                'lastname'  => $input['lastname'],
                'firstparent_id' => $input['firstparent_id'] ?? null,
                'secondparent_id' => $input['secondparent_id'] ?? null,
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }


    /**
    * Funcionalidad que actualiza un registro con el id indicado en la tabla person.
    * En caso de error al ejecutar la consulta, se muestra el mensaje del tipo de error.
    * @param $id número que identifica el registro que se va a actualizar.
    * @param $input Array con el nuevo contenido del registro que se va a actualizar.
    * @return int
    */
    public function update($id, Array $input)
    {
        $statement = "
            UPDATE person
            SET
                firstname = :firstname,
                lastname  = :lastname,
                firstparent_id = :firstparent_id,
                secondparent_id = :secondparent_id
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
                'firstname' => $input['firstname'],
                'lastname'  => $input['lastname'],
                'firstparent_id' => $input['firstparent_id'] ?? null,
                'secondparent_id' => $input['secondparent_id'] ?? null,
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }


    /**
    * Funcionalidad que elimina un registro con el id indicado en la tabla person.
    * En caso de error al ejecutar la consulta, se muestra el mensaje del tipo de error.
    * @param $id número que identifica el registro que se va a actualizar.
    * @return int
    */
    public function delete($id)
    {
        $statement = "
            DELETE FROM person
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('id' => $id));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
