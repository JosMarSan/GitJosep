<?php
// Conexión al servidor de la base de datos
$servername = "localhost";
$username = "root";
$password = "";

// Crear la conexión
$conn = mysqli_connect($servername, $username, $password);

// Verificar la conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Crear la base de datos si no existe
$databaseName = "Info_C360";
$sql_create_database = "CREATE DATABASE IF NOT EXISTS $databaseName";
if (mysqli_query($conn, $sql_create_database)) {
    echo "Base de datos creada o ya existente\n";
} else {
    echo "Error al crear la base de datos: " . mysqli_error($conn);
}

// Seleccionar la base de datos
mysqli_select_db($conn, $databaseName);

// Crear las tablas
createTable($conn, "usuarios", "(
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255),
    apellido VARCHAR(255),
    correo VARCHAR(255),
    contrasena VARCHAR(255)
)");

createTable($conn, "productos", "(
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255),
    descripcion TEXT,
    precio DECIMAL(10,2)
)");

createTable($conn, "carrito", "(
    id_carrito INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT,
    cantidad INT,
    precio DECIMAL(10,2),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
)");

createTable($conn, "pagos_productos", "(
    id_pago INT AUTO_INCREMENT PRIMARY KEY,
    numero_tarjeta INT (16),
    cvv INT (3)
)");

// Verificar si el producto 1 ya existe
$productoExistente1 = "SELECT * FROM productos WHERE nombre = 'Balón de Fútbol Nike Premier Team'";
$resultadoProducto1 = mysqli_query($conn, $productoExistente1);

if (mysqli_num_rows($resultadoProducto1) == 0) {
    // Insertar el producto 1 si no existe
    $producto1 = "INSERT INTO productos (nombre, descripcion, precio) VALUES ('Balón de Fútbol Nike Premier Team', 'El balón de fútbol Nike Premier Team es conocido por su durabilidad y rendimiento excepcionales. Fabricado con materiales de alta calidad, ofrece un toque suave y preciso', 28.89)";
    mysqli_query($conn, $producto1);
}

// Verificar si el producto 2 ya existe
$productoExistente2 = "SELECT * FROM productos WHERE nombre = 'Guantes SP Seredipity Starter Dark'";
$resultadoProducto2 = mysqli_query($conn, $productoExistente2);

if (mysqli_num_rows($resultadoProducto2) == 0) {
    // Insertar el producto 2 si no existe
    $producto2 = "INSERT INTO productos (nombre, descripcion, precio) VALUES ('Guantes SP Seredipity Starter Dark', 'Presenta un diseño limpio, monocolor y con una construcción muy clásica para los porteros que buscan equilibrio en el tipo de guante y huyen de los extremos de armado y ligereza de los guantes de tendencia', 20.14)";
    mysqli_query($conn, $producto2);
}

function createTable($conn, $tableName, $tableDefinition) {
    $sql_create_table = "CREATE TABLE IF NOT EXISTS $tableName $tableDefinition";
    if (mysqli_query($conn, $sql_create_table)) {
        echo "Tabla '$tableName' creada o ya existente\n";
    } else {
        echo "Error al crear la tabla '$tableName': " . mysqli_error($conn);
    }
}
mysqli_close($conn);
?>