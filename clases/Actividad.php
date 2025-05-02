<?php
// Clase que representa una actividad con horario y descripción
class Actividad {
    private $nombre;
    private $hora;
    private $descripcion;

    public function __construct($nombre, $hora, $descripcion) {
        $this->nombre = $nombre;
        $this->hora = $hora;
        $this->descripcion = $descripcion;
    }

    public function toArray() {
        return [
            'nombre' => $this->nombre,
            'hora' => $this->hora,
            'descripcion' => $this->descripcion
        ];
    }
}

?>