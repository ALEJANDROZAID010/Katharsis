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
?>
