<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';

$totalAtendimentos = $pdo->query("SELECT COUNT(*) FROM atendimentos")->fetchColumn();
$totalAbertos = $pdo->query("SELECT COUNT(*) FROM atendimentos WHERE status = 'aberto'")->fetchColumn();
$totalConcluidos = $pdo->query("SELECT COUNT(*) FROM atendimentos WHERE status = 'concluido'")->fetchColumn();
$totalPessoas = $pdo->query("SELECT COUNT(*) FROM pessoas")->fetchColumn();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - AtendeLab</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f5f7;
            color: #1f2937;
        }

        header {
            background: #111827;
            color: #ffffff;
            padding: 18px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header a {
            color: #ffffff;
            text-decoration: none;
            background: #dc2626;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 14px;
        }

        main {
            padding: 32px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 18px;
            margin-top: 24px;
        }

        .card {
            background: #ffffff;
            padding: 22px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        .card span {
            display: block;
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .card strong {
            font-size: 30px;
            color: #2563eb;
        }

        .menu {
            margin-top: 32px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .menu a {
            background: #2563eb;
            color: #ffffff;
            padding: 12px 16px;
            border-radius: 8px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<header>
    <div>
        <strong>AtendeLab</strong>
        <span> | Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></span>
    </div>

    <a href="logout.php">Sair</a>
</header>

<main>
    <h1>Dashboard</h1>
    <p>Resumo geral dos atendimentos acadêmicos cadastrados no sistema.</p>

    <section class="cards">
        <div class="card">
            <span>Total de atendimentos</span>
            <strong><?php echo $totalAtendimentos; ?></strong>
        </div>

        <div class="card">
            <span>Atendimentos abertos</span>
            <strong><?php echo $totalAbertos; ?></strong>
        </div>

        <div class="card">
            <span>Atendimentos concluídos</span>
            <strong><?php echo $totalConcluidos; ?></strong>
        </div>

        <div class="card">
            <span>Pessoas cadastradas</span>
            <strong><?php echo $totalPessoas; ?></strong>
        </div>
    </section>

    <section class="menu">
        <a href="pessoas/index.php">Pessoas atendidas</a>
        <a href="#">Tipos de atendimento</a>
        <a href="#">Atendimentos</a>
        <a href="#">Relatórios</a>
    </section>
</main>

</body>
</html>