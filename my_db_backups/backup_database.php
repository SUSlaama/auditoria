<?php
// Define log file path and logging function
$log_dir = __DIR__ . '/backup_logs';
$log_file = $log_dir . '/backup_log_' . date("Ymd") . '.log';

// Create log directory if it doesn't exist
if (!is_dir($log_dir)) {
    mkdir($log_dir, 0755, true);
}

function write_log($message, $type = 'INFO') {
    global $log_file;
    $timestamp = date("Y-m-d H:i:s");
    $log_entry = "[$timestamp] [$type] $message" . PHP_EOL;
    file_put_contents($log_file, $log_entry, FILE_APPEND);
}

// Start logging
write_log("Database backup process started");

// --- CONFIGURACIÓN ---
$db_host   = "localhost";
$db_user   = "root";
$db_pass   = "";
$db_name   = "m3racha";

// Directorio donde se guardarán los respaldos 
$backup_dir = __DIR__ . '/my_db_backups';

// Compression option
$compress = false; // Set to true to enable gzip compression

// Nombre del archivo de respaldo
$backup_file = $db_name . '_backup_' . date("Ymd_His") . '.sql';
$full_backup_path = $backup_dir . '/' . $backup_file;
if ($compress) {
    $full_backup_path .= '.gz';
}

write_log("Configurando respaldo en: " . $full_backup_path);

// Clave secreta para ejecutar el script (para evitar ejecución no autorizada)
$secret_key = "VHz5yKhuxNjRZ4db87r6HaFdRKTuJAt51B0Ub2EC";
if (!isset($_GET['key']) || $_GET['key'] !== $secret_key) {
    write_log("Intento de acceso no autorizado desde IP: " . $_SERVER['REMOTE_ADDR'], "ERROR");
    die("Acceso no autorizado.");
}
write_log("Acceso autorizado con clave correcta");

// --- FIN DE CONFIGURACIÓN ---

// Crear directorio de respaldo si no existe
if (!is_dir($backup_dir)) {
    write_log("Intentando crear directorio de respaldo: " . $backup_dir);
    if (!mkdir($backup_dir, 0755, true)) {
        write_log("No se pudo crear el directorio de respaldo: " . $backup_dir, "ERROR");
        die("Error: No se pudo crear el directorio de respaldo: " . $backup_dir);
    }
    write_log("Directorio de respaldo creado exitosamente");
}
if (!is_writable($backup_dir)) {
    write_log("El directorio de respaldo no tiene permisos de escritura: " . $backup_dir, "ERROR");
    die("Error: El directorio de respaldo no tiene permisos de escritura: " . $backup_dir);
}

// Conexión a la base de datos
write_log("Intentando conectar a la base de datos: " . $db_host . "/" . $db_name);
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    write_log("Error de conexión a la base de datos: " . $conn->connect_error, "ERROR");
    die("Error de conexión: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
write_log("Conexión a la base de datos establecida correctamente");

// Obtener todas las tablas
$tables = array();
write_log("Obteniendo lista de tablas");
$result = $conn->query("SHOW TABLES");
if (!$result) {
    write_log("Error al obtener tablas: " . $conn->error, "ERROR");
    die("Error al obtener tablas: " . $conn->error);
}
while ($row = $result->fetch_row()) {
    $tables[] = $row[0];
}
write_log("Se encontraron " . count($tables) . " tablas en la base de datos");

$sql_dump = "";

// Desactivar temporalmente la verificación de claves foráneas
$sql_dump .= "SET FOREIGN_KEY_CHECKS=0;\n\n";
write_log("Desactivando verificación de claves foráneas para el respaldo");

// Recorrer cada tabla
foreach ($tables as $table) {
    write_log("Procesando tabla: " . $table);
    
    // Obtener la estructura de la tabla (CREATE TABLE)
    $result = $conn->query("SHOW CREATE TABLE `{$table}`");
    if (!$result) {
        write_log("Error al obtener CREATE TABLE para `{$table}`: " . $conn->error, "ERROR");
        die("Error al obtener CREATE TABLE para `{$table}`: " . $conn->error);
    }
    $row = $result->fetch_row();
    $sql_dump .= "\n\n-- Estructura de la tabla `{$table}`\n";
    $sql_dump .= "DROP TABLE IF EXISTS `{$table}`;\n";
    $sql_dump .= $row[1] . ";\n\n";
    write_log("Estructura de la tabla `{$table}` obtenida correctamente");

    // Obtener los datos de la tabla (INSERT INTO)
    $result = $conn->query("SELECT * FROM `{$table}`");
    if (!$result) {
        write_log("Error al obtener datos de `{$table}`: " . $conn->error, "ERROR");
        die("Error al obtener datos de `{$table}`: " . $conn->error);
    }
    $num_fields = $result->field_count;
    $row_count = $result->num_rows;
    write_log("Tabla `{$table}`: encontradas " . $row_count . " filas para respaldar");

    if ($row_count > 0) {
        $sql_dump .= "-- Volcado de datos para la tabla `{$table}`\n";
        $rows_processed = 0;
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
            $rows_processed++;
        }
        $sql_dump .= "\n";
        write_log("Finalizó el respaldo de " . $rows_processed . " filas de la tabla `{$table}`");
    }
}

// Reactivar la verificación de claves foráneas
$sql_dump .= "SET FOREIGN_KEY_CHECKS=1;\n";
write_log("Reactivando verificación de claves foráneas");

$conn->close();
write_log("Conexión a la base de datos cerrada");

// Guardar el volcado SQL en un archivo
try {
    write_log("Intentando guardar el archivo de respaldo (" . (strlen($sql_dump) / 1024) . " KB)");
    if ($compress) {
        write_log("Usando compresión gzip para el archivo de respaldo");
        $gz_handle = gzopen($full_backup_path, 'w9');
        if (!$gz_handle) {
            write_log("No se pudo abrir el archivo GZ para escritura: " . $full_backup_path, "ERROR");
            throw new Exception("No se pudo abrir el archivo GZ para escritura.");
        }
        gzwrite($gz_handle, $sql_dump);
        gzclose($gz_handle);
        write_log("Archivo de respaldo comprimido guardado correctamente");
    } else {
        if (file_put_contents($full_backup_path, $sql_dump) === false) {
            write_log("No se pudo escribir en el archivo de respaldo: " . $full_backup_path, "ERROR");
            throw new Exception("No se pudo escribir en el archivo de respaldo.");
        }
        write_log("Archivo de respaldo guardado correctamente");
    }
    write_log("Respaldo completado exitosamente: " . basename($full_backup_path), "SUCCESS");
    echo "Respaldo de base de datos completado exitosamente: " . basename($full_backup_path);
} catch (Exception $e) {
    write_log("Error al guardar el respaldo: " . $e->getMessage(), "ERROR");
    die("Error al guardar el respaldo: " . $e->getMessage());
}

write_log("Proceso de respaldo finalizado");
?>
