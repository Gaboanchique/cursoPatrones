<?php

require_once '../clases/ClientBuilder.php';
require_once '../clases/Cliente.php';
session_start();
CONST REGISTRAR_CLIENTE = 101;

$accion = isset($_POST['accion']) ? $_POST['accion'] : null;
$datos = isset($_POST['datos']) ? $_POST['datos'] : null;

switch ($accion) {
    case REGISTRAR_CLIENTE:
        $datos = json_decode($datos);
        $clientType = $datos->clientType ?? 'estandar';
        $name = $datos->name;
        $email = $datos->email;
        $phone = $datos->phone ?? '';
        $sms = isset($datos->sms) && $datos->sms;
        $emailNotifications = isset($datos->emailNotifications) && $datos->emailNotifications;
        $billing = isset($datos->billing) && $datos->billing;
        $billingAddress = $datos->billingAddress ?? '';
        $paymentMethod = $datos->paymentMethod ?? '';
        $lodging = isset($datos->lodging) && $datos->lodging;
        $roomType = $datos->roomType ?? '';
        $view = $datos->view ?? '';
        $floor = $datos->floor ?? '';
        $membershipType = $datos->membershipType ?? '';

        $data = [
            'clientType' => $clientType,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'sms' => $sms,
            'emailNotifications' => $emailNotifications,
            'billing' => $billing,
            'billingAddress' => $billingAddress,
            'paymentMethod' => $paymentMethod,
            'lodging' => $lodging,
            'roomType' => $roomType,
            'view' => $view,
            'floor' => $floor,
            'membershipType' => $membershipType
        ];

        // Seleccionar el builder según el tipo de cliente
        $builder = $data['clientType'] === 'premium' ? new PremiumClientBuilder() : new ConcreteClientBuilder();
        $director = new ClientDirector($builder);
        $client = $director->buildClient($data);

        $obj = new stdClass();
        $obj->nombre = $client->name;
        $obj->correo = $client->email;
        $obj->celular = !isset($client->phone) ? "" : $client->phone;
        $obj->enviarsms = $client->sms;
        $obj->enviaremail = $client->emailNotifications;
        $obj->direcionFacturacion = !isset($client->billingAddress) ? "" : $client->billingAddress;
        $obj->metodoPago = !isset($client->paymentMethod) ? "" : $client->paymentMethod;
        $obj->tipoHabitacion = !isset($client->roomType) ? "" : $client->roomType;
        $obj->vista = !isset($client->view) ? "" : $client->view;
        $obj->piso = !isset($client->floor) ? "" : $client->floor;
        $obj->menbresia = !isset($client->membershipType) ? "" : $client->membershipType;
        $obj->menbresiaBeneficios = !isset($client->membershipBenefits) ? "" : $client->membershipBenefits;

        echo json_encode(['success' => true, 'data' => $obj]);

        break;

    default:
        echo "Acción no válida.";
        break;
}
?>