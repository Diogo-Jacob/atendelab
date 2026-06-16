<?php

require_once __DIR__ . '/app/Controllers/UsuariosController.php';

$controller = $_GET['controller'] ?? '';
$action = $_GET['action'] ?? '';

if ($controller !== 'usuarios') {
    http_response_code(404);
    header('Content-Type: application/json; charset=utf-8');

    echo json_encode(
        ['erro' => 'Controller não encontrado.'],
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    );

    exit;
}

$usuariosController = new UsuariosController();

switch ($action) {
    case 'listar':
        $usuariosController->listar();
        break;

    case 'buscar':
    case 'buscarPorId':
        $usuariosController->buscarPorId();
        break;

    case 'criar':
        $usuariosController->criar();
        break;

    case 'atualizar':
        $usuariosController->atualizar();
        break;

    case 'excluir':
    case 'inativar':
        $usuariosController->excluir();
        break;

    default:
        http_response_code(404);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode(
            ['erro' => 'Ação de usuários não encontrada.'],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
}