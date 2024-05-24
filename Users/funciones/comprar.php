<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ./login.php");
    exit();
}

include ('./conecta.php');

$conn = conecta();

$nombreUsuario = $_SESSION['username'];

$usersql = "SELECT * FROM usuarios WHERE username = '$nombreUsuario'";

$userresult = $conn->query($usersql);

$user = $userresult->fetch_assoc();

$cart = $user['cart'];

$insertsql = "INSERT INTO pedidos (userid, productos, cerrado) VALUES (?, ?, ?)";

$stmt = $conn->prepare($insertsql);

$cerrado = 1;

$stmt->bind_param("ssi", $user['id'], $cart, $cerrado);

$stmt->execute();
$stmt->close();

$updatesql = "UPDATE usuarios SET cart = '' WHERE id = ?";
$stmt = $conn->prepare($updatesql);
$stmt->bind_param("i", $user['id']);
$stmt->execute();
$stmt->close();
header("Location: ../carrito.php");