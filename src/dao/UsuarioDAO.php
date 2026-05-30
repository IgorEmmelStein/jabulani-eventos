<?php

namespace Src\Dao;

use Src\Config\Database;
use Src\Models\Usuario;
use PDO;

class UsuarioDAO {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function cadastrar(Usuario $usuario) {
        $sql = "INSERT INTO Usuarios (nomeUsuario, email, senha, tipo) VALUES (:nome, :email, :senha, :tipo)";
        $stmt = $this->db->prepare($sql);
        
        $nome = $usuario->getNomeUsuario();
        $email = $usuario->getEmail();
        $senha = $usuario->getSenha();
        $tipo = $usuario->getTipo();

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':tipo', $tipo);

        return $stmt->execute();
    }

    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM Usuarios WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$resultado) {
            return null;
        }

        return new Usuario(
            $resultado['nomeUsuario'],
            $resultado['email'],
            $resultado['senha'],
            $resultado['tipo'],
            $resultado['idUsuario'],
            $resultado['registroCriado']
        );
    }

    public function atualizarPerfil(Usuario $usuario) {
        $sql = "UPDATE Usuarios SET nomeUsuario = :nome, email = :email WHERE idUsuario = :id";
        $stmt = $this->db->prepare($sql);

        $nome = $usuario->getNomeUsuario();
        $email = $usuario->getEmail();
        $id = $usuario->getIdUsuario();

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}