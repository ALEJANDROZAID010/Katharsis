<?php
/**
 * Test de Oveja Negra - Katharsis K
 * Maneja las respuestas AJAX del test
 */

// Configuración básica
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Incluir configuración de base de datos
require_once 'config/database.php';

// Solo permitir POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Obtener acción
$action = $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'verificar_email':
            $email = limpiarDatos($_POST['email'] ?? '');
            if (!validarEmail($email)) {
                echo json_encode(['existe' => false, 'valido' => false]);
                exit;
            }
            
            $existe = emailExiste($email);
            echo json_encode(['existe' => $existe, 'valido' => true]);
            break;
            
        case 'registrar_usuario':
            $nombre = limpiarDatos($_POST['nombre'] ?? '');
            $celular = limpiarDatos($_POST['celular'] ?? '');
            $pais = limpiarDatos($_POST['pais'] ?? '');
            $email = limpiarDatos($_POST['email'] ?? '');
            
            if (empty($nombre) || empty($celular) || empty($pais) || empty($email)) {
                echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
                exit;
            }
            
            if (!validarEmail($email)) {
                echo json_encode(['success' => false, 'message' => 'Email inválido']);
                exit;
            }
            
            if (emailExiste($email)) {
                echo json_encode(['success' => false, 'message' => 'Este email ya ha sido usado para el test']);
                exit;
            }
            
            $usuario_id = registrarUsuario($nombre, $celular, $pais, $email);
            if ($usuario_id) {
                echo json_encode(['success' => true, 'usuario_id' => $usuario_id]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al registrar usuario']);
            }
            break;
            
        case 'guardar_respuesta':
            $usuario_id = (int)($_POST['usuario_id'] ?? 0);
            $pregunta = (int)($_POST['pregunta'] ?? 0);
            $respuesta = $_POST['respuesta'] ?? '';
            $puntaje = (int)($_POST['puntaje'] ?? 0);
            
            if (!$usuario_id || !$pregunta || !$respuesta) {
                echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
                exit;
            }
            
            if (guardarRespuesta($usuario_id, $pregunta, $respuesta, $puntaje)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al guardar respuesta']);
            }
            break;
            
        case 'finalizar_test':
            $usuario_id = (int)($_POST['usuario_id'] ?? 0);
            if (!$usuario_id) {
                echo json_encode(['success' => false, 'message' => 'Usuario no identificado']);
                exit;
            }
            
            $resultado = calcularResultado($usuario_id);
            if ($resultado) {
                echo json_encode(['success' => true, 'resultado' => $resultado]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al calcular resultado']);
            }
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
            break;
    }
    
} catch (Exception $e) {
    error_log("Error en test-oveja-negra.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error interno del servidor']);
}

// ===== FUNCIONES DE BASE DE DATOS =====

/**
 * Verificar si un email ya existe en la base de datos
 */
function emailExiste($email) {
    try {
        $pdo = obtenerConexion();
        if (!$pdo) return false;
        
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        
        return $stmt->rowCount() > 0;
        
    } catch (Exception $e) {
        error_log("Error en emailExiste: " . $e->getMessage());
        return false;
    }
}

/**
 * Registrar un nuevo usuario
 */
function registrarUsuario($nombre, $celular, $pais, $email) {
    try {
        $pdo = obtenerConexion();
        if (!$pdo) return false;
        
        $ip = obtenerIP();
        
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, celular, pais, email, ip_address) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $celular, $pais, $email, $ip]);
        
        return $pdo->lastInsertId();
        
    } catch (Exception $e) {
        error_log("Error en registrarUsuario: " . $e->getMessage());
        return false;
    }
}

/**
 * Guardar una respuesta del test
 */
function guardarRespuesta($usuario_id, $pregunta, $respuesta, $puntaje) {
    try {
        $pdo = obtenerConexion();
        if (!$pdo) return false;
        
        // Usar INSERT ... ON DUPLICATE KEY UPDATE para evitar duplicados
        $stmt = $pdo->prepare("INSERT INTO respuestas (usuario_id, pregunta_numero, respuesta, puntaje) 
                               VALUES (?, ?, ?, ?) 
                               ON DUPLICATE KEY UPDATE 
                               respuesta = VALUES(respuesta), 
                               puntaje = VALUES(puntaje)");
        
        return $stmt->execute([$usuario_id, $pregunta, $respuesta, $puntaje]);
        
    } catch (Exception $e) {
        error_log("Error en guardarRespuesta: " . $e->getMessage());
        return false;
    }
}

/**
 * Calcular el resultado final del test
 */
function calcularResultado($usuario_id) {
    try {
        $pdo = obtenerConexion();
        if (!$pdo) return false;
        
        // Calcular puntaje total
        $stmt = $pdo->prepare("SELECT SUM(puntaje) as puntaje_total FROM respuestas WHERE usuario_id = ?");
        $stmt->execute([$usuario_id]);
        $row = $stmt->fetch();
        
        $puntaje_total = $row['puntaje_total'] ?? 0;
        
        // Determinar tipo de oveja basado en el puntaje
        $tipo_oveja = '';
        $mensaje = '';
        
        if ($puntaje_total >= 35) {
            $tipo_oveja = 'Oveja Negra Total';
            $mensaje = '¡Eres una oveja negra total! Tienes un pensamiento disruptivo y creativo que te hace único. No temes ir contra la corriente y tus ideas pueden cambiar el mundo.';
        } elseif ($puntaje_total >= 25) {
            $tipo_oveja = 'Oveja Negra Moderada';
            $mensaje = 'Tienes rasgos de oveja negra. Eres creativo y piensas diferente, pero mantienes un equilibrio entre la innovación y la tradición.';
        } elseif ($puntaje_total >= 15) {
            $tipo_oveja = 'Oveja Gris';
            $mensaje = 'Eres una oveja gris. Tienes momentos de creatividad y pensamiento diferente, pero generalmente sigues las convenciones establecidas.';
        } else {
            $tipo_oveja = 'Oveja Blanca';
            $mensaje = 'Eres una oveja blanca. Prefieres seguir las reglas establecidas y mantener el orden tradicional. Eres confiable y predecible.';
        }
        
        // Guardar resultado en la base de datos
        $stmt = $pdo->prepare("INSERT INTO resultados (usuario_id, puntaje_total, tipo_oveja, mensaje_resultado) 
                               VALUES (?, ?, ?, ?) 
                               ON DUPLICATE KEY UPDATE 
                               puntaje_total = VALUES(puntaje_total), 
                               tipo_oveja = VALUES(tipo_oveja), 
                               mensaje_resultado = VALUES(mensaje_resultado)");
        
        $stmt->execute([$usuario_id, $puntaje_total, $tipo_oveja, $mensaje]);
        
        return [
            'tipo' => $tipo_oveja,
            'puntaje_total' => $puntaje_total,
            'mensaje' => $mensaje
        ];
        
    } catch (Exception $e) {
        error_log("Error en calcularResultado: " . $e->getMessage());
        return false;
    }
}
?>
