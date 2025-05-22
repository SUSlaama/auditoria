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

        <!-- Botón para respaldar base de datos -->
        <div class="backup-button">
            <a href="my_db_backups/backup_database.php?key=VHz5yKhuxNjRZ4db87r6HaFdRKTuJAt51B0Ub2EC" class="btn-backup">
                Respaldar base de datos
            </a>
        </div>

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
