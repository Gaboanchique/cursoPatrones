<?php

require_once '../clases/HotelFactory.php';
require_once '../clases/Factories.php';
session_start();

/**
 * Description of Paquetes_Turisticos
 *
 * @author gabriel.anchique
 */
CONST CREAR_HOTELES_ABSTRACT = 102;

$accion = isset($_POST['accion']) ? $_POST['accion'] : null;
$datos = isset($_POST['datos']) ? $_POST['datos'] : null;

switch ($accion) {
    case CREAR_HOTELES_ABSTRACT:
        $datos = json_decode($datos);
        $tipoHotel = (int) $datos->tipoHotel;
//        var_dump($tipoHotel);
//        exit();
        $factory = null;
        $nombre = "";
        switch ($tipoHotel) {
            case 1:
                $factory = new EconomicoFactory();
                $nombre = "Economico";
                break;
            case 2:
                $factory = new LujoFactory();
                $nombre = "De Lujo";
                break;
            default:
                throw new Exception('Tipo de hotel inválido');
        }

        $reserva = $factory->crearReserva();
        $servicio = $factory->crearServicio();
        $pago = $factory->crearPago();

        $obj = new stdClass();
        $obj->nombre = $nombre;
        $obj->reserva = $reserva->detalles();
        $obj->servicio = $servicio->descripcion();
        $obj->pago = $pago->procesar();
        echo json_encode(['data' => $obj]);

        break;

    default:
        echo "Acción no válida.";
        break;
}
?>