<?php

session_start();

spl_autoload_register(function ($class) {
    $prefix = 'Src\\';
    $base_dir = __DIR__ . '/../src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

use Src\Controllers\AuthController;
use Src\Controllers\EventoController;

$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '/';
$routeSegments = explode('/', $url);

if ($routeSegments[0] === 'api') {
    header('Content-Type: application/json; charset=utf-8');
    
    use src\controllers\ApiController;
    $apiCtrl = new ApiController();
    
    if (isset($routeSegments[1]) && $routeSegments[1] === 'eventos' && isset($routeSegments[2]) && $routeSegments[2] === 'lista') {
        $apiCtrl->listarEventos();
    }
    
    if (isset($routeSegments[1]) && $routeSegments[1] === 'usuarios' && isset($routeSegments[2]) && $routeSegments[2] === 'lista') {
        $apiCtrl->listarUsuarios();
    }
    
    http_response_code(404);
    echo json_encode(["erro" => "Endpoint nao encontrado"]);
    exit;
}

switch ($url) {
    case '/':
    case 'login':
        $auth = new AuthController();
        $auth->login();
        break;

    case 'cadastro':
        $auth = new AuthController();
        $auth->cadastro();
        break;

    case 'logout':
        $auth = new AuthController();
        $auth->logout();
        break;

    case 'dashboard':
        $eventoCtrl = new EventoController();
        $eventoCtrl->dashboard();
        break;

    case 'evento/criar':
        $eventoCtrl = new EventoController();
        $eventoCtrl->criar();
        break;

    case 'evento/editar':
        $eventoCtrl = new EventoController();
        $eventoCtrl->editar();
        break;

    case 'evento/excluir':
        $eventoCtrl = new EventoController();
        $eventoCtrl->excluir();
        break;

    case 'evento/inscrever':
        $eventoCtrl = new EventoController();
        $eventoCtrl->inscrever();
        break;

    case 'evento/desinscrever':
        $eventoCtrl = new EventoController();
        $eventoCtrl->desinscrever();
        break;

    case 'evento/detalhes':
        $eventoCtrl = new EventoController();
        $eventoCtrl->detalhes();
        break;

    default:
        http_response_code(404);
        echo "<h1>Pagina 404 - Rota nao encontrada</h1>";
        break;
}