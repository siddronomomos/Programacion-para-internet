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

$sql = "SELECT * FROM db WHERE correo = ? AND activo = 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    if (password_verify($password, $row['contraseña'])) {
        session_start();
        $_SESSION['usuario'] = $row['nombre'];
        echo "existe";
    } else {
        echo "contrasena_incorrecta";
    }
} else {
    echo "usuario_no_existe";
}

$stmt->close();
$conn->close();
?>
