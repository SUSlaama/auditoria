<?php
  require 'config/config.php';
  require 'config/database.php';
  $db = new Database();
  $con = $db->conectar();  
  // Consulta SQL para obtener todos los productos.
  $sql = $con->prepare("SELECT * FROM producto where categoria='albums'");
  $sql->execute();
  $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>M-3RACHA</title>
    <link rel="stylesheet" href="CSS/estilos.css">
    <link rel="stylesheet" href="CSS/userEstilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;600;700&display=swap" rel="stylesheet"> 
</head>
<body>

  <?php include 'header.php'?>
  

  <div class='contenedor-logo-subtienda'>
  <img src='img/CLOTHES.png' class='logo-subtienda' />
</div>


<div class='productos-contenedor'>
  <?php if (count($resultado) > 0) {
    // Muestra una vista previa del producto.
      foreach ($resultado as $producto) { ?>
          
        <a href='details.php?id=<?php echo $producto['idProducto'];?>&token=<?php 
        echo hash_hmac('sha1', $producto['idProducto'], KEY_TOKEN);?>' class='producto-link'>
        <div class='producto'>"
        <img src='<?php echo $producto['img']?>' alt='Imagen del producto' />"
        <h2><?php echo $producto['nombre'];?></h2>"
        <p>$<?php echo number_format($producto['precio'], 2, '.', ',');?></p>"
        </div>";
        </a>
     <?php }
  } else {
      echo "No hay productos disponibles.";
  } ?>
  </div>
    
</body>

</html>