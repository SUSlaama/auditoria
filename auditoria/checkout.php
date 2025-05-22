<?php
  require_once 'config/config.php';
  require_once 'config/database.php';
  $db = new Database();
  $con = $db->conectar();
  
  $lista_carrito = [];

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

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
                <td> <a href="#" class="btn btn-warning btn-sm btn-eliminar" data-bs-id="<?php echo $_id ?>"> Eliminar </a> </td>
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
        <div class="col-md-5 offset-md-7">
            <a href="pago.php" class="btn_pago">Realizar pago</a>
        </div>
    </div>
    <?php } ?>

</div>

<div class="modal fade" id="eliminaModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de eliminar este producto del carrito?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="btnEliminar">Eliminar</button>
      </div>
    </div>
  </div>
</div>

<?php     include('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function actualizaCantidad(cantidad, id){
        let url = 'clases/actualizar_carrito.php'
        let formData = new FormData()
        formData.append('action', 'agregar')
        formData.append('id', id)
        formData.append('cantidad', cantidad)

        fetch(url, {
            method: 'POST',
            body: formData
        }).then(response => response.json()).then(data =>{
            if(data.ok){
                location.reload();
            }
        })
    }

    const eliminaModal = new bootstrap.Modal(document.getElementById('eliminaModal'));
    let productId;

    // Solo muestra el modal al hacer clic en eliminar
    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            productId = e.target.getAttribute('data-bs-id');
            eliminaModal.show();
        });
    });

    // Acción de eliminación
    document.getElementById('btnEliminar').addEventListener('click', () => {
        fetch('clases/actualizar_carrito.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `action=eliminar&id=${productId}`
        })
        .then(response => response.json())
        .then(data => {
            if(data.ok) {
                eliminaModal.hide();
                setTimeout(() => location.reload(), 300); // Espera a que se cierre el modal
            }
        });
    });
</script>
</body>

</html>