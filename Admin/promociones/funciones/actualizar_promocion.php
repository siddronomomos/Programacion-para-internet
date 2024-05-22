<?php
include ('conecta.php');

$conn = conecta();

if (!$conn) {
    exit("Error al conectar a la base de datos");
}

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$status = $_POST['status'] ? 1 : 0;



if ($_FILES['archivo']['name'] !== '') {
    $archivo_nombre_real = $_FILES['archivo']['name'];
    $archivo_nombre_encriptado = md5(uniqid(rand(), true)) . '_' . $archivo_nombre_real;
    $ruta_destino = '../images/' . $archivo_nombre_encriptado;

    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_destino)) {
        $old_archivo_sql = "SELECT archivo FROM promociones WHERE id = $id";
        $result = $conn->query($old_archivo_sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $old_archivo = $row['archivo'];
            if ($old_archivo !== '') {
                unlink('../images/' . $old_archivo);
            }
        }

        $sql = "UPDATE promociones SET nombre='$nombre', status='$status', archivo='$archivo_nombre_encriptado' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "Promocion actualizada exitosamente";
        } else {
            echo "Error al actualizar promocion: " . $conn->error;
        }
    } else {
        echo "Error al mover la foto.";
    }
} else {
    $sql = "UPDATE promociones SET nombre='$nombre', status='$status' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Promocion actualizada exitosamente";
    } else {
        echo "Error al actualizar promocion: " . $conn->error;
    }
}

$conn->close();
