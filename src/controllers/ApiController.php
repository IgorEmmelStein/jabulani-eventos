<?php

namespace Src\Controllers;

use Src\Dao\EventoDAO;
use Src\Dao\UsuarioDAO;

class ApiController
{
    private $eventoDao;
    private $usuarioDao;

    public function __construct()
    {
        $headers = apache_request_headers();
        if (!isset($headers['Authorization']) || $headers['Authorization'] !== 'Bearer token2026_seguro_jabulani') {
            http_response_code(401);
            echo json_encode(["erro" => "Unauthorized"]);
            exit;
        }
        $this->eventoDao = new EventoDAO();
        $this->usuarioDao = new UsuarioDAO();
    }

    public function listarEventos()
    {
        $eventosObj = $this->eventoDao->listarTodos();
        $eventosArray = [];

        foreach ($eventosObj as $ev) {
            $eventosArray[] = [
                "id" => $ev->getId(),
                "titulo" => $ev->getTitulo(),
                "descricao" => $ev->getDescricao(),
                "local" => $ev->getLocal(),
                "data_evento" => $ev->getDataEvento(),
                "registro_criado" => $ev->getRegistroCriado()
            ];
        }

        echo json_encode($eventosArray);
        exit;
    }

    public function listarUsuarios()
    {
        $sql = "SELECT idUsuario, nomeUsuario, email, registroCriado FROM Usuarios WHERE tipo = 'participante' ORDER BY nomeUsuario ASC";
        $db = \src\config\Database::getConnection();
        $stmt = $db->query($sql);
        $resultados = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        echo json_encode($resultados);
        exit;
    }
}