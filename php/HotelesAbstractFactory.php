<?php

require_once '../clases/Factories.php';
require_once '../clases/HotelFactory.php';
session_start();

/**
 * Description of Paquetes_Turisticos
 *
 * @author gabriel.anchique
 */
CONST CONSULTAR_PAQUETES = 101;
CONST CREAR_HOTELES_ABSTRACT = 102;

$accion = isset($_POST['accion']) ? $_POST['accion'] : null;
$datos = isset($_POST['datos']) ? $_POST['datos'] : null;
$hayPaquete = isset($_POST['plantilla']) ? true : false;

switch ($accion) {
    case CONSULTAR_PAQUETES:
//        session_start();
//        session_unset();
//        session_destroy();
        $datos = array();
        if (!isset($_SESSION['paquetes'])) {
            $plantilla = new PaqueteTuristico("No",0,"No","No","No", array());
            $_SESSION['plantilla'] = $plantilla;
            $nuevoPaquete = $_SESSION['plantilla']->clonar();
            $_SESSION['paquetes'][] = $nuevoPaquete;
        }

        foreach ($_SESSION['paquetes'] as $value) {
            $obj = new stdClass();
            $obj->nombre = $value->nombre;
            $obj->precio = "$" . number_format($value->precio, 2);
            $obj->incluyeDesayuno = $value->incluyeDesayuno;
            $obj->cantidadNoches = $value->cantidadNoches;
            $obj->transporteIncluido = $value->transporteIncluido;
            $obj->guiaTuristico = $value->guiaTuristico;
            $obj->actividades = array_values($value->actividades);
            $obj->seguroDeViaje = $value->seguroDeViaje;
            $datos[] = $obj;
        }
        
        echo json_encode(['data' => $datos]);
    break;
    case CREAR_HOTELES_ABSTRACT:
        $datos = json_decode($datos);
        $tipoHotel = $datos->tipoHotel;

        $factory = null;    
        switch ($tipoHotel) {
            case 1:
                $factory = new EconomicoFactory();
                break;
            case 2:
                $factory = new LujoFactory();
                break;
            default:
                throw new Exception('Tipo de hotel inválido');
        }
    
        $reserva = $factory->crearReserva();
        $servicio = $factory->crearServicio();
        $pago = $factory->crearPago();
    
        echo json_encode([
            'success' => true,
            'reserva' => $reserva->detalles(),
            'servicio' => $servicio->descripcion(),
            'pago' => $pago->procesar()
        ]);

    break;



    default:
        echo "Acción no válida.";
        break;
}
?>