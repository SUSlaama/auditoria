<?php
  require 'config/config.php';
  require 'config/database.php';
  $db = new Database();
  $con = $db->conectar();  

  $product = isset($_SESSION['carrito']['producto']) ? $_SESSION['carrito']['producto'] : null;

  if ($product != null){
    foreach($product as $clave=> $cantidad){
        $sql = $con->prepare("SELECT idProducto, nombre, precio, $cantidad as cantidad FROM producto where idProducto=?");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
  }


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

  <?php include 'header.php';?>
  


<div class='lista-carrito'>
  <div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($lista_carrito == null){
                echo '<tr><td colspan="5" class ="text-center"><b>Lista vacia</b></td></tr>';
            } else {
                $total = 0;
                foreach ($lista_carrito as $product){
                    $_id = $product['idProducto'];
                    $nombre = $product['nombre'];
                    $precio = $product['precio'];
                    $cantidad = $product['cantidad'];
                    $subtotal = $cantidad * $precio;
                    $total += $subtotal;
                
            ?>
            <tr>
                <td><?php echo $nombre ?></td>
                <td><?php echo MONEDA . number_format($precio, 2, '.', ',') ?></td>
                <td>
                    <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad ?>" size="5" 
                    id="cantidad_<?php echo $_id;?>" onchange="actualizaCantidad(this.value, <?php echo $_id ?>)" >
                </td>
                <td>
                    <div id="subtotal_<?php echo $_id;?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal, 2, '.', ',') ?></div>
                </td>
                <td> <a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id ?>" 
                data-bs-toggle="modal" data-bd-target="eliminaModal" >Eliminar</a> </td>
            </tr>
            <?php } ?>
            
            <tr>
                <td colspan="3"></td>
                <td colspan="3">
                    <p class="h3"id="total"><?php echo MONEDA . 
                    number_format($total, 2, '.', ',')?></p>
                </td>
            </tr>


        </tbody>
        <?php } ?>
    </table>
  </div>

  <?php if ($lista_carrito != null) { ?>
  <div class="row">
        <div class="col-md-5 offset-md-7 d-grid gap-2">
            <a href="pago.php" class="btn_pago">Realizar pago</a>
        </div>
  </div>
  <?php } ?>
</div>
    

<script>
    function actualizaCantidad(cantidad, id){
        let url = 'clases/actualizar_carrito.php'
        let formData = new FormData()
        formData.append('action', agregar)
        formData.append('id', id)
        formData.append('cantidad', cantidad)

        fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors'
        }).then(response => response.json()).then(data =>{
            if(data.ok){
                let elemento = document.getElementById("num_cart")
                elemento.innerHTML = data.numero
            }
        })
    }
</script>
</body>

