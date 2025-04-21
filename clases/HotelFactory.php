<?php

// Fábrica abstracta
interface HotelFactory {
    public function crearReserva(): Reserva;
    public function crearServicio(): Servicio;
    public function crearPago(): Pago;
}

?>