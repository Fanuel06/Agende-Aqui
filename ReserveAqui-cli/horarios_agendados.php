<?php
require_once 'config.php';

// Obter o primeiro dia do mês atual
$primeiro_dia_mes_atual = date('Y-m-01');

// Obter o último dia do mês atual
$ultimo_dia_mes_atual = date('Y-m-t');

// Consultar o banco de dados para obter os horários agendados para o mês atual
$sql_consulta = "SELECT data, hora FROM agendamentos WHERE data BETWEEN '$primeiro_dia_mes_atual' AND '$ultimo_dia_mes_atual' ORDER BY data, hora";
$resultado_consulta = $conexao->query($sql_consulta);
$horarios_agendados = [];

if ($resultado_consulta->num_rows > 0) {
    while ($row = $resultado_consulta->fetch_assoc()) {
        // Armazenar os horários agendados em um array
        $horarios_agendados[] = array('data' => $row['data'], 'hora' => $row['hora']);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horários Agendados para o Mês Atual</title>
    <link rel="stylesheet" href="h_agendados.css"> <!-- Adicione um arquivo CSS para estilização, se necessário -->
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.html">Página Inicial</a></li>
            <li><a href="reserva.php">Agendar</a></li>
            <li><a href="horarios_agendados.php">Horários Agendados</a></li>
            <li><a href="sobre.html">Sobre</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Horários Agendados para o Mês Atual</h2>
        <?php
        if (empty($horarios_agendados)) {
            echo "<p>Não há horários agendados para o mês atual.</p>";
        } else {
            echo "<ul>";
            foreach ($horarios_agendados as $agendamento) {
                $data_formatada = date('d/m/Y', strtotime($agendamento['data']));
                echo "<li>Data: $data_formatada - Horário: {$agendamento['hora']}</li>";
            }
            echo "</ul>";
        }
        ?>
    </div>
</body>
</html>
