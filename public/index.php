<?php
session_start();

$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '/';

$routeSegments = explode('/', $url);

if ($routeSegments[0] === 'api') {

    header('Content-Type: application/json; charset=utf-8');

    if (isset($routeSegments[1]) && $routeSegments[1] === 'eventos' && isset($routeSegments[2]) && $routeSegments[2] === 'lista') {

        echo json_encode([
            ["id" => 1, "titulo" => "Conferência de Tecnologia 2026", "local" => "Porto Alegre, POA"],
            ["id" => 2, "titulo" => "Formatura TADS 2026", "local" => "Venâncio Aires, VA"]
        ]);
        exit;
    }


    http_response_code(404);
    echo json_encode(["erro" => "Endpoint nao encontrado"]);
    exit;
}

switch ($url) {
    case '/':
    case 'login':

        echo "<h1>Tela de Login (Carregar a view correspondente)</h1>";
        break;

    case 'cadastro':
        echo "<h1>Tela de Cadastro de Participante</h1>";
        break;

    case 'dashboard':
        echo "<h1>Dashboard Geral / Listagem de Eventos</h1>";
        break;

    default:
        http_response_code(404);
        echo "<h1>Página 404 - Rota não encontrada</h1>";
        break;
}
