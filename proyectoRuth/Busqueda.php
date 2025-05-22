<?php
// Conexión a la base de datos
$host = "localhost";
$username = "root";
$password = "";
$dbname = "m3racha";

$conn = new mysqli("$host", "$username", "$password", "$dbname");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para realizar la búsqueda
function performSearch($query, $conn, $searchType)
{
    $safeQuery = $conn->real_escape_string($query);
    $sql = "";

    switch ($searchType) {
        case 'producto':
            $sql = "SELECT idProducto, nombre, precio, descripcion, img FROM producto WHERE nombre LIKE '%$safeQuery%' OR descripcion LIKE '%$safeQuery%'";
            break;
        case 'usuario':
            $sql = "SELECT idUsuario, username, correo FROM usuario WHERE username LIKE '%$safeQuery%' OR correo LIKE '%$safeQuery%'";
            break;
        // Agrega más casos para otras tablas si es necesario
    }

    $result = $conn->query($sql);
    $results = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
    }
    return $results;
}

// Lógica para obtener los resultados de la búsqueda
$searchType = 'producto'; // Establecer el tipo de búsqueda aquí. Cambiar según sea necesario.
if (isset($_GET['q'])) {
    $query = $_GET['q'];
    $results = performSearch($query, $conn, $searchType);
}

// Cierre de la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Resultados de búsqueda</title>
    <link rel="stylesheet" href="EstilosBusqueda.css">

    <!-- Agrega aquí tus etiquetas de estilo y otros elementos del encabezado -->
</head>

<body>
    <header class="header">
        <!-- Barra de navegación y otros elementos de la página -->
    </header>

    <div class="main-content">
        <!-- Mostrar los resultados de la búsqueda aquí -->
        <?php if (isset($results) && !empty($results)): ?>
            <h2>Resultados de búsqueda para "

                <?php echo htmlspecialchars($query); ?>"
            </h2>
            <ul class="resultados">
                <?php foreach ($results as $result): ?>
                    <?php echo "<a href='productPage/producto{$result['idProducto']}.php' class='producto-link'> ";?>
                    <li>
                        <img src="<?php echo htmlspecialchars($result['img']); ?>" alt="Imagen del producto">
                        <div class="descripcion">
                            <div class="titulo">
                                <?php echo htmlspecialchars($result['nombre']) . ": " . htmlspecialchars($result['descripcion']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No se encontraron resultados para "
                <?php echo htmlspecialchars($query); ?>"
            </p>
        <?php endif; ?>

    </div>

    <!-- Otros elementos de la página y pie de página -->

</body>

</html>