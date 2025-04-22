<?php
interface ClientBuilder {
    public function setPersonalInfo(string $name, string $email): void;
    public function setContactPreferences(?string $phone, bool $sms, bool $emailNotifications): void;
    public function setBillingDetails(?string $billingAddress, ?string $paymentMethod): void;
    public function setLodgingPreferences(?string $roomType, ?string $view, ?string $floor): void;
    public function setMembership(?string $membershipType): void;
    public function getClient(): Cliente;
}
