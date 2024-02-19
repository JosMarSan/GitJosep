<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$datbasename = "Info_C360";

$conn = mysqli_connect($servername, $username, $password, $datbasename);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['aproductos'])) {
    $id_producto = $_POST['aproductos'];

    // Obtener el precio y la cantidad del producto utilizando un JOIN
    $sql_select_producto = "SELECT p.precio, IFNULL(SUM(c.cantidad), 0) as cantidad FROM productos p LEFT JOIN carrito c ON p.id_producto = c.id_producto WHERE c.id_producto = ?";
    $stmt = mysqli_prepare($conn, $sql_select_producto);
    if (!$stmt) {
        die("Error preparando la consulta: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "i", $id_producto);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $producto = mysqli_fetch_assoc($result);
    $precio = $producto['precio'];
    $cantidad = $producto['cantidad'];

    // Comprobar si el producto ya existe en el carrito
    if ($cantidad > 0) {
        // Actualizar la cantidad y el precio del producto existente en el carrito
        $sql_update_carrito = "UPDATE carrito SET cantidad = cantidad + 1, precio = precio + ? WHERE id_producto = ?";
        $stmt = mysqli_prepare($conn, $sql_update_carrito);
        if (!$stmt) {
            die("Error preparando la consulta: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "di", $precio, $id_producto);
        mysqli_stmt_execute($stmt);
        if (mysqli_affected_rows($conn) == 0) {
            die("Error ejecutando la consulta: " . mysqli_stmt_error($stmt));
        }
    } else {
        // Insertar un nuevo producto en el carrito
        $sql_insert_carrito = "INSERT INTO carrito (id_producto, precio, cantidad) VALUES (?, ?, 1)";
        $stmt = mysqli_prepare($conn, $sql_insert_carrito);
        if (!$stmt) {
            die("Error preparando la consulta: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "ii", $id_producto, $precio);
        mysqli_stmt_execute($stmt);
        if (mysqli_affected_rows($conn) == 0) {
            die("Error ejecutando la consulta: " . mysqli_stmt_error($stmt));
        }
    }

    $_SESSION['message'] = "El producto se ha añadido al carrito correctamente.";
    header("Location: carrito.php");
    mysqli_close($conn);
    exit;
} else {
    // Redirigir al usuario al inicio
    header("Location: index.html");
    mysqli_close($conn); // Cerrar la conexión
    exit;
}
?>