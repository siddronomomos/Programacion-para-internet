<?php
include ('conecta.php');
$conn = conecta();

if (!$conn) {
    exit("Error al conectar a la base de datos");
}

$nombre = $_POST['nombre'];
$target_dir = "../images/";
$target_file = $target_dir . basename($_FILES["archivo"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

$encrypted_name = md5(uniqid(rand(), true)) . "." . $imageFileType;
$encrypted_target_file = $target_dir . $encrypted_name;


if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $encrypted_target_file)) {
    $sql = "INSERT INTO promociones (nombre, archivo)
            VALUES ('$nombre', '$encrypted_name')";
    if ($conn->query($sql) === TRUE) {
        echo "exito";
    } else {
        echo "Error al agregar promocion: " . $conn->error;
    }
} else {
    echo "Lo siento, hubo un error al subir tu archivo.";
}

$conn->close();