<?php

require_once '../clases/Prototype.php';
require_once '../clases/PaqueteTuristico.php';
require_once '../clases/PaqueteTuristicoSP.php';
session_start();

/**
 * Description of Paquetes_Turisticos
 *
 * @author gabriel.anchique
 */
CONST REGISTRARSP = 99;
CONST REGISTRAR = 100;
CONST CONSULTAR = 101;

$accion = isset($_POST['accion']) ? $_POST['accion'] : null;
$datos = isset($_POST['datos']) ? $_POST['datos'] : null;
$hayPaquete = isset($_POST['plantilla']) ? true : false;

switch ($accion) {
    case REGISTRAR:
        $datos = json_decode($datos);
        $nombre = $datos->nombre;
        $incluyeDesayuno = $datos->incluyeDesayuno;
        $cantidadNoches = (int) $datos->cantidadNoches;
        $transporteIncluido = $datos->transporteIncluido;
        $guiaTuristico = $datos->guiaTuristico;
        $actividades = $datos->actividades;
        $seguroViaje = $datos->seguroViaje;
        $actividades = json_decode($actividades);
        $incluyeDesayuno = $incluyeDesayuno ? "Si" : "No";
        $transporteIncluido = $transporteIncluido ? "Si" : "No";
        $guiaTuristico = $guiaTuristico ? "Si" : "No";
        $seguroViaje = $seguroViaje ? "Si" : "No";
        $precioActividadesEscogidas = 0;
        $actividadesEscogidas = array();
        
          foreach ($actividades as $value) {
            switch ($value) {
                case 1:
                    $actividadesEscogidas[] = "Senderismo";
                    break;
                case 2:
                    $actividadesEscogidas[] = "Rafting";
                    break;
                case 3:
                    $actividadesEscogidas[] = "Cabalgata";
                    break;
                case 4:
                    $actividadesEscogidas[] = "Tour Gastronomico";
                    break;
                case 5:
                    $actividadesEscogidas[] = "Parapente";
                    break;
                case 6:
                    $actividadesEscogidas[] = "Visita a Museos";
                    break;
                case 7:
                    $actividadesEscogidas[] = "Nado con Delfines";
                    break;
                case 8:
                    $actividadesEscogidas[] = "Escalada";
                    break;

                default:
                    break;
            }
        }
        
        if (!$hayPaquete) {
            $plantilla = new PaqueteTuristico($incluyeDesayuno,0,$transporteIncluido,$guiaTuristico,$seguroViaje, $actividadesEscogidas);
            $_SESSION['plantilla'] = $plantilla;
        }

        $nuevoPaquete = $_SESSION['plantilla']->clonar();
        if ($nombre != "") {
            $nuevoPaquete->nombre = $nombre;
        }
        $nuevoPaquete->actividades = array_unique(array_merge($actividadesEscogidas, $nuevoPaquete->actividadesObligatorias));
        $nuevoPaquete->incluyeDesayuno = $incluyeDesayuno;
        $nuevoPaquete->cantidadNoches = $cantidadNoches;
        $nuevoPaquete->transporteIncluido = $transporteIncluido;
        $nuevoPaquete->guiaTuristico = $guiaTuristico;
        $nuevoPaquete->seguroDeViaje = $seguroViaje;

        $_SESSION['paquetes'][] = $nuevoPaquete;
        echo json_encode(['data' => $_SESSION['paquetes']]);
        break;
    case REGISTRARSP:
        $precioBase = 100000;
        $datos = json_decode($datos);
        $nombre = $datos->nombre;
        $incluyeDesayuno = $datos->incluyeDesayuno;
        $cantidadNoches = (int) $datos->cantidadNoches;
        $transporteIncluido = $datos->transporteIncluido;
        $guiaTuristico = $datos->guiaTuristico;
        $actividades = $datos->actividades;
        $seguroViaje = $datos->seguroViaje;
        $actividades = json_decode($actividades);
        if ($incluyeDesayuno) {
            $precioBase += 10000 * $cantidadNoches;
        }
        if ($transporteIncluido) {
            $precioBase += 20000;
        }
        if ($guiaTuristico) {
            $precioBase += 30000;
        }
        if ($seguroViaje) {
            $precioBase += 40000;
        }
        $incluyeDesayuno = $incluyeDesayuno ? "Si" : "No";
        $transporteIncluido = $transporteIncluido ? "Si" : "No";
        $guiaTuristico = $guiaTuristico ? "Si" : "No";
        $seguroViaje = $seguroViaje ? "Si" : "No";
        $actividadesEscogidas = array();
        $precioActividadesEscogidas = 0;
        $actividadesObligatorias = ['Visita cultural al centro historico', 'Recorrido panorámico por lugares emblematicos', 'Almuerzo en un restaurante tipico'];
        foreach ($actividades as $value) {
            switch ($value) {
                case 1:
                    $actividadesEscogidas[] = "Senderismo";
                    $precioActividadesEscogidas += 10000;
                    break;
                case 2:
                    $actividadesEscogidas[] = "Rafting";
                    $precioActividadesEscogidas += 20000;
                    break;
                case 3:
                    $actividadesEscogidas[] = "Cabalgata";
                    $precioActividadesEscogidas += 15000;
                    break;
                case 4:
                    $actividadesEscogidas[] = "Tour Gastronomico";
                    $precioActividadesEscogidas += 5000;
                    break;
                case 5:
                    $actividadesEscogidas[] = "Parapente";
                    $precioActividadesEscogidas += 10000;
                    break;
                case 6:
                    $actividadesEscogidas[] = "Visita a Museos";
                    $precioActividadesEscogidas += 15000;
                    break;
                case 7:
                    $actividadesEscogidas[] = "Nado con Delfines";
                    $precioActividadesEscogidas += 90000;
                    break;
                case 8:
                    $actividadesEscogidas[] = "Escalada";
                    $precioActividadesEscogidas += 40000;
                    break;

                default:
                    break;
            }
        }

        $nuevoPaquete = new PaqueteTuristicoSP();
        $nuevoPaquete->setNombre($nombre);
        $nuevoPaquete->setPrecio($precioBase + $precioActividadesEscogidas);
        $nuevoPaquete->setActividadesObligatorias($actividadesObligatorias);
        $nuevoPaquete->setIncluyeDesayuno($incluyeDesayuno);
        $nuevoPaquete->setCantidadNoches($cantidadNoches);
        $nuevoPaquete->setTransporteIncluido($transporteIncluido);
        $nuevoPaquete->setGuiaTuristico($guiaTuristico);
        $nuevoPaquete->setActividades($actividadesEscogidas);
        $nuevoPaquete->setSeguroDeViaje($seguroViaje);

        $objRegistros = new stdClass();
        $objRegistros->nombre = $nuevoPaquete->getNombre($actividades);
        $objRegistros->precio = $nuevoPaquete->getPrecio($actividades);
        $objRegistros->incluyeDesayuno = $nuevoPaquete->getIncluyeDesayuno($actividades);
        $objRegistros->cantidadNoches = $nuevoPaquete->getCantidadNoches($actividades);
        $objRegistros->transporteIncluido = $nuevoPaquete->getTransporteIncluido($actividades);
        $objRegistros->guiaTuristico = $nuevoPaquete->getGuiaTuristico($actividades);
        $objRegistros->actividades = $nuevoPaquete->getActividades($actividades);
        $objRegistros->seguroDeViaje = $nuevoPaquete->getSeguroDeViaje($actividades);
        $_SESSION['paquetesSP'][] = $objRegistros;

        echo json_encode(['data' => $_SESSION['paquetesSP']]);
        break;

    case CONSULTAR:
//        session_start();
//        session_unset();
//        session_destroy();
        $datos = array();
        if (isset($_SESSION['paquetes'])) {
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
        }

        if (isset($_SESSION['paquetesSP'])) {
            foreach ($_SESSION['paquetesSP'] as $value) {
                $obj2 = new stdClass();
                $obj2->nombre = $value->nombre;
                $obj2->precio = "$" . number_format($value->precio, 2);
                $obj2->incluyeDesayuno = $value->incluyeDesayuno;
                $obj2->cantidadNoches = $value->cantidadNoches;
                $obj2->transporteIncluido = $value->transporteIncluido;
                $obj2->guiaTuristico = $value->guiaTuristico;
                $obj2->actividades = array_values($value->actividades);
                $obj2->seguroDeViaje = $value->seguroDeViaje;
                $datos[] = $obj2;
            }
        }
        echo json_encode(['data' => $datos]);
        break;

    default:
        echo "Acción no válida.";
        break;
}
?>