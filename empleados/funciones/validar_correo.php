<?php
include ('conecta.php');
$conn = conecta();

$codigo = $_POST['correo'];

$sql = "SELECT correo FROM empleados WHERE correo = '$codigo'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "El correo " . $codigo . " ya existe.";
} else {
    echo "";
}

$conn->close();
