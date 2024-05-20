<?php
include ('conecta.php');
$conn = conecta();

if (!$conn) {
    exit("Error al conectar a la base de datos");
}

$nombre = $_POST['nombre'];
$codigo = $_POST['codigo'];
$descripcion = $_POST['descripcion'];
$costo = $_POST['costo'];
$stock = $_POST['stock'];
$target_dir = "../images/";
$target_file = $target_dir . basename($_FILES["archivo"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

$encrypted_name = md5(uniqid(rand(), true)) . "." . $imageFileType;
$encrypted_target_file = $target_dir . $encrypted_name;

$real_file_name = $_FILES["archivo"]["name"];

if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $encrypted_target_file)) {
    $sql = "INSERT INTO productos (nombre, codigo, descripcion, costo, stock, archivo_n, archivo)
            VALUES ('$nombre', '$codigo', '$descripcion', '$costo', '$stock', '$encrypted_name', '$real_file_name')";
    if ($conn->query($sql) === TRUE) {
        echo "Producto agregado correctamente";
    } else {
        echo "Error al agregar producto: " . $conn->error;
    }
} else {
    echo "Lo siento, hubo un error al subir tu archivo.";
}

$conn->close();