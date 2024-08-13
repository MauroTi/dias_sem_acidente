<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contagem de Dias Sem Acidentes de Trabalho</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function updateDaysCount() {
            fetch('config.php')
                .then(response => response.json())
                .then(data => {
                    const lastAccidentDate = data.lastAccidentDate;
                    const startDate = new Date(lastAccidentDate);
                    const currentDate = new Date();
                    
                    if (lastAccidentDate) {
                        const timeDiff = currentDate - startDate;
                        const daysCount = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                        document.getElementById('days-count').textContent = daysCount;
                        document.getElementById('last-accident-date').textContent = 'Data do último acidente: ' + lastAccidentDate;
                    } else {
                        document.getElementById('days-count').textContent = '0';
                        document.getElementById('last-accident-date').textContent = 'Nenhuma data registrada.';
                    }
                })
                .catch(error => console.error('Erro ao carregar a data do último acidente:', error));
        }

        function updateLastAccidentDate() {
            const lastAccidentDate = document.getElementById('last-accident-input').value;

            fetch('config.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `last_accident_date=${encodeURIComponent(lastAccidentDate)}`
            })
            .then(response => response.json())
            .then(() => updateDaysCount())
            .catch(error => console.error('Erro ao enviar a data do último acidente:', error));
        }

        setInterval(updateDaysCount, 1000);
        window.onload = updateDaysCount;
    </script>
</head>
<body>
    <div class="container">
        <div id="days-panel">
            Dias sem acidentes de trabalho: <span id="days-count">0</span>
        </div>
        <div id="last-accident-panel">
            <p id="last-accident-date">Nenhuma data registrada.</p>
            <form id="last-accident-form" onsubmit="event.preventDefault(); updateLastAccidentDate();">
                <label for="last-accident-input">Data do último acidente:</label>
                <input type="date" id="last-accident-input">
                <button type="submit">Atualizar Data</button>
            </form>
        </div>
    </div>
</body>
</html>
