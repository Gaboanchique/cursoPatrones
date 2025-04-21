<?php
// Objeto final: Cliente
class Cliente {
    public $name;
    public $email;
    public $phone;
    public $sms;
    public $emailNotifications;
    public $billingAddress;
    public $paymentMethod;
    public $membershipType;
    public $membershipBenefits;

    public function toArray(): array {
        $contact = [];
        if ($this->phone) $contact[] = "Teléfono: $this->phone";
        if ($this->sms) $contact[] = "Notificaciones por SMS";
        if ($this->emailNotifications) $contact[] = "Notificaciones por correo";
        $contactStr = $contact ? implode(", ", $contact) : "Sin preferencias de contacto";

        $billing = ($this->billingAddress && $this->paymentMethod) 
            ? "Dirección: $this->billingAddress, Método: $this->paymentMethod"
            : "Sin detalles de facturación";

        $membership = ($this->membershipType && $this->membershipBenefits)
            ? "Tipo: $this->membershipType, Beneficios: $this->membershipBenefits"
            : "Sin membresía";

        return [
            'name' => $this->name,
            'email' => $this->email,
            'contact' => $contactStr,
            'billing' => $billing,
            'membership' => $membership
        ];
    }
}

// Interfaz Builder
interface ClientBuilder {
    public function setPersonalInfo(string $name, string $email): void;
    public function setContactPreferences(?string $phone, bool $sms, bool $emailNotifications): void;
    public function setBillingDetails(?string $billingAddress, ?string $paymentMethod): void;
    public function setMembership(?string $membershipType): void;
    public function getClient(): Cliente;
}

// Builder para cliente estándar
class ConcreteClientBuilder implements ClientBuilder {
    private $client;

    public function __construct() {
        $this->client = new Cliente();
    }

    public function setPersonalInfo(string $name, string $email): void {
        $this->client->name = $name;
        $this->client->email = $email;
    }

    public function setContactPreferences(?string $phone, bool $sms, bool $emailNotifications): void {
        $this->client->phone = $phone;
        $this->client->sms = $sms;
        $this->client->emailNotifications = $emailNotifications;
    }

    public function setBillingDetails(?string $billingAddress, ?string $paymentMethod): void {
        $this->client->billingAddress = $billingAddress;
        $this->client->paymentMethod = $paymentMethod;
    }

    public function setMembership(?string $membershipType): void {
        // Clientes estándar no tienen membresía
        $this->client->membershipType = null;
        $this->client->membershipBenefits = null;
    }

    public function getClient(): Cliente {
        return $this->client;
    }
}

// Builder para cliente premium
class PremiumClientBuilder implements ClientBuilder {
    private $client;

    public function __construct() {
        $this->client = new Cliente();
    }

    public function setPersonalInfo(string $name, string $email): void {
        $this->client->name = $name;
        $this->client->email = $email;
    }

    public function setContactPreferences(?string $phone, bool $sms, bool $emailNotifications): void {
        $this->client->phone = $phone;
        $this->client->sms = $sms;
        $this->client->emailNotifications = $emailNotifications;
    }

    public function setBillingDetails(?string $billingAddress, ?string $paymentMethod): void {
        $this->client->billingAddress = $billingAddress ? $billingAddress : "Dirección prioritaria para clientes premium";
        $this->client->paymentMethod = $paymentMethod ? $paymentMethod : "Tarjeta (prioridad premium)";
    }

    public function setMembership(?string $membershipType): void {
        $this->client->membershipType = $membershipType;
        $this->client->membershipBenefits = $membershipType === 'gold' 
            ? "Acceso a lounge, descuentos del 10%" 
            : "Acceso VIP, descuentos del 20%, check-in prioritario";
    }

    public function getClient(): Cliente {
        return $this->client;
    }
}

// Director
class ClientDirector {
    private $builder;

    public function __construct(ClientBuilder $builder) {
        $this->builder = $builder;
    }

    public function buildClient(array $data): Cliente {
        // Paso 1: Información personal (obligatorio)
        $this->builder->setPersonalInfo($data['name'], $data['email']);

        // Paso 2: Preferencias de contacto (opcional)
        $this->builder->setContactPreferences(
            !empty($data['phone']) ? $data['phone'] : null,
            $data['sms'] ?? false,
            $data['emailNotifications'] ?? false
        );

        // Paso 3: Detalles de facturación (opcional)
        if ($data['billing'] && !empty($data['billingAddress']) && !empty($data['paymentMethod'])) {
            $this->builder->setBillingDetails($data['billingAddress'], $data['paymentMethod']);
        } else {
            $this->builder->setBillingDetails(null, null);
        }

        // Paso 4: Membresía (solo para premium)
        $this->builder->setMembership($data['membershipType'] ?? null);

        return $this->builder->getClient();
    }
}
?>