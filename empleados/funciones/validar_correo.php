<?php
include ('conecta.php');
$conn = conecta();

$correo = $_POST['correo'];

$sql = "SELECT correo FROM empleados WHERE correo = '$correo'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "El correo " . $correo . " ya existe.";
} else {
    echo "";
}

$conn->close();