</html><?php
  require 'config/config.php';
  require 'config/database.php';
  $db = new Database();
  $con = $db->conectar();  

  $product = isset($_SESSION['carrito']['producto']) ? $_SESSION['carrito']['producto'] : null;

  if ($product != null){
    foreach($product as $clave=> $cantidad){
        $sql = $con->prepare("SELECT idProducto, nombre, precio, $cantidad as cantidad FROM producto where idProducto=?");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
  }


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

  <?php include 'header.php';?>
  


<div class='lista-carrito'>
  <div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($lista_carrito == null){
                echo '<tr><td colspan="5" class ="text-center"><b>Lista vacia</b></td></tr>';
            } else {
                $total = 0;
                foreach ($lista_carrito as $product){
                    $_id = $product['idProducto'];
                    $nombre = $product['nombre'];
                    $precio = $product['precio'];
                    $cantidad = $product['cantidad'];
                    $subtotal = $cantidad * $precio;
                    $total += $subtotal;
                
            ?>
            <tr>
                <td><?php echo $nombre ?></td>
                <td><?php echo MONEDA . number_format($precio, 2, '.', ',') ?></td>
                <td>
                    <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad ?>" size="5" 
                    id="cantidad_<?php echo $_id;?>" onchange="actualizaCantidad(this.value, <?php echo $_id ?>)" >
                </td>
                <td>
                    <div id="subtotal_<?php echo $_id;?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal, 2, '.', ',') ?></div>
                </td>
                <td> <a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id ?>" 
                data-bs-toggle="modal" data-bd-target="eliminaModal" >Eliminar</a> </td>
            </tr>
            <?php } ?>
            
            <tr>
                <td colspan="3"></td>
                <td colspan="3">
                    <p class="h3"id="total"><?php echo MONEDA . 
                    number_format($total, 2, '.', ',')?></p>
                </td>
            </tr>


        </tbody>
        <?php } ?>
    </table>
  </div>

  <?php if ($lista_carrito != null) { ?>
  <div class="row">
        <div class="col-md-5 offset-md-7 d-grid gap-2">
            <a href="pago.php" class="btn_pago">Realizar pago</a>
        </div>
  </div>
  <?php } ?>
</div>
    

<script>
    function actualizaCantidad(cantidad, id){
        let url = 'clases/actualizar_carrito.php'
        let formData = new FormData()
        formData.append('action', agregar)
        formData.append('id', id)
        formData.append('cantidad', cantidad)

        fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors'
        }).then(response => response.json()).then(data =>{
            if(data.ok){
                let elemento = document.getElementById("num_cart")
                elemento.innerHTML = data.numero
            }
        })
    }
</script>
</body>

</html><?php
  require 'config/config.php';
  require 'config/database.php';
  $db = new Database();
  $con = $db->conectar();  

  $product = isset($_SESSION['carrito']['producto']) ? $_SESSION['carrito']['producto'] : null;

  if ($product != null){
    foreach($product as $clave=> $cantidad){
        $sql = $con->prepare("SELECT idProducto, nombre, precio, $cantidad as cantidad FROM producto where idProducto=?");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
  }


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

  <?php include 'header.php';?>
  


<div class='lista-carrito'>
  <div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($lista_carrito == null){
                echo '<tr><td colspan="5" class ="text-center"><b>Lista vacia</b></td></tr>';
            } else {
                $total = 0;
                foreach ($lista_carrito as $product){
                    $_id = $product['idProducto'];
                    $nombre = $product['nombre'];
                    $precio = $product['precio'];
                    $cantidad = $product['cantidad'];
                    $subtotal = $cantidad * $precio;
                    $total += $subtotal;
                
            ?>
            <tr>
                <td><?php echo $nombre ?></td>
                <td><?php echo MONEDA . number_format($precio, 2, '.', ',') ?></td>
                <td>
                    <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad ?>" size="5" 
                    id="cantidad_<?php echo $_id;?>" onchange="actualizaCantidad(this.value, <?php echo $_id ?>)" >
                </td>
                <td>
                    <div id="subtotal_<?php echo $_id;?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal, 2, '.', ',') ?></div>
                </td>
                <td> <a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id ?>" 
                data-bs-toggle="modal" data-bd-target="eliminaModal" >Eliminar</a> </td>
            </tr>
            <?php } ?>
            
            <tr>
                <td colspan="3"></td>
                <td colspan="3">
                    <p class="h3"id="total"><?php echo MONEDA . 
                    number_format($total, 2, '.', ',')?></p>
                </td>
            </tr>


        </tbody>
        <?php } ?>
    </table>
  </div>

  <?php if ($lista_carrito != null) { ?>
  <div class="row">
        <div class="col-md-5 offset-md-7 d-grid gap-2">
            <a href="pago.php" class="btn_pago">Realizar pago</a>
        </div>
  </div>
  <?php } ?>
</div>
    

<script>
    function actualizaCantidad(cantidad, id){
        let url = 'clases/actualizar_carrito.php'
        let formData = new FormData()
        formData.append('action', agregar)
        formData.append('id', id)
        formData.append('cantidad', cantidad)

        fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors'
        }).then(response => response.json()).then(data =>{
            if(data.ok){
                let elemento = document.getElementById("num_cart")
                elemento.innerHTML = data.numero
            }
        })
    }
</script>
</body>

</html>