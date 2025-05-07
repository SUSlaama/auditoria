<?php
// backup_database.php

// --- CONFIGURACIÓN ---
$db_host   = "sql204.infinityfree.com";
$db_user   = "if0_37860573";
$db_pass   = "Vitacore05";
$db_name   = "if0_37860573_m3racha";

// Directorio donde se guardarán los respaldos 
$backup_dir = __DIR__ . '/my_db_backups';

// Nombre del archivo de respaldo
$backup_file = $db_name . '_backup_' . date("Ymd_His") . '.sql';
$full_backup_path = $backup_dir . '/' . $backup_file;

// Clave secreta para ejecutar el script (para evitar ejecución no autorizada)
$secret_key = "*zgWmk2gGxbPYe^BYAmueeEreW2e&16zQnKCJvkS"; // Cambia esto por algo seguro
if (!isset($_GET['key']) || $_GET['key'] !== $secret_key) {
    die("Acceso no autorizado.");
}

// --- FIN DE CONFIGURACIÓN ---

// Crear directorio de respaldo si no existe
if (!is_dir($backup_dir)) {
    if (!mkdir($backup_dir, 0755, true)) {
        die("Error: No se pudo crear el directorio de respaldo: " . $backup_dir);
    }
}
if (!is_writable($backup_dir)) {
    die("Error: El directorio de respaldo no tiene permisos de escritura: " . $backup_dir);
}

// Conexión a la base de datos
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4"); // Recomendado

// Obtener todas las tablas
$tables = array();
$result = $conn->query("SHOW TABLES");
if (!$result) {
    die("Error al obtener tablas: " . $conn->error);
}
while ($row = $result->fetch_row()) {
    $tables[] = $row[0];
}

$sql_dump = "";

// Desactivar temporalmente la verificación de claves foráneas
$sql_dump .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

// Recorrer cada tabla
foreach ($tables as $table) {
    // Obtener la estructura de la tabla (CREATE TABLE)
    $result = $conn->query("SHOW CREATE TABLE `{$table}`");
    if (!$result) {
        die("Error al obtener CREATE TABLE para `{$table}`: " . $conn->error);
    }
    $row = $result->fetch_row();
    $sql_dump .= "\n\n-- Estructura de la tabla `{$table}`\n";
    $sql_dump .= "DROP TABLE IF EXISTS `{$table}`;\n"; // Opcional: para limpiar antes de restaurar
    $sql_dump .= $row[1] . ";\n\n"; // $row[1] contiene la sentencia CREATE TABLE

    // Obtener los datos de la tabla (INSERT INTO)
    $result = $conn->query("SELECT * FROM `{$table}`");
    if (!$result) {
        die("Error al obtener datos de `{$table}`: " . $conn->error);
    }
    $num_fields = $result->field_count;

    if ($result->num_rows > 0) {
        $sql_dump .= "-- Volcado de datos para la tabla `{$table}`\n";
        while ($row = $result->fetch_assoc()) {
            $sql_dump .= "INSERT INTO `{$table}` VALUES(";
            $first = true;
            foreach ($row as $field_value) {
                if (!$first) {
                    $sql_dump .= ', ';
                }
                if ($field_value === null) {
                    $sql_dump .= "NULL";
                } else {
                    $sql_dump .= "'" . $conn->real_escape_string($field_value) . "'";
                }
                $first = false;
            }
            $sql_dump .= ");\n";
        }
        $sql_dump .= "\n";
    }
}

// Reactivar la verificación de claves foráneas
$sql_dump .= "SET FOREIGN_KEY_CHECKS=1;\n";

$conn->close();

// Guardar el volcado SQL en un archivo
try {
    if ($compress) {
        $gz_handle = gzopen($full_backup_path, 'w9'); // 'w9' es máxima compresión
        if (!$gz_handle) {
            throw new Exception("No se pudo abrir el archivo GZ para escritura.");
        }
        gzwrite($gz_handle, $sql_dump);
        gzclose($gz_handle);
    } else {
        if (file_put_contents($full_backup_path, $sql_dump) === false) {
            throw new Exception("No se pudo escribir en el archivo de respaldo.");
        }
    }
    echo "Respaldo de base de datos completado exitosamente: " . basename($full_backup_path);
} catch (Exception $e) {
    die("Error al guardar el respaldo: " . $e->getMessage());
}

?>
