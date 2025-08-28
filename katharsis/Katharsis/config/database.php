<?php
/**
 * Configuración de conexión a la base de datos
 * Test de Oveja Negra - Katharsis K
 */

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'katharsis_test');
define('DB_USER', 'root');        // Cambiar por tu usuario de MySQL
define('DB_PASS', '');            // Cambiar por tu contraseña de MySQL
define('DB_CHARSET', 'utf8mb4');

// Función para conectar a la base de datos
function conectarDB() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $opciones = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $opciones);
        return $pdo;
        
    } catch (PDOException $e) {
        // En producción, no mostrar errores de base de datos
        error_log("Error de conexión: " . $e->getMessage());
        die("Error de conexión a la base de datos");
    }
}

// Función para verificar si la base de datos existe
function verificarDB() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS);
        $stmt = $pdo->query("SHOW DATABASES LIKE 'katharsis_test'");
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        return false;
    }
}

// Función para obtener la conexión o crear la base de datos si no existe
function obtenerConexion() {
    if (!verificarDB()) {
        // Si la base de datos no existe, mostrar instrucciones
        echo "<div style='background: #f8d7da; color: #721c24; padding: 20px; margin: 20px; border: 1px solid #f5c6cb; border-radius: 5px;'>";
        echo "<h3>⚠️ Base de datos no encontrada</h3>";
        echo "<p>Para usar el test, necesitas:</p>";
        echo "<ol>";
        echo "<li>Instalar XAMPP, WAMP o similar</li>";
        echo "<li>Iniciar MySQL</li>";
        echo "<li>Ejecutar el archivo <code>database.sql</code> en phpMyAdmin</li>";
        echo "<li>Verificar la configuración en <code>config/database.php</code></li>";
        echo "</ol>";
        echo "<p><strong>Archivo SQL:</strong> <code>database.sql</code></p>";
        echo "</div>";
        return false;
    }
    
    return conectarDB();
}

// Función para cerrar la conexión
function cerrarConexion($pdo) {
    $pdo = null;
}

// Función para limpiar y validar datos de entrada
function limpiarDatos($dato) {
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}

// Función para validar email
function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Función para obtener la IP del usuario
function obtenerIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
?>
