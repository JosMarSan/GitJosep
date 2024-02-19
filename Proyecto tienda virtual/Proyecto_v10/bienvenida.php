<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <a href="#" class="logo">C360</a>
        <nav class="nav">
            <ul class="menu">
                <li><a href="bienvenida.php">Inicio</a></li>
                <li><a href="productos.php">Cátalogo de productos</a></li>
                <li><a href="carrito.php">Carrito</a></li>
                <li><a href="cerrar_sesion.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <article id="principal">
            <h1>Bienvenido a C360</h1>
            <br>
            <p>Gracias por iniciar sesión.</p>
            <br>
        </article>
    </main>
</body>
</html>