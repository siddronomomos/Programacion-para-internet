<?php
include ('conecta.php');

$conn = conecta();

if (!$conn) {
    exit("Error al conectar a la base de datos");
}

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$rol = $_POST['rol'];
$activo = $_POST['activo'] ? 1 : 0;

if ($_FILES['foto']['name'] !== '') {
    $foto_nombre_real = $_FILES['foto']['name'];
    $foto_nombre_encriptado = md5(uniqid(rand(), true)) . '_' . $foto_nombre_real;
    $ruta_destino = '../images/' . $foto_nombre_encriptado;

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $ruta_destino)) {
        $old_foto_sql = "SELECT foto_encrypt FROM empleados WHERE id = $id";
        $result = $conn->query($old_foto_sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $old_foto = $row['foto_encrypt'];
            if ($old_foto !== '') {
                unlink('../images/' . $old_foto);
            }
        }

        $sql = "UPDATE empleados SET nombre='$nombre', apellidos='$apellidos', rol='$rol', foto_real='$foto_nombre_real', foto_encrypt='$foto_nombre_encriptado', activo=$activo WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "Empleado actualizado exitosamente";
        } else {
            echo "Error al actualizar empleado: " . $conn->error;
        }
    } else {
        echo "Error al mover la foto.";
    }
} else {
    $sql = "UPDATE empleados SET nombre='$nombre', apellidos='$apellidos', rol='$rol', activo=$activo WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Empleado actualizado exitosamente";
    } else {
        echo "Error al actualizar empleado: " . $conn->error;
    }
}

$conn->close();
