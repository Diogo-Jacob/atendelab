<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';

$mensagem = $_GET['mensagem'] ?? '';

$sql = "SELECT 
            atendimentos.id,
            atendimentos.data_atendimento,
            atendimentos.hora_atendimento,
            atendimentos.descricao,
            atendimentos.status,
            pessoas.nome AS pessoa_nome,
            tipos_atendimentos.nome AS tipo_nome,
            usuarios.nome AS usuario_nome
        FROM atendimentos
        INNER JOIN pessoas ON atendimentos.pessoa_id = pessoas.id
        INNER JOIN tipos_atendimentos ON atendimentos.tipo_atendimento_id = tipos_atendimentos.id
        INNER JOIN usuarios ON atendimentos.usuario_id = usuarios.id
        ORDER BY atendimentos.criado_em DESC";

$stmt = $pdo->query($sql);
$atendimentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Atendimentos - AtendeLab</title>
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

        .topo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .btn {
            background: #2563eb;
            color: #ffffff;
            padding: 10px 14px;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            display: inline-block;
        }

        .btn-secundario {
            background: #6b7280;
        }

        .btn-alerta {
            background: #dc2626;
        }

        .btn-verde {
            background: #16a34a;
        }

        .mensagem {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        th, td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
            font-size: 14px;
            vertical-align: top;
        }

        th {
            background: #f9fafb;
            color: #374151;
        }

        .acoes {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .status-aberto {
            color: #b45309;
            font-weight: bold;
        }

        .status-em_andamento {
            color: #2563eb;
            font-weight: bold;
        }

        .status-concluido {
            color: #166534;
            font-weight: bold;
        }

        .descricao {
            max-width: 280px;
        }
    </style>
</head>
<body>

<header>
    <div>
        <strong>AtendeLab</strong>
        <span> | Atendimentos</span>
    </div>

    <a href="../logout.php">Sair</a>
</header>

<main>
    <div class="topo">
        <div>
            <h1>Atendimentos</h1>
            <p>Registro e acompanhamento dos atendimentos acadêmicos realizados.</p>
        </div>

        <div>
            <a class="btn btn-secundario" href="../dashboard.php">Voltar</a>
            <a class="btn" href="criar.php">Novo atendimento</a>
        </div>
    </div>

    <?php if ($mensagem): ?>
        <div class="mensagem">
            <?php echo htmlspecialchars($mensagem); ?>
        </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Hora</th>
                <th>Pessoa</th>
                <th>Tipo</th>
                <th>Responsável</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            <?php if (count($atendimentos) > 0): ?>
                <?php foreach ($atendimentos as $atendimento): ?>
                    <tr>
                        <td><?php echo date('d/m/Y', strtotime($atendimento['data_atendimento'])); ?></td>
                        <td><?php echo substr($atendimento['hora_atendimento'], 0, 5); ?></td>
                        <td><?php echo htmlspecialchars($atendimento['pessoa_nome']); ?></td>
                        <td><?php echo htmlspecialchars($atendimento['tipo_nome']); ?></td>
                        <td><?php echo htmlspecialchars($atendimento['usuario_nome']); ?></td>
                        <td class="descricao"><?php echo htmlspecialchars($atendimento['descricao']); ?></td>
                        <td>
                            <span class="status-<?php echo htmlspecialchars($atendimento['status']); ?>">
                                <?php echo htmlspecialchars($atendimento['status']); ?>
                            </span>
                        </td>
                        <td>
                            <div class="acoes">
                                <a class="btn btn-verde" href="visualizar.php?id=<?php echo $atendimento['id']; ?>">Ver</a>
                                <a class="btn" href="editar.php?id=<?php echo $atendimento['id']; ?>">Editar</a>
                                <a class="btn btn-alerta" href="excluir.php?id=<?php echo $atendimento['id']; ?>" onclick="return confirm('Deseja realmente remover este atendimento?')">Excluir</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Nenhum atendimento cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>

</body>
</html>