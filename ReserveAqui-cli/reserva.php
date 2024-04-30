<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fazer Reserva</title>
    <link rel="stylesheet" href="reserva.css">
</head>
<body>

    <!-- Barra de Navegação -->
    <nav>
        <ul>
            <li><a href="index.html">Página Inicial</a></li>
            <li><a href="horarios_agendados.php">Horários Agendados</a></li>
            <li><a href="sobre.html">Sobre</a></li>
        </ul>
    </nav>

    <!-- Conteúdo da Página -->
    <div class="container">
        <h1>Fazer Reserva</h1>
        <p>Selecione o serviço desejado e escolha a data e hora para a sua reserva.</p>
        
        <form id="reservaForm" action="processa_agendamento.php" method="post">
            <label for="servico">Serviço:</label>
            <select id="servico" name="servico" required>
                <option value="corte">Corte de Cabelo</option>
                <option value="manicure">Manicure</option>
                <option value="massagem">Massagem</option>
                <!-- Adicione mais opções de serviços conforme necessário -->
            </select>
        
            <label for="data">Data:</label>
            <input type="date" id="data" name="data" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
        
            <label for="hora">Hora:</label>
            <select id="hora" name="hora" required>
                <!-- Adicione opções de hora em hora -->
                <?php
                for ($hour = 8; $hour <= 18; $hour++) {
                    echo "<option value='$hour:00'>$hour:00</option>";
                }
                ?>
            </select>
        
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
        
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
        
            <input type="submit" value="Agendar">
        </form>
        
    </div>
    

    <!-- Rodapé -->
    <footer>
        <p>&copy; 2024 Sistema de Reservas. Todos os direitos reservados.</p>
    </footer>

    <!-- Script JavaScript -->
    <script>
        // Verificar data atual e ajustar opções de hora
        var dataInput = document.getElementById('data');
        var horaSelect = document.getElementById('hora');
        var dataAtual = new Date();

        dataInput.addEventListener('change', function() {
            var dataSelecionada = new Date(this.value);
            var horaAtual = dataAtual.getHours();

            // Restrição: Não reservar datas passadas
            if (dataSelecionada < dataAtual) {
                alert('Por favor, selecione uma data futura.');
                this.value = '';
            }

            // Restrição: Não reservar sábados ou domingos
            if (dataSelecionada.getDay() === 0 || dataSelecionada.getDay() === 6) {
                alert('Desculpe, não aceitamos reservas para aos domingos.');
                this.value = '';
            }
            // Se a data selecionada for igual à data atual
            if (dataSelecionada.getDate() === dataAtual.getDate() && dataSelecionada.getMonth() === dataAtual.getMonth() && dataSelecionada.getFullYear() === dataAtual.getFullYear()) {
                // Ajustar opções de hora para começar a partir da próxima hora
                while (horaSelect.firstChild) {
                    horaSelect.removeChild(horaSelect.firstChild);
                }
                for (var hour = horaAtual + 1; hour <= 18; hour++) {
                    var option = document.createElement('option');
                    option.value = hour + ':00';
                    option.textContent = hour + ':00';
                    horaSelect.appendChild(option);
                }
            } else {
                // Resetar opções de hora para o horário padrão (8h às 18h)
                while (horaSelect.firstChild) {
                    horaSelect.removeChild(horaSelect.firstChild);
                }
                for (var hour = 8; hour <= 18; hour++) {
                    var option = document.createElement('option');
                    option.value = hour + ':00';
                    option.textContent = hour + ':00';
                    horaSelect.appendChild(option);
                }
            }
        });
    </script>

</body>
</html>