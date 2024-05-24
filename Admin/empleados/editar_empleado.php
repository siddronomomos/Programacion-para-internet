<?php
include ('./funciones/conecta.php');
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

$conn = conecta();

$id = $_GET['id'];

$sql = "SELECT * FROM empleados WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre = $row['nombre'];
    $apellidos = $row['apellidos'];
    $correo = $row['correo'];
    $rol = $row['rol'];
    $foto = $row['foto_encrypt'];
    $activo = $row['activo'];
} else {
    echo "No se encontró el empleado.";
    exit();
}

$conn->close();


$nombreUsuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edición de empleados</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            function validarCampos() {
                var nombre = $("#nombre").val();
                var apellidos = $("#apellidos").val();
                var correo = $("#correo").val();

                if (nombre === "" || apellidos === "" || correo === "") {
                    $("#mensaje").text("Faltan campos por llenar.");
                    return false;
                }
                return true;
            }

            $("#editarEmpleadoForm").submit(function (event) {
                event.preventDefault();
                if (!validarCampos()) {
                    setTimeout(function () {
                        $("#mensaje").text("");
                    }, 5000);
                    return;
                }

                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "./funciones/actualizar_empleado.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        window.location.href = "listado_empleados.php";
                    }
                });
            });

            $("#correo").blur(function () {
                var correo = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "./funciones/validar_correo.php",
                    data: { correo: correo },
                    success: function (response) {
                        $("#errorContainer").text(response);
                        setTimeout(function () {
                            $("#errorContainer").text("");
                        }, 5000);
                    }
                });
            });
        });
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        h2 {
            margin-bottom: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        #errorContainer {
            color: red;
            margin-top: 10px;
        }

        p {
            text-align: center;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
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
    <h2>Edición de empleados</h2>
    <div class="menu">
        <a href="../bienvenido.php">INICIO</a>
        <a href="../empleados/listado_empleados.php">EMPLEADOS</a>
        <a href="../productos/listado_productos.php">PRODUCTOS</a>
        <a href="../promociones/listado_promociones.php">PROMOCIONES</a>
        <a href="../pedidos/listado_pedidos.php">PEDIDOS</a>
        <a href="#">BIENVENIDO <?php echo $nombreUsuario; ?></a>
        <a href="./funciones/cerrar_sesion.php">CERRAR SESIÓN</a>
    </div>
    <form id="editarEmpleadoForm" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" />

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" value="<?php echo $apellidos; ?>" />

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" value="<?php echo $correo; ?>" disabled />

        <label for="rol">Rol:</label>
        <select id="rol" name="rol">
            <option value="Gerente" <?php if ($rol === "Gerente")
                echo "selected"; ?>>Gerente</option>
            <option value="Ejecutivo" <?php if ($rol === "Ejecutivo")
                echo "selected"; ?>>Ejecutivo</option>
        </select>
        <label for="activo">Activo:</label>
        <input type="checkbox" id="activo" name="activo" <?php if ($activo == 1)
            echo "checked"; ?> />
        <div class="foto-empleado">
            <img src="./images/<?php echo $foto; ?>" alt="Foto de perfil" style='max-width:150px;width:100%' />
        </div>
        <label for="foto">Foto:</label>
        <input type="file" id="foto" name="foto" accept="image/*" />

        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input type="submit" value="Guardar" />
    </form>
    <div id="mensaje"></div>
    <div id="errorContainer"></div>
    <p><a href="listado_empleados.php">Regresar</a></p>
</body>

</html>