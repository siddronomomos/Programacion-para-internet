<?php
include ('conecta.php');

$conn = conecta();
if (!$conn) {
    exit('Error al conectar a la base de datos');
}

$usuario = $_POST['usuario'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if (password_verify($password, $row['password'])) {
        session_start();
        $_SESSION['username'] = $row['username'];
        echo "existe";
    } else {
        echo "contrasena_incorrecta";
    }
} else {
    echo "usuario_no_existe";
}

$stmt->close();
$conn->close();
