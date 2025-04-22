<?php
// Productos abstractos
interface Reserva {
    public function detalles(): string;
}

interface Servicio {
    public function descripcion(): string;
}

interface Pago {
    public function procesar(): string;
}

// Productos concretos para hotel económico
class ReservaEconomica implements Reserva {
    public function detalles(): string {
        return "Habitación estándar, cama sencilla";
    }
}

class ServicioEconomico implements Servicio {
    public function descripcion(): string {
        return "Servicio básico desayuno incluido";
    }
}

class PagoEfectivo implements Pago {
    public function procesar(): string {
        return "Pago procesado en efectivo";
    }
}

// Productos concretos para hotel de lujo
class ReservaLujo implements Reserva {
    public function detalles(): string {
        return "Suite con vista al mar, cama Queen";
    }
}

class ServicioLujo implements Servicio {
    public function descripcion(): string {
        return "Servicio premium spa y cena gourmet";
    }
}

class PagoTarjeta implements Pago {
    public function procesar(): string {
        return "Pago procesado con tarjeta de crédito";
    }
}

// Fábricas concretas
class EconomicoFactory implements HotelFactory {
    public function crearReserva(): Reserva {
        return new ReservaEconomica();
    }

    public function crearServicio(): Servicio {
        return new ServicioEconomico();
    }

    public function crearPago(): Pago {
        return new PagoEfectivo();
    }
}

class LujoFactory implements HotelFactory {
    public function crearReserva(): Reserva {
        return new ReservaLujo();
    }

    public function crearServicio(): Servicio {
        return new ServicioLujo();
    }

    public function crearPago(): Pago {
        return new PagoTarjeta();
    }
}
?>