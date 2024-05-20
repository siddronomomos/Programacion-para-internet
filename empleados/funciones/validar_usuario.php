<?php
include ('conecta.php');

$conn = conecta();
if (!$conn) {
    exit('Error al conectar a la base de datos');
}

$codigo = $_POST['correo'];
$password = $_POST['password'];

$sql = "SELECT * FROM empleados WHERE correo = ? AND activo = 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $codigo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if (password_verify($password, $row['pass'])) {
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
