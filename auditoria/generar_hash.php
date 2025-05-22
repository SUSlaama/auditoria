<?php

$contrasenaEnTextoPlano = 'XeJa4jMzCx3fDwf0pYKh3YXWjkXde7wXs9PufcrS';
// -------------------------------------------------------------------------

$hashGenerado = password_hash($contrasenaEnTextoPlano, PASSWORD_DEFAULT);

echo "<h1>Generador de Hash de Contraseña</h1>";
echo "<p><strong>Contraseña Original (Texto Plano):</strong> " . htmlspecialchars($contrasenaEnTextoPlano) . "</p>";
echo "<textarea rows='3' cols='70' readonly>" . htmlspecialchars($hashGenerado) . "</textarea>";

$info = password_get_info($hashGenerado);
echo "<h3>Información del Hash (Opcional):</h3>";
echo "<pre>";
print_r($info);
echo "</pre>";

?>
