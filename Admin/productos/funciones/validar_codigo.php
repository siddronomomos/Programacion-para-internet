<?php
include ('conecta.php');
$conn = conecta();

$codigo = $_POST['codigo'];

$sql = "SELECT codigo FROM productos WHERE codigo = '$codigo'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "El codigo " . $codigo . " ya existe.";
} else {
    echo "";
}

$conn->close();
