<?php

namespace Src\Controllers;

use Src\Dao\EventoDAO;
use Src\Models\Evento;

class EventoController {
    private $eventoDao;

    public function __construct() {
        $this->eventoDao = new EventoDAO();
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: login');
            exit;
        }
    }

    public function dashboard() {
        $termo = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_SPECIAL_CHARS);
        
        if ($termo) {
            $eventos = $this->eventoDao->buscar($termo);
        } else {
            $eventos = $this->eventoDao->listarTodos();
        }

        $meusEventosIds = [];
        if ($_SESSION['usuario_tipo'] === 'participante') {
            $meusEventos = $this->eventoDao->listarPorUsuario($_SESSION['usuario_id']);
            foreach ($meusEventos as $ev) {
                $meusEventosIds[] = $ev->getId();
            }
        }

        require_once __DIR__ . '/../Views/dashboard.php';
    }

    public function criar() {
        if ($_SESSION['usuario_tipo'] !== 'admin') {
            header('Location: dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
            $local = filter_input(INPUT_POST, 'local', FILTER_SANITIZE_SPECIAL_CHARS);
            $dataEvento = filter_input(INPUT_POST, 'dataEvento', FILTER_SANITIZE_SPECIAL_CHARS);

            if ($titulo && $dataEvento) {
                $evento = new Evento($titulo, $descricao, $local, $dataEvento);
                if ($this->eventoDao->criar($evento)) {
                    header('Location: dashboard');
                    exit;
                }
            }
        }

        require_once __DIR__ . '/../Views/admin/evento-form.php';
    }

    public function editar() {
        if ($_SESSION['usuario_tipo'] !== 'admin') {
            header('Location: dashboard');
            exit;
        }

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: dashboard');
            exit;
        }

        $evento = $this->eventoDao->buscarPorId($id);
        if (!$evento) {
            header('Location: dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
            $local = filter_input(INPUT_POST, 'local', FILTER_SANITIZE_SPECIAL_CHARS);
            $dataEvento = filter_input(INPUT_POST, 'dataEvento', FILTER_SANITIZE_SPECIAL_CHARS);

            if ($titulo && $dataEvento) {
                $evento->setTitulo($titulo);
                $evento->setDescricao($descricao);
                $evento->setLocal($local);
                $evento->setDataEvento($dataEvento);

                if ($this->eventoDao->atualizar($evento)) {
                    header('Location: dashboard');
                    exit;
                }
            }
        }

        require_once __DIR__ . '/../Views/admin/evento-form.php';
    }

    public function excluir() {
        if ($_SESSION['usuario_tipo'] !== 'admin') {
            header('Location: dashboard');
            exit;
        }

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $this->eventoDao->excluir($id);
        }

        header('Location: dashboard');
        exit;
    }

    public function inscrever() {
        if ($_SESSION['usuario_tipo'] !== 'participante') {
            header('Location: dashboard');
            exit;
        }

        $idEvento = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($idEvento) {
            $this->eventoDao->inscreverUsuario($_SESSION['usuario_id'], $idEvento);
        }

        header('Location: dashboard');
        exit;
    }

    public function desinscrever() {
        if ($_SESSION['usuario_tipo'] !== 'participante') {
            header('Location: dashboard');
            exit;
        }

        $idEvento = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($idEvento) {
            $this->eventoDao->desinscreverUsuario($_SESSION['usuario_id'], $idEvento);
        }

        header('Location: dashboard');
        exit;
    }

    public function detalhes() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: dashboard');
            exit;
        }

        $evento = $this->eventoDao->buscarPorId($id);
        if (!$evento) {
            header('Location: dashboard');
            exit;
        }

        $participantes = [];
        if ($_SESSION['usuario_tipo'] === 'admin') {
            $participantes = $this->eventoDao->listarParticipantes($id);
        }

        require_once __DIR__ . '/../Views/admin/evento-detalhes.php';
    }
}