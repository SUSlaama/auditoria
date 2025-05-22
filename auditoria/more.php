<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>M-3RACHA</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="userEstilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;600;700&display=swap" rel="stylesheet"> 
</head>
<body>

  <?php include 'header.php'?>
  
  <div class='contenedor-logo-subtienda'>
  <img src='img/MORE.png' class='logo-subtienda' />
</div>

  <?php
  $conn = new mysqli("localhost", "root", "", "m3racha");
  // Consulta SQL para obtener todos los productos.
  $sql = "SELECT * FROM producto where categoria='more'";
  $resultado = $conn->query($sql);

  echo "<div class='productos-contenedor'>"; // Asegúrate de que no haya un espacio en el nombre de la clase y agrega el punto y coma.
  if ($resultado->num_rows > 0) {
      while ($producto = $resultado->fetch_assoc()) {
          // Muestra una vista previa del producto.
          echo "<a href='productPage/producto{$producto['idProducto']}.php' class='producto-link'>";
          echo "<div class='producto'>";
          echo "<img src='{$producto['img']}' alt='Imagen del producto' />";
          echo "<h2>{$producto['nombre']}</h2>";
          echo "<p>$ {$producto['precio']}</p>";
          echo "</div>";
          echo "</a>"; // Cierre de la etiqueta <a>
      }
  } else {
        echo "<h2 style='margin-top: 30px;'>No hay productos disponibles</h2>";
  }
  echo "</div>";
  
  $conn->close();
  ?>
  <?php include('footer.php');
    ?>
</body>

</html>