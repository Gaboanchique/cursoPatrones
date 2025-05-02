<?php

// Interfaz para las fábricas de itinerarios
interface FabricaItinerario {
    public function crearItinerario($parametros): Itinerario;
}
?>