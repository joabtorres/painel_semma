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
     * @return usuarioModel $inst - retorna a instancia criada
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
    /**
     * Está função é responsável para cadastrar novos usuarios;
     * @param Array $data - Dados salvo em array para seres setados por um foreach;
     * @access public
     * @return boolean 
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public function create($data)
    {
        try {
            $sql = $this->db->prepare('INSERT INTO usuario (nome, nome_completo, email, senha, anexo, status) VALUES (:nome, :nome_completo, :email, :senha, :anexo, :status)');
            $sql->bindValue(":nome", $data['nome']);
            $sql->bindValue(":nome_completo", $data['nome_completo']);
            $sql->bindValue(":email", $data['email']);
            $sql->bindValue(":senha", $data['senha']);
            $sql->bindValue(":anexo", $data['anexo']);
            $sql->bindValue(":status", $data['status']);
            $sql->execute();
            return true;
        } catch (PDOException $ex) {
            die($ex->getMessage());
            return false;
        }
    }

    /**
     * Está função é responsável para remover usuario;
     * @param Integer $id - id do usuario;
     * @access public
     * @return boolean 
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public function remove($id)
    {
        try {
            $sql = $this->db->prepare('DELETE FROM usuario WHERE id=:id');
            $sql->bindValue(":id", $id);
            $sql->execute();
            return true;
        } catch (PDOException $ex) {
            die($ex->getMessage());
            return false;
        }
    }
    /**
     * Está função é responsável para altera um registro específico;
     * @param String $sql_command  - Comando SQL;
     * @param Array $data - Dados salvo em array para seres setados por um foreach;
     * @access public
     * @return bollean TRUE ou FALSE
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public function update($data)
    {
        try {
            if (isset($data['senha']) && !empty($data['senha'])) {
                $sql = "UPDATE usuario SET nome=:nome, nome_completo=:nome_completo, email=:email, senha=:senha, status=:status, anexo=:anexo WHERE id=:id";
            } else {
                $sql = "UPDATE usuario SET nome=:nome, nome_completo=:nome_completo, email=:email,  status=:status, anexo=:anexo WHERE id=:id";
            }
            $sql = $this->db->prepare($sql);
            $sql->bindValue(':nome', $data['nome']);
            $sql->bindValue(':nome_completo', $data['nome_completo']);
            $sql->bindValue(':email', $data['email']);
            //verifica se foi setado a nova senha
            if (isset($data['senha']) && !empty($data['senha'])) {
                $sql->bindValue(':senha', $data['senha']);
            }
            $sql->bindValue(':status', $data['status']);
            $sql->bindValue(':anexo', $data['anexo']);
            $sql->bindValue(':id', $data['id']);
            $sql->execute();
            return true;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return null;
        }
    }

    /**
     * Está função é responsável para consultas no banco e retorna os resultados obtidos;
     * @param String $sql_command  - Comando SQL;
     * @param Array $data - Dados salvo em array para seres setados por um foreach;
     * @access public
     * @return array $sql->fetch() [caso encontre] | bollean FALSE [caso contrário] 
     * @author Joab Torres <joabtorres1508@gmail.com>
     */
    public function usuario_especifico($sql_command, $data)
    {
        if (!empty($data)) {
            $sql = $this->db->prepare($sql_command);

            foreach ($data as $indice => $valor) {
                $sql->bindValue(":" . $indice, $valor);
            }
            $sql->execute();
        } else {
            $sql = $this->db->query($sql_command);
        }
        if ($sql->rowCount() > 0) {
            return $sql->fetch();
        } else {
            return FALSE;
        }
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
