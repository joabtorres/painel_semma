<?php
class usuarioModel extends database
{
    /**
     * PDO $db - classe de conexão com o banco de dados;
     * @access private
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    private $db;
    /**
     * Está função tem como objetivo instancia a conexão do banco de dados
     * @access private
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    private function __construct()
    {
        $this->db = database::getInstance()->getPDO();
    }
    /**
     * Está função tem como objetivo instancia a classe crudModel uma vez e depois só refazer a reinstancia da mesma
     * @access public
     * @return crudModel $inst - retorna a instancia criada
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public static function getInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new usuarioModel();
        }
        return $inst;
    }

    public function verificarEmail($email)
    {
        try {
            $sql = $this->db->prepare("SELECT * FROM usuario WHERE email=:email");
            $sql->bindValue(":email", $email);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetch();
            } else {
                return false;
            }
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
    }
}
