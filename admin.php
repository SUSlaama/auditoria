<?php
require 'config/config.php';
require 'config/database.php';

$db = new Database();
$con = $db->conectar();

// Agregar o actualizar producto

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = $_POST['nombre'];
  $precio = $_POST['precio'];
  $descripcion = $_POST['descripcion'];
  $img = $_POST['img'];
  $categoria = $_POST['categoria'];

  if (isset($_POST['idProducto']) && $_POST['idProducto'] != '') {
    // Editar producto existente
    $id = $_POST['idProducto'];
    $stmt = $con->prepare("UPDATE producto SET nombre=?, precio=?, descripcion=?, img=?, categoria=? WHERE idProducto=?");
    $stmt->execute([$nombre, $precio, $descripcion, $img, $categoria, $id]);
  } else {
    // Agregar nuevo producto
    $stmt = $con->prepare("INSERT INTO producto (nombre, precio, descripcion, img, categoria) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nombre, $precio, $descripcion, $img, $categoria]);
  }

  header("Location: admin.php");
  exit;
}

// Eliminar producto
if (isset($_GET['eliminar'])) {
  $id = $_GET['eliminar'];
  $stmt = $con->prepare("DELETE FROM producto WHERE idProducto = ?");
  $stmt->execute([$id]);
  header("Location: admin.php");
  exit;
}

// Obtener producto para editar (si aplica)
$productoEditar = null;
if (isset($_GET['editar'])) {
  $idEditar = $_GET['editar'];
  $stmt = $con->prepare("SELECT * FROM producto WHERE idProducto = ?");
  $stmt->execute([$idEditar]);
  $productoEditar = $stmt->fetch(PDO::FETCH_ASSOC);
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
  <link rel="stylesheet" href="CSS/admincss.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>


<body>
  <?php include 'header.php' ?>

  <h1 style="text-align: center;">Panel de Administración</h1>
  <div class="admin-panel">
    <h2><?= $productoEditar ? 'Editar producto' : 'Agregar producto' ?></h2>

    <form method="post" class="product-form">
      <?php if ($productoEditar): ?>
        <input type="hidden" name="idProducto" value="<?= $productoEditar['idProducto'] ?>">
      <?php endif; ?>

      <input type="text" name="nombre" placeholder="Nombre del producto" value="<?= $productoEditar['nombre'] ?? '' ?>" required>
      <input type="number" step="0.01" name="precio" placeholder="Precio" value="<?= $productoEditar['precio'] ?? '' ?>" required>
      <input type="text" name="descripcion" placeholder="Descripción" value="<?= $productoEditar['descripcion'] ?? '' ?>" required>
      <input type="text" name="img" placeholder="Ruta de imagen (ej. img/foto.jpg)" value="<?= $productoEditar['img'] ?? '' ?>" required>

      <select name="categoria" required>
        <option value="" disabled <?= !isset($productoEditar['categoria']) ? 'selected' : '' ?>>Selecciona una categoría</option>
        <option value="CLOTHES" <?= ($productoEditar['categoria'] ?? '') === 'CLOTHES' ? 'selected' : '' ?>>CLOTHES</option>
        <option value="PHOTOCARDS" <?= ($productoEditar['categoria'] ?? '') === 'PHOTOCARDS' ? 'selected' : '' ?>>PHOTOCARDS</option>
        <option value="ALBUMS" <?= ($productoEditar['categoria'] ?? '') === 'ALBUMS' ? 'selected' : '' ?>>ALBUMS</option>
      </select>

      <button type="submit"><?= $productoEditar ? 'Guardar cambios' : 'Agregar producto' ?></button>
    </form>

    <h2>Productos actuales</h2>
    <div class="product-table-wrapper">
      <table class="product-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Descripción</th>
            <th>Imagen</th>
            <th>Categoría</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($productos as $prod): ?>
            <tr>
              <td><?= $prod['idProducto'] ?></td>
              <td><?= $prod['nombre'] ?></td>
              <td>$<?= number_format($prod['precio'], 2) ?></td>
              <td><?= $prod['descripcion'] ?></td>
              <td><img src="<?= $prod['img'] ?>" alt="Imagen" width="50"></td>
              <td><?= $prod['categoria'] ?></td>
              <td>
                <a class="edit-link" href="admin.php?editar=<?= $prod['idProducto'] ?>">Editar</a>
                <a class="delete-link" href="admin.php?eliminar=<?= $prod['idProducto'] ?>" onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php include 'footer.php'; ?>

</body>

</html>