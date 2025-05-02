<?php
require_once '../clases/Itinerario.php';
require_once '../clases/FabricaItinerario.php';
require_once '../clases/Fabrica.php';
require_once '../clases/Actividad.php';

CONST CREAR_ITINERARIO = 101;

$accion = isset($_POST['accion']) ? $_POST['accion'] : null;
$datos = isset($_POST['datos']) ? $_POST['datos'] : null;
// Endpoint para manejar solicitudes Ajax
header('Content-Type: application/json');

try {
    // Obtener datos de la solicitud POST
    $data = json_decode(file_get_contents('php://input'), true);
    $parametros = [
        'tipo' => $data['tipo'] ?? null,
        'destino' => $data['destino'] ?? null,
        'hora_salida' => $data['hora_salida'] ?? null,
        'duracion' => $data['duracion'] ?? null,
        'punto_encuentro' => $data['punto_encuentro'] ?? null,
        'desayuno' => $data['desayuno'] ?? 'Desayuno estándar',
        'almuerzo' => $data['almuerzo'] ?? 'Almuerzo estándar'
    ];

    // Validar parámetros requeridos
    if (!$parametros['tipo'] || !$parametros['destino'] || !$parametros['hora_salida'] || !$parametros['duracion'] || !$parametros['punto_encuentro']) {
        throw new Exception("Faltan parámetros requeridos");
    }

    // Validar formato de hora_salida (HH:MM)
    if (!preg_match('/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/', $parametros['hora_salida'])) {
        throw new Exception("Formato de hora de salida inválido (use HH:MM)");
    }

    // Validar duración (número entero positivo)
    if (!is_numeric($parametros['duracion']) || $parametros['duracion'] <= 0) {
        throw new Exception("Duración debe ser un número positivo");
    }

    // Crear el itinerario
    $itinerario = CreadorItinerario::obtenerItinerario($parametros);
    echo json_encode([
        'exito' => true,
        'itinerario' => $itinerario->toArray()
    ]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'exito' => false,
        'error' => $e->getMessage()
    ]);
}
?>