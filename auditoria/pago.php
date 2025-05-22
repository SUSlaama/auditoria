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
  


< class='lista-carrito'>
  <div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
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
                <td>
                    <div id="subtotal_<?php echo $_id;?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal, 2, '.', ',') ?></div>
                </td>

            </tr>
            <?php } ?>
            
            <tr>
                <td colspan="3"></td>
                <td colspan="2">
                    <p class="h3"id="total"><?php echo MONEDA . 
                    number_format($total, 2, '.', ',')?></p>
                </td>
            </tr>


        </tbody>
        <?php } ?>
    </table>
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
<script

src="https://www.paypal.com/sdk/js?client-id=AamBPLpv0PQb7OtDAttavG3QdqSABMbZE4DVlYul1QX3ovW9pS5vSsoUpR4mYS-rTE-0rMEcfV5WBCi9&buyer-country=US&currency=USD&components=buttons&enable-funding=venmo,paylater,card"
data-sdk-integration-source="developer-studio"

></script>

<div id="paypal-button-container"></div>
<script src="https://www.paypal.com/sdk/js?client-id=AamBPLpv0PQb7OtDAttavG3QdqSABMbZE4DVlYul1QX3ovW9pS5vSsoUpR4mYS-rTE-0rMEcfV5WBCi9&currency=MXN"></script>
<script>
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?= $total ?>' // Total del carrito desde PHP
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
    return actions.order.capture().then(function(details) {
        // Preparar datos para Invoice Generator
        const datosFactura = {
            nombre: details.payer.name.given_name + ' ' + details.payer.name.surname,
            email: details.payer.email_address,
            total: details.purchase_units[0].amount.value,
            moneda: details.purchase_units[0].amount.currency_code,
            fecha: new Date().toLocaleDateString()
        };

        // Enviar a PHP para usar Invoice Generator
        fetch('generar_factura.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(datosFactura)
        }).then(response => response.blob())
          .then(blob => {
              // Descargar la factura generada
              const url = window.URL.createObjectURL(blob);
              const a = document.createElement('a');
              a.href = url;
              a.download = 'factura.pdf';
              document.body.appendChild(a);
              a.click();
              a.remove();
          });
    });
}

,
        onError: function(err) {
            console.error(err);
            alert('Hubo un error al procesar el pago');
        }
    }).render('#paypal-button-container');
</script>

</div>
</body>

</html>