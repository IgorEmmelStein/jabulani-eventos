<?php

namespace Src\Controllers;

use Src\Dao\UsuarioDAO;
use Src\Models\Usuario;

class AuthController {
    private $usuarioDao;

    public function __construct() {
        $this->usuarioDao = new UsuarioDAO();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $senha = $_POST['senha'] ?? '';

            $usuario = $this->usuarioDao->buscarPorEmail($email);

            if ($usuario && password_verify($senha, $usuario->getSenha())) {
                $_SESSION['usuario_id'] = $usuario->getIdUsuario();
                $_SESSION['usuario_nome'] = $usuario->getNomeUsuario();
                $_SESSION['usuario_email'] = $usuario->getEmail();
                $_SESSION['usuario_tipo'] = $usuario->getTipo();

                header('Location: ' . BASE_URL . 'dashboard');
                exit;
            }

            $erro = "Credenciais invalidas";
            require_once __DIR__ . '/../views/login.php';
            exit;
        }

        require_once __DIR__ . '/../views/login.php';
    }

    public function cadastro() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $senha = $_POST['senha'] ?? '';
            
            if ($nome && $email && $senha) {
                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
                $novoUsuario = new Usuario($nome, $email, $senhaHash, 'participante');

                if ($this->usuarioDao->cadastrar($novoUsuario)) {
                    header('Location: ' . BASE_URL . 'login');
                    exit;
                }
            }

            $erro = "Erro ao cadastrar usuario";
            require_once __DIR__ . '/../views/cadastro.php';
            exit;
        }

        require_once __DIR__ . '/../views/cadastro.php';
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . 'login');
        exit;
    }
}