<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamentos</title>
    <link rel="stylesheet" href="agendamentos.css"> 
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="adicionar_agendamento.php">Agendar Horário</a></li>
                <li><a href="gestao_agendamentos.php">Gestao de Agendamento</a></li>
                <li><a href="suporte.html">Suporte</a></li>
            </ul>
        </nav>
    </header>
    
    <div class="container">
        <h1>Agendamentos</h1>
        <?php
        require_once 'config.php';

        // Consultar o banco de dados para obter os agendamentos
        $sql_consulta = "SELECT * FROM agendamentos ORDER BY data, hora";
        $resultado_consulta = $conexao->query($sql_consulta);

        if ($resultado_consulta->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Data</th><th>Hora</th><th>Serviço</th><th>Nome</th><th>E-mail</th></tr>";
            while ($row = $resultado_consulta->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . date('d/m/Y', strtotime($row['data'])) . "</td>";
                echo "<td>" . $row['hora'] . "</td>";
                echo "<td>" . $row['servico'] . "</td>";
                echo "<td>" . $row['nome'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Não há agendamentos disponíveis.</p>";
        }
        ?>
    </div>


</body>
</html>
