<?php

namespace Src\Dao;

use Src\Config\Database;
use Src\Models\Evento;
use Src\Models\Usuario;
use PDO;

class EventoDAO {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function criar(Evento $evento) {
        $sql = "INSERT INTO Eventos (titulo, descricao, local, dataEvento) VALUES (:titulo, :descricao, :local, :dataEvento)";
        $stmt = $this->db->prepare($sql);

        $titulo = $evento->getTitulo();
        $descricao = $evento->getDescricao();
        $local = $evento->getLocal();
        $dataEvento = $evento->getDataEvento();

        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':local', $local);
        $stmt->bindParam(':dataEvento', $dataEvento);

        return $stmt->execute();
    }

    public function listarTodos() {
        $sql = "SELECT * FROM Eventos ORDER BY dataEvento ASC";
        $stmt = $this->db->query($sql);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $eventos = [];
        foreach ($resultados as $linha) {
            $eventos[] = new Evento(
                $linha['titulo'],
                $linha['descricao'],
                $linha['local'],
                $linha['dataEvento'],
                $linha['id'],
                $linha['registroCriado']
            );
        }
        return $eventos;
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM Eventos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$linha) {
            return null;
        }

        return new Evento(
            $linha['titulo'],
            $linha['descricao'],
            $linha['local'],
            $linha['dataEvento'],
            $linha['id'],
            $linha['registroCriado']
        );
    }

    public function atualizar(Evento $evento) {
        $sql = "UPDATE Eventos SET titulo = :titulo, descricao = :descricao, local = :local, dataEvento = :dataEvento WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        $titulo = $evento->getTitulo();
        $descricao = $evento->getDescricao();
        $local = $evento->getLocal();
        $dataEvento = $evento->getDataEvento();
        $id = $evento->getId();

        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':local', $local);
        $stmt->bindParam(':dataEvento', $dataEvento);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function excluir($id) {
        $sql = "DELETE FROM Eventos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function buscar($termo) {
        $sql = "SELECT * FROM Eventos WHERE titulo LIKE :termo OR descricao LIKE :termo ORDER BY dataEvento ASC";
        $stmt = $this->db->prepare($sql);
        $likeTermo = '%' . $termo . '%';
        $stmt->bindParam(':termo', $likeTermo);
        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $eventos = [];
        foreach ($resultados as $linha) {
            $eventos[] = new Evento(
                $linha['titulo'],
                $linha['descricao'],
                $linha['local'],
                $linha['dataEvento'],
                $linha['id'],
                $linha['registroCriado']
            );
        }
        return $eventos;
    }

    public function inscreverUsuario($idUsuario, $idEvento) {
        $sql = "INSERT INTO Usuarios_Eventos (idUsuario, idEvento) VALUES (:idUsuario, :idEvento)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->bindParam(':idEvento', $idEvento, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function desinscreverUsuario($idUsuario, $idEvento) {
        $sql = "DELETE FROM Usuarios_Eventos WHERE idUsuario = :idUsuario AND idEvento = :idEvento";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->bindParam(':idEvento', $idEvento, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function listarPorUsuario($idUsuario) {
        $sql = "SELECT e.* FROM Eventos e 
                INNER JOIN Usuarios_Eventos ue ON e.id = ue.idEvento 
                WHERE ue.idUsuario = :idUsuario ORDER BY e.dataEvento ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $eventos = [];
        foreach ($resultados as $linha) {
            $eventos[] = new Evento(
                $linha['titulo'],
                $linha['descricao'],
                $linha['local'],
                $linha['dataEvento'],
                $linha['id'],
                $linha['registroCriado']
            );
        }
        return $eventos;
    }

    public function listarParticipantes($idEvento) {
        $sql = "SELECT u.* FROM Usuarios u 
                INNER JOIN Usuarios_Eventos ue ON u.idUsuario = ue.idUsuario 
                WHERE ue.idEvento = :idEvento ORDER BY u.nomeUsuario ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idEvento', $idEvento, PDO::PARAM_INT);
        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $usuarios = [];
        foreach ($resultados as $linha) {
            $usuarios[] = new Usuario(
                $linha['nomeUsuario'],
                $linha['email'],
                $linha['senha'],
                $linha['tipo'],
                $linha['idUsuario'],
                $linha['registroCriado']
            );
        }
        return $usuarios;
    }
}