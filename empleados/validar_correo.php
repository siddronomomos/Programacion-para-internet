<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "proyecto final";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$correo = $_POST['correo'];

$sql = "SELECT correo FROM db WHERE correo = '$correo'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "El correo " . $correo . " ya existe.";
} else {
    echo "";
}

$conn->close();
?>
