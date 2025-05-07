<?php
require 'config/config.php';
require 'config/database.php';

$db = new Database();
$con = $db->conectar();

// Agregar producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $img = $_POST['img'];
    $categoria = $_POST['categoria'];
    

    $stmt = $con->prepare("INSERT INTO producto (nombre, precio,descripcion, img, categoria) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nombre, $precio,$descripcion,$img, $categoria]);
     // Redirecciona para evitar reenvío al actualizar
    header("Location: admin.php");
    exit;
}

// Eliminar producto
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $stmt = $con->prepare("DELETE FROM producto WHERE idProducto = ?");
    $stmt->execute([$id]);
}

// Obtener todos los productos
$stmt = $con->prepare("SELECT * FROM producto");
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
  
<head>
  <meta charset="UTF-8">
  <title>Panel de Administración</title>
  <link rel="stylesheet" href="CSS/estilos.css">
    <link rel="stylesheet" href="CSS/userEstilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  
</head>
<body>
<?php include 'header.php'?>
  <h1>Panel de Administración</h1>

  <h2>Agregar producto</h2>
  <form method="post">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="number" step="0.01" name="precio" placeholder="Precio" required>
    <input type="text" name="descripcion" placeholder="descripcion" required>
    <input type="text" name="img" placeholder="Ruta de imagen (ej. img/foto.jpg)" required>
    <select name="categoria" required>
    <option value="" disabled selected>Selecciona una categoría</option>
    <option value="CLOTHES">CLOTHES</option>
    <option value="PHOTOCARDS">PHOTOCARDS</option>
    <option value="ALBUMS">ALBUMS</option>
</select>

    <button type="submit" name="agregar">Agregar</button>
  </form>

  <h2>Productos actuales</h2>
  <table border="1" cellpadding="5">
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      <th>Precio</th>
      <th>Descripcion</th>
      <th>Imagen</th>
      <th>Categoría</th>
      <th>Acción</th>
    </tr>
    <?php foreach ($productos as $prod): ?>
      <tr>
        <td><?= $prod['idProducto'] ?></td>
        <td><?= $prod['nombre'] ?></td>
        <td>$<?= number_format($prod['precio'], 2) ?></td>
        <td><?= $prod['descripcion'] ?></td>
        <td><img src="<?= $prod['img'] ?>" width="50"></td>
        <td><?= $prod['categoria'] ?></td>
        <td><a href="admin.php?eliminar=<?= $prod['idProducto'] ?>" onclick="return confirm('¿Eliminar este producto?')">Eliminar</a></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>