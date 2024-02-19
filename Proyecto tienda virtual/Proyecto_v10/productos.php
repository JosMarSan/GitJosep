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
    <table border="1">
    <!-- Cabecera de la tabla -->
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Añadir al carrito</th>
        </tr>
    </thead>
    <!-- Cuerpo de la tabla -->
    <tbody>
    <?php
    // Conexión al servidor de la base de datos (ajusta las credenciales según tu configuración)
    $servername = "localhost";
    $username = "root";
    $password = "";

    // Crear una conexión
    $conn = mysqli_connect($servername, $username, $password);

    // Verificar la conexión
    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // Seleccionar la base de datos
    mysqli_select_db($conn, "Info_C360");

    // Consultar los datos de la tabla 'productos'
    $sql_select_productos = "SELECT * FROM productos";
    $result_productos = mysqli_query($conn, $sql_select_productos);

    if (mysqli_num_rows($result_productos) > 0) {
        // Mostrar los datos de cada producto
        while ($row = mysqli_fetch_assoc($result_productos)){
            echo "
            <tr>
                <td>{$row["id_producto"]}</td>
                <td>{$row["nombre"]}</td>
                <td>{$row["descripcion"]}</td>
                <td>{$row["precio"]}€</td>
                <td><form method='post' action='aproductos.php'><button type='submit' name='aproductos' value='{$row["id_producto"]}'>Añadir al carrito</button></form></td>
            </tr>
            ";
        }
    } else {
        echo "<tr><td colspan='6'>No se encontraron productos</td></tr>";
    }

    // Cerrar la conexión
    mysqli_close($conn);
    ?>
    </tbody>
</table>
</main>
</body>
</html>