<?php

require_once __DIR__ . '/../Middleware/auth.php';

class DashboardController
{
    private PDO $pdo;

    public function __construct()
    {
        require __DIR__ . '/../../config/database.php';

        $this->pdo = $pdo;
    }

    private function responderJson(
        array $dados,
        int $status = 200
    ): void {
        http_response_code($status);

        header(
            'Content-Type: application/json; charset=utf-8'
        );

        echo json_encode(
            $dados,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
    }

    public function resumo(): void
    {
        exigirAutenticacao();

        $totalPessoas = (int) $this->pdo
            ->query(
                "SELECT COUNT(*)
                 FROM pessoas"
            )
            ->fetchColumn();

        $totalTipos = (int) $this->pdo
            ->query(
                "SELECT COUNT(*)
                 FROM tipos_atendimentos"
            )
            ->fetchColumn();

        $totalAtendimentos = (int) $this->pdo
            ->query(
                "SELECT COUNT(*)
                 FROM atendimentos"
            )
            ->fetchColumn();

        $sqlRecentes = "SELECT
                            a.id,
                            p.nome AS pessoa_nome,
                            t.nome AS tipo_nome,
                            u.nome AS usuario_nome,
                            a.data_atendimento,
                            a.status
                       FROM atendimentos a
                       INNER JOIN pessoas p
                           ON p.id = a.pessoa_id
                       INNER JOIN tipos_atendimentos t
                           ON t.id = a.tipo_atendimento_id
                       INNER JOIN usuarios u
                           ON u.id = a.usuario_id
                       ORDER BY a.id DESC
                       LIMIT 5";

        $stmt = $this->pdo->query($sqlRecentes);

        $recentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->responderJson([
            'indicadores' => [
                'total_pessoas' => $totalPessoas,
                'total_tipos' => $totalTipos,
                'total_atendimentos' => $totalAtendimentos
            ],
            'atendimentos_recentes' => $recentes
        ]);
    }
}