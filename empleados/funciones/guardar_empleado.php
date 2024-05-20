<?php
include ('conecta.php');
$conn = conecta();

if (!$conn) {
    exit("Error al conectar a la base de datos");
}

$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$codigo = $_POST['correo'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$rol = $_POST['rol'];

$target_dir = "../images/";
$target_file = $target_dir . basename($_FILES["foto"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

$encrypted_name = md5(uniqid(rand(), true)) . "." . $imageFileType;

$real_file_name = $_FILES["foto"]["name"];

$encrypted_target_file = $target_dir . $encrypted_name;
if (move_uploaded_file($_FILES["foto"]["tmp_name"], $encrypted_target_file)) {
    $sql = "INSERT INTO empleados (nombre, apellidos, correo, pass, rol, foto_real, foto_encrypt) 
            VALUES ('$nombre', '$apellidos', '$codigo', '$password', '$rol', '$real_file_name', '$encrypted_name')";
    if ($conn->query($sql) === TRUE) {
        echo "Empleado agregado correctamente";
    } else {
        echo "Error al agregar empleado: " . $conn->error;
    }
} else {
    echo "Lo siento, hubo un error al subir tu archivo.";
}

$conn->close();