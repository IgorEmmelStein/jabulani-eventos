<?php

namespace Src\Dao;

use Src\Config\Database;
use Src\Models\Usuario;
use PDO;

class UsuarioDAO
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function cadastrar(Usuario $usuario)
    {
        $sql = "INSERT INTO Usuarios (nomeUsuario, email, telefone, senha, tipo) VALUES (:nome, :email, :telefone, :senha, :tipo)";
        $stmt = $this->db->prepare($sql);

        $nome = $usuario->getNomeUsuario();
        $email = $usuario->getEmail();
        $telefone = $usuario->getTelefone();
        $senha = $usuario->getSenha();
        $tipo = $usuario->getTipo();

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':tipo', $tipo);

        // Captura o erro caso adicione um usuario que ja tem o mesmo valor no banco
        try {
            return $stmt->execute();
        } catch (\PDOException $e) {
            // O código 23000 representa uma violação de integridade no MySQL
            if ($e->getCode() == 23000) {
                return false;
            }
            // Lança a exceção novamente caso seja um erro no banco diferente de duplicidade
            throw $e;
        }
    }

    public function buscarPorEmail($email)
    {
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
            $resultado['telefone'],
            $resultado['senha'],
            $resultado['tipo'],
            $resultado['idUsuario'],
            $resultado['registroCriado']
        );
    }

    public function atualizarPerfil(Usuario $usuario)
    {
        $sql = "UPDATE Usuarios SET nomeUsuario = :nome, email = :email, telefone = :telefone WHERE idUsuario = :id";
        $stmt = $this->db->prepare($sql);

        $nome = $usuario->getNomeUsuario();
        $email = $usuario->getEmail();
        $telefone = $usuario->getTelefone();
        $id = $usuario->getIdUsuario();

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function buscarParticipantes($termo)
    {
        // 1. Alteramos os parâmetros para nomes únicos (:termo1 e :termo2)
        $sql = "SELECT * FROM Usuarios WHERE tipo = 'participante' AND (nomeUsuario LIKE :termo1 OR email LIKE :termo2)";

        $stmt = $this->db->prepare($sql);

        $likeTermo = '%' . $termo . '%';

        // 2. Fazemos o bind dos dois parâmetros individualmente
        $stmt->bindParam(':termo1', $likeTermo);
        $stmt->bindParam(':termo2', $likeTermo);

        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $usuarios = [];

        foreach ($resultados as $resultado) {
            $usuarios[] = new Usuario(
                $resultado['nomeUsuario'],
                $resultado['email'],
                $resultado['telefone'],
                $resultado['senha'],
                $resultado['tipo'],
                $resultado['idUsuario'],
                $resultado['registroCriado']
            );
        }

        return $usuarios;
    }
}
