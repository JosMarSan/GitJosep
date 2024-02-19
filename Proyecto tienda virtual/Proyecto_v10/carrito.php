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
        <h1>Carrito</h1>
        <table border=1>
            <thead>
                <tr>
                    <th>ID de producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Conectarse a la base de datos (ajusta los parámetros según tus necesidades)
            $servername = "localhost";
            $username = "root";
            $password = "";
            $datbasename = "Info_C360";
            $charset = 'utf8mb4';

            // Crear conexión
            $conn = mysqli_init();
            mysqli_real_connect($conn, $servername, $username, $password, $datbasename);
            mysqli_set_charset($conn, $charset);

            // Inicializar la variable $precio_total
            $precio_total = 0;

            // Obtener los datos del carrito asociados al usuario actual
            $query = "SELECT c.id_producto, c.cantidad, p.precio FROM carrito c JOIN productos p ON c.id_producto = p.id_producto";
            $result = mysqli_query($conn, $query);
            $carrito = mysqli_fetch_all($result, MYSQLI_ASSOC);

            // Cerrar la conexión a la base de datos
            mysqli_close($conn);

            // Mostrar los productos del carrito
            if (count($carrito) > 0) {
                // Actualizar el valor de $precio_total
                foreach ($carrito as $item) {
                    $precio_total += $item['cantidad'] * $item['precio'];
                }

                // Mostrar los productos del carrito y el precio total
                foreach ($carrito as $item) {
                    echo "<tr>" .
                         "<td>" . htmlspecialchars($item['id_producto']) . "</td>" .
                         "<td>" . htmlspecialchars($item['cantidad']) . "</td>" .
                         "<td>" . htmlspecialchars($item['precio']) . " €</td>" .
                         "</tr>" .
                         "\n";
                }
                echo "<tr>" .
                     "<td colspan='2'>Precio total:</td>" .
                     "<td>" . htmlspecialchars($precio_total) . " €</td>" .
                     "</tr>" .
                     "\n";
            } else {
                echo "<tr>" .
                     "<td colspan='3'>El carrito está vacío</td>" .
                     "</tr>" .
                     "\n";
            }
            ?>
            </tbody>
        </table>
        <br>
        <?php if (count($carrito) > 0): ?>
            <a href="form_pago.html">
                <input type="submit" value="Pagar">
            </a>
            <a href="productos.php">
                <input type="submit" value="Seguir comprando">
            </a>
            <a href="vaciar_carrito.php">
                <input type="submit" value="Vaciar carrito">
            </a>
        <?php else: ?>
            <p style="color: red;">No puedes ningún pago porque el carrito está vacío.</p>
        <?php endif; ?>

    </main>
</body>
</html>