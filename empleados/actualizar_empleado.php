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

if ($_FILES['foto']['name'] !== '') {
    $foto_nombre_real = $_FILES['foto']['name'];
    $foto_nombre_encriptado = md5(uniqid(rand(), true)) . '_' . $foto_nombre_real;
    $ruta_destino = '../../uploads/' . $foto_nombre_encriptado;

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $ruta_destino)) {
        $sql = "UPDATE db SET nombre='$nombre', apellidos='$apellidos', rol='$rol', foto_real='$foto_nombre_real', foto_encrypt='$foto_nombre_encriptado' WHERE id=$id";
        
        if ($conn->query($sql) === TRUE) {
            echo "Empleado actualizado exitosamente";
        } else {
            echo "Error al actualizar empleado: " . $conn->error;
        }
    } else {
        echo "Error al mover la foto.";
    }
} else {
    $sql = "UPDATE db SET nombre='$nombre', apellidos='$apellidos', rol='$rol' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Empleado actualizado exitosamente";
    } else {
        echo "Error al actualizar empleado: " . $conn->error;
    }
}

$conn->close();
?>
