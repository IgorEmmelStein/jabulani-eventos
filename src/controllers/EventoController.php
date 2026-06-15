<?php

namespace Src\Controllers;

use Src\Dao\EventoDAO;
use Src\Models\Evento;

class EventoController{
    private $eventoDao;
    public function __construct(){
        $this->eventoDao = new EventoDAO();
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
    }
    public function dashboard(){
        $meusEventosIds = [];
        $termo = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_SPECIAL_CHARS);
         if ($termo) {
            $eventos = $this->eventoDao->buscar($termo);
        } else {
            $eventos = $this->eventoDao->listarTodos();
        }
     if ($_SESSION['usuario_tipo'] === 'participante') {
            $meusEventos = $this->eventoDao->listarPorUsuario($_SESSION['usuario_id']);
            foreach ($meusEventos as $ev) {
                $meusEventosIds[] = $ev->getId();
            }
        }
      require_once __DIR__ . '/../views/dashboard.php';
    }
    public function criar(){
        if ($_SESSION['usuario_tipo'] !== 'admin') {
            header('Location: ' . BASE_URL . 'dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['titulo'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            $local = $_POST['local'] ?? '';
            $dataEvento = $_POST['dataEvento'] ?? '';

            if (!empty($titulo) && !empty($dataEvento)) {
                $evento = new Evento($titulo, $descricao, $local, $dataEvento);
                
                try {
                    if ($this->eventoDao->criar($evento)) {
                        header('Location: ' . BASE_URL . 'dashboard');
                        exit;
                    } else {
                        $erro = "Falha ao registrar o evento no banco de dados.";
                    }
                } catch (\Exception $e) {
                    $erro = "Erro no banco de dados: " . $e->getMessage();
                }
            } else {
                $erro = "Atenção: Preencha o Título e a Data do evento.";
            }
        }

        require_once __DIR__ . '/../views/admin/evento-form.php';
    }

    public function editar(){
        if ($_SESSION['usuario_tipo'] !== 'admin') {
            header('Location: ' . BASE_URL . 'dashboard');
            exit;
        }

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: ' . BASE_URL . 'dashboard');
            exit;
        }

        $evento = $this->eventoDao->buscarPorId($id);
        if (!$evento) {
            header('Location: ' . BASE_URL . 'dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['titulo'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            $local = $_POST['local'] ?? '';
            $dataEvento = $_POST['dataEvento'] ?? '';

            if (!empty($titulo) && !empty($dataEvento)) {
                $evento->setTitulo($titulo);
                $evento->setDescricao($descricao);
                $evento->setLocal($local);
                $evento->setDataEvento($dataEvento);

                try {
                    if ($this->eventoDao->atualizar($evento)) {
                        header('Location: ' . BASE_URL . 'dashboard');
                        exit;
                    } else {
                        $erro = "Falha desconhecida ao atualizar o evento.";
                    }
                } catch (\Exception $e) {
                    $erro = "Erro no banco de dados: " . $e->getMessage();
                }
            } else {
                $erro = "Atenção: Por favor, preencha o Título e a Data do evento.";
            }
        }

        require_once __DIR__ . '/../views/admin/evento-form.php';
    }
    public function excluir(){
        if ($_SESSION['usuario_tipo'] !== 'admin') {
            header('Location: ' . BASE_URL . 'dashboard');
            exit;
        }

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $this->eventoDao->excluir($id);
        }
        header('Location: ' . BASE_URL . 'dashboard');;
        exit;
    }
     public function inscrever(){
        if ($_SESSION['usuario_tipo'] !== 'participante') {
            header('Location: ' . BASE_URL . 'dashboard');
            exit;
        }

        $idEvento = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($idEvento) {
            $this->eventoDao->inscreverUsuario($_SESSION['usuario_id'], $idEvento);
        }
        header('Location: ' . BASE_URL . 'dashboard');
        exit;
    }

    public function desinscrever() {
     $idEvento = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

      if (!$idEvento) {
          header('Location: ' . BASE_URL . 'dashboard');
          exit;
      }

      if ($_SESSION['usuario_tipo'] === 'admin') {
          $idUsuario = filter_input(INPUT_GET, 'usuario_id', FILTER_VALIDATE_INT);
          if ($idUsuario) {
              $this->eventoDao->desinscreverUsuario($idUsuario, $idEvento);
          }
          header('Location: ' . BASE_URL . 'evento/detalhes?id=' . $idEvento);
          exit;
      } else {
          $this->eventoDao->desinscreverUsuario($_SESSION['usuario_id'], $idEvento);
          header('Location: ' . BASE_URL . 'dashboard');
          exit;
      }
  }

    public function detalhes(){
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

     public function exportarXml() {
        if ($_SESSION['usuario_tipo'] !== 'admin') {
            header('Location: dashboard');
            exit;
        }

        $eventos = $this->eventoDao->listarTodos();
        
        $xml = new \SimpleXMLElement('<eventos/>');
        foreach ($eventos as $ev) {
            $eventoXml = $xml->addChild('evento');
            $eventoXml->addChild('id', $ev->getId());
            $eventoXml->addChild('titulo', htmlspecialchars($ev->getTitulo()));
            $eventoXml->addChild('data', $ev->getDataEvento());
        }

        header('Content-Type: text/xml');
        header('Content-Disposition: attachment; filename="eventos.xml"');
        echo $xml->asXML();
        exit;
    }

    public function relatorioPdf() {
       // Não tenho ideia nem de por onde ocmeçar
    }
}