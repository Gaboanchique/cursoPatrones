<?php

require_once '../clases/builder.php';
session_start();
CONST REGISTRARSP = 99;
CONST REGISTRAR = 100;
CONST CONSULTAR = 101;

$accion = isset($_POST['accion']) ? $_POST['accion'] : null;
$datos = isset($_POST['datos']) ? $_POST['datos'] : null;
$hayPaquete = isset($_POST['plantilla']) ? true : false;
try {
    if (empty($_POST['name']) || empty($_POST['email'])) {
        throw new Exception('Nombre y correo son obligatorios');
    }

    $data = [
        'clientType' => $_POST['clientType'] ?? 'estandar',
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'] ?? '',
        'sms' => isset($_POST['sms']) && $_POST['sms'] === 'true',
        'emailNotifications' => isset($_POST['emailNotifications']) && $_POST['emailNotifications'] === 'true',
        'billing' => isset($_POST['billing']) && $_POST['billing'] === 'true',
        'billingAddress' => $_POST['billingAddress'] ?? '',
        'paymentMethod' => $_POST['paymentMethod'] ?? '',
        'membershipType' => $_POST['membershipType'] ?? ''
    ];

    // Seleccionar el builder según el tipo de cliente
    $builder = $data['clientType'] === 'premium' ? new PremiumClientBuilder() : new ConcreteClientBuilder();
    $director = new ClientDirector($builder);
    $client = $director->buildClient($data);

    echo json_encode([
        'success' => true,
        'name' => $client->toArray()['name'],
        'email' => $client->toArray()['email'],
        'contact' => $client->toArray()['contact'],
        'billing' => $client->toArray()['billing'],
        'membership' => $client->toArray()['membership']
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>