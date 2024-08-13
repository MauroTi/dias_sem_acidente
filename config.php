<?php
// Define o arquivo onde a data do último acidente será armazenada
$dataFile = 'last_accident_date.txt';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém a data do último acidente do formulário
    $lastAccidentDate = $_POST['last_accident_date'];
    
    // Valida a data
    if (DateTime::createFromFormat('Y-m-d', $lastAccidentDate) !== false) {
        // Armazena a data no arquivo
        file_put_contents($dataFile, $lastAccidentDate);
    }
}

// Obtém a data do último acidente
if (file_exists($dataFile)) {
    $lastAccidentDate = file_get_contents($dataFile);
} else {
    $lastAccidentDate = '';
}

// Retorna a data do último acidente como JSON
header('Content-Type: application/json');
echo json_encode(['lastAccidentDate' => $lastAccidentDate]);
?>
