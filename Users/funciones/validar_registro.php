<?php
include ('conecta.php');

$conn = conecta();
if (!$conn) {
    exit('Error al conectar a la base de datos');
}

$usuario = $_POST['usuario'];
$email = $_POST['email'];
$password = $_POST['password'];
$sql = "SELECT * FROM usuarios WHERE username = ? OR email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usuario, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "existe";
} else {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $usuario, $email, $password);
    $stmt->execute();
    echo "registrado";
}

$stmt->close();
$conn->close();
