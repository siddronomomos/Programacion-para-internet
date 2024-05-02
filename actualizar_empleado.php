<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "proyecto final";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$rol = $_POST['rol'];

$sql = "UPDATE db SET nombre='$nombre', apellidos='$apellidos', rol='$rol' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Empleado actualizado exitosamente";
} else {
    echo "Error al actualizar empleado: " . $conn->error;
}

$conn->close();
?>
