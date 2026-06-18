<?php

require_once __DIR__ . '/app/Controllers/AuthController.php';
require_once __DIR__ . '/app/Controllers/UsuariosController.php';
require_once __DIR__ . '/app/Middleware/auth.php';

$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'login';

switch ($controller) {
    case 'auth':
        $authController = new AuthController();

        switch ($action) {
            case 'login':
                $authController->exibirLogin();
                break;

            case 'entrar':
                $authController->entrar();
                break;

            case 'dashboard':
                $authController->dashboard();
                break;

            case 'logout':
                $authController->logout();
                break;

            default:
                http_response_code(404);
                echo 'Ação de autenticação não encontrada.';
        }

        break;

    case 'usuarios':
        exigirAutenticacao();

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

        break;

    default:
        http_response_code(404);
        echo 'Controller não encontrado.';
}