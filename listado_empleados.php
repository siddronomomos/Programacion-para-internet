<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Listado de empleados</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }

    h2 {
        margin-bottom: 20px;
    }

    .empleado {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 10px;
        background-color: #fff;
    }

    .empleado div {
        margin-bottom: 5px;
    }

    .acciones a {
        text-decoration: none;
        color: #007bff;
        margin-right: 10px;
    }

    .acciones a:hover {
        text-decoration: underline;
    }

    .acciones a.eliminar {
        color: #dc3545;
    }

    .acciones a.eliminar:hover {
        color: #c82333;
    }

    .acciones a.detalle {
        color: #28a745;
    }

    .acciones a.detalle:hover {
        color: #218838;
    }

    p a {
        text-decoration: none;
        color: #007bff;
    }

    p a:hover {
        text-decoration: underline;
    }

</style>
</head>
<body>
<h2>Listado de empleados</h2>
<div id="listadoEmpleados">
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "proyecto final";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SELECT id, nombre, apellidos, correo, rol, activo FROM db";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='empleado'>";
                echo "<div>ID: ".$row["id"]."</div>";
                echo "<div>Nombre: ".$row["nombre"]."</div>";
                echo "<div>Apellidos: ".$row["apellidos"]."</div>";
                echo "<div>Correo: ".$row["correo"]."</div>";
                echo "<div>Rol: ".$row["rol"]."</div>";
                echo "<div>Activo: ".($row["activo"] == 1 ? "Sí" : "No")."</div>";
                echo "<div class='acciones'><a href='editar_empleado.php?id=".$row["id"]."'>Editar</a> | <a href='eliminar_empleado.php?id=".$row["id"]."' class='eliminar'>Eliminar</a> | <a href='ver_detalle.php?id=".$row["id"]."' class='detalle'>Ver detalle</a></div>";
                echo "</div>";
            }
        } else {
            echo "<p>No hay empleados registrados.</p>";
        }
    } else {
        echo "<p>Error al recuperar datos: " . $conn->error . "</p>";
    }

    $conn->close();
    ?>
</div>
<p><a href="formulario_empleados.php">Agregar nuevo empleado</a></p>
</body>
</html>