<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "proyecto final";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$correo = $_POST['correo'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$rol = $_POST['rol'];

$target_dir = "../uploads/";
$target_file = $target_dir . basename($_FILES["foto"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

$encrypted_name = md5(uniqid(rand(), true)) . "." . $imageFileType;

$real_file_name = $_FILES["foto"]["name"];

$encrypted_target_file = $target_dir . $encrypted_name;
if (move_uploaded_file($_FILES["foto"]["tmp_name"], $encrypted_target_file)) {
    $sql = "INSERT INTO db (nombre, apellidos, correo, contraseña, rol, foto_real, foto_encrypt) 
            VALUES ('$nombre', '$apellidos', '$correo', '$password', '$rol', '$real_file_name', '$encrypted_name')";
    if ($conn->query($sql) === TRUE) {
        echo "Empleado agregado correctamente";
    } else {
        echo "Error al agregar empleado: " . $conn->error;
    }
} else {
    echo "Lo siento, hubo un error al subir tu archivo.";
}

$conn->close();
?>
