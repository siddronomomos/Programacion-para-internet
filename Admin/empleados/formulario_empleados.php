<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

$nombreUsuario = $_SESSION['usuario'];

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de empleados</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#altaEmpleadoForm").submit(function (event) {
                event.preventDefault();
                var nombre = $("#nombre").val();
                var apellidos = $("#apellidos").val();
                var correo = $("#correo").val();
                var password = $("#password").val();
                var rol = $("#rol").val();
                var foto = $("#foto").val();

                if (nombre === "" || apellidos === "" || correo === "" || password === "" || rol === "" || foto === "") {
                    $("#errorContainer").text("Faltan campos por llenar.");
                    setTimeout(function () {
                        $("#errorContainer").text("");
                    }, 5000);
                } else {
                    var formData = new FormData(this);
                    var correo = $("#correo").val();

                    $.ajax({
                        type: "POST",
                        url: "./funciones/validar_correo.php",
                        data: { correo: correo },
                        success: function (response) {
                            if (response.trim() === "El correo " + correo + " ya existe.") {
                                $("#errorContainer").text("El correo ya está registrado.");
                                setTimeout(function () {
                                    $("#errorContainer").text("");
                                }, 5000);
                            } else {
                                guardarEmpleado(formData);
                            }
                        },
                    });
                }

                function guardarEmpleado(formData) {
                    $.ajax({
                        type: "POST",
                        url: "./funciones/guardar_empleado.php",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response.trim() === "exito") {
                                alert("Empleado guardado con éxito.");
                                window.location.href = "./listado_empleados.php";
                            } else {
                                $("#errorContainer").text("Error al guardar el empleado.");
                                setTimeout(function () {
                                    $("#errorContainer").text("");
                                }, 5000);
                            }
                        },
                    });
                }

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
                    },
                });
            });
        });
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="file"] {
            margin-top: 10px;
        }

        input[type="submit"] {
            width: auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        #errorContainer {
            margin-top: 10px;
            color: red;
        }

        p a {
            color: #007bff;
            text-decoration: none;
        }

        p a:hover {
            text-decoration: underline;
        }

        .custom-file-upload {
            border: 1px solid #ccc;
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        .custom-file-upload:hover {
            background-color: #0056b3;
        }

        .custom-file-upload i {
            margin-right: 5px;
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
    <h2>Alta de empleados</h2>
    <div class="menu">
        <a href="../bienvenido.php">INICIO</a>
        <a href="../empleados/listado_empleados.php">EMPLEADOS</a>
        <a href="../productos/listado_productos.php">PRODUCTOS</a>
        <a href="../promociones/listado_promociones.php">PROMOCIONES</a>
        <a href="../pedidos/listado_pedidos.php">PEDIDOS</a>
        <a href="#">BIENVENIDO <?php echo $nombreUsuario; ?></a>
        <a href="./funciones/cerrar_sesion.php">CERRAR SESIÓN</a>
    </div>
    <form id="altaEmpleadoForm" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" /><br /><br />

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" /><br /><br />

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" /><br /><br />

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" /><br /><br />

        <label for="rol">Rol:</label>
        <select id="rol" name="rol">
            <option value="">Seleccione un rol</option>
            <option value="Gerente">Gerente</option>
            <option value="Ejecutivo">Ejecutivo</option>
        </select><br /><br />

        <label for="foto" class="custom-file-upload">
            <i class="fas fa-cloud-upload-alt"></i> Seleccionar Foto
        </label>
        <input type="file" id="foto" name="foto" accept="image/*" required style="display: none;" /> <br>

        <input type="submit" value="Guardar" />
    </form>
    <div id="errorContainer"></div>
    <p><a href="listado_empleados.php">Regresar al listado</a></p>
</body>

</html>