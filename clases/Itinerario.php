<?php

// Clase que representa un itinerario turístico
class Itinerario {
    private $tipo;
    private $actividades;
    private $duracion;
    private $descripcion;
    private $hora_salida;
    private $hora_llegada;
    private $punto_encuentro;
    private $desayuno;
    private $almuerzo;

    public function __construct($tipo, $actividades, $duracion, $descripcion, $hora_salida, $hora_llegada, $punto_encuentro, $desayuno, $almuerzo) {
        $this->tipo = $tipo;
        $this->actividades = $actividades;
        $this->duracion = $duracion;
        $this->descripcion = $descripcion;
        $this->hora_salida = $hora_salida;
        $this->hora_llegada = $hora_llegada;
        $this->punto_encuentro = $punto_encuentro;
        $this->desayuno = $desayuno;
        $this->almuerzo = $almuerzo;
    }

    public function toArray() {
        return [
            'tipo' => $this->tipo,
            'actividades' => array_map(fn($actividad) => $actividad->toArray(), $this->actividades),
            'duracion' => $this->duracion,
            'descripcion' => $this->descripcion,
            'hora_salida' => $this->hora_salida,
            'hora_llegada' => $this->hora_llegada,
            'punto_encuentro' => $this->punto_encuentro,
            'desayuno' => $this->desayuno,
            'almuerzo' => $this->almuerzo
        ];
    }
}
?>