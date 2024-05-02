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
$password = $_POST['password'];

$sql = "SELECT * FROM db WHERE correo = '$correo' AND activo = 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    if (password_verify($password, $row['contraseña'])) {
        echo "existe";
    } else {
        echo "no_existea";
    }
} else {
    echo "no_existe";
}

$conn->close();
?>
