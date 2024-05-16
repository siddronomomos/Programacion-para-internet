<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$nombreUsuario = $_SESSION['usuario'];

?>

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

    .foto-empleado {
        text-align: center;
        max-width: 200px;
        max-height: 200px;
        overflow: auto;
    }
    .menu {
            text-align: center;
            margin-bottom: 20px;
        }

        .menu a {
            margin-right: 10px;
            text-decoration: none;
            color: #007bff;
        }

        .menu a:hover {
            text-decoration: underline;
        }

</style>
</head>
<body>
<h2>Listado de empleados</h2>
<div class="menu">
        <a href="bienvenido.php">INICIO</a>
        <a href="listado_empleados.php">EMPLEADOS</a>
        <a href="#">PRODUCTOS</a>
        <a href="#">PROMOCIONES</a>
        <a href="#">PEDIDOS</a>
        <a href="#">BIENVENIDO <?php echo $nombreUsuario; ?></a>
        <a href="cerrar_sesion.php">CERRAR SESIÓN</a>
    </div>
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

    $sql = "SELECT id, nombre, apellidos, correo, rol, activo, foto_encrypt as foto_real FROM db";
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
                echo "<div class='foto-empleado'><img src='../uploads/".$row["foto_real"]."' alt='Foto de ".$row["nombre"]." ".$row["apellidos"]."'style='max-width:150px;width:100%'></div>";
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
