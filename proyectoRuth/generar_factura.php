<?php
$data = json_decode(file_get_contents("php://input"), true);

// Generar datos aleatorios si faltan o son requeridos
$fecha = $data['fecha'] ?? date("Y-m-d");
$numero_factura = rand(1000, 9999);
$moneda = $data['moneda'] ?? "USD";
$total = $data['total'] ?? "100.00";

$postData = [
    'from' => "Tu Empresa\nDirección Ejemplo\nCiudad, País",
    'to' => "{$data['nombre']}\n{$data['email']}",
    'items' => [
        [
            'name' => 'Pago en línea',
            'quantity' => 1,
            'unit_cost' => $total
        ]
    ],
    'currency' => $moneda,
    'number' => $numero_factura,
    'date' => $fecha,
    'due_date' => $fecha,
    'notes' => 'Gracias por tu compra. Este es un ejemplo generado con el modo Sandbox.',
    'terms' => 'El pago ya ha sido procesado exitosamente.'
];

$ch = curl_init('https://invoice-generator.com');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded',
    'Authorization: Bearer sk_z6wZk85OiPyHAK7LfsmeX62F7BZdxxsH' // Reemplaza 'myApiKey' con tu clave real
]);
$result = curl_exec($ch);
curl_close($ch);

if ($result) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="factura.pdf"');
    echo $result;
} else {
    http_response_code(500);
    echo "Error al generar la factura.";
}
?>

