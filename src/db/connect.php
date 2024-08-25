<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mercado";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$q = $_GET['q'];
$sql = "SELECT nome_produto FROM produtos WHERE nome_produto LIKE '%$q%' LIMIT 10";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p onclick='selectProduct(\"" . $row['nome_produto'] . "\")'>" . $row['nome_produto'] . "</p>";
    }
} else {
    echo "<p>Sem resultados</p>";
}

$conn->close();
