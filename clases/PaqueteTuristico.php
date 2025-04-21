<?php

/**
 * Description of PaqueteAlojamiento
 *
 * @author gabriel.anchique
 */
class PaqueteTuristico implements Prototype {

    public $nombre;
    public $precio;
    public $incluyeDesayuno;
    public $cantidadNoches;
    public $transporteIncluido;
    public $guiaTuristico;
    public $actividades = [];
    public $seguroDeViaje;
    public $actividadesObligatorias = [];

    private const nombre = "Paquete Basico";
    private const PRECIO_BASE = 100000;
    private const COSTO_DESAYUNO_POR_NOCHE = 10000;
    private const COSTO_TRANSPORTE = 20000;
    private const COSTO_GUIA_TURISTICO = 30000;
    private const COSTO_SEGURO_VIAJE = 40000;
    private const ACTIVIDADES_OBLIGATORIAS = ['Visita cultural al centro historico', 'Recorrido panorámico por lugares emblematicos', 'Almuerzo en un restaurante tipico'];

    private static $costosActividades = [
        "Senderismo" => ['nombre' => 'Senderismo', 'precio' => 10000],
        "Rafting" => ['nombre' => 'Rafting', 'precio' => 20000],
        "Cabalgata" => ['nombre' => 'Cabalgata', 'precio' => 15000],
        "Tour Gastronomico" => ['nombre' => 'Tour Gastronomico', 'precio' => 5000],
        "Parapente" => ['nombre' => 'Parapente', 'precio' => 10000],
        "Visita a Museos" => ['nombre' => 'Visita a Museos', 'precio' => 15000],
        "Nado con Delfines" => ['nombre' => 'Nado con Delfines', 'precio' => 90000],
        "Escalada" => ['nombre' => 'Escalada', 'precio' => 40000],
    ];

    public function __construct($incluyeDesayuno, $cantidadNoches, $transporteIncluido, $guiaTuristico, $seguroDeViaje, $actividades) {
        $this->nombre = self::nombre;
        $this->incluyeDesayuno = $incluyeDesayuno;
        $this->cantidadNoches = $cantidadNoches;
        $this->transporteIncluido = $transporteIncluido;
        $this->guiaTuristico = $guiaTuristico;
        $this->seguroDeViaje = $seguroDeViaje;
        $this->actividadesObligatorias = self::ACTIVIDADES_OBLIGATORIAS;
        $this->actividades = $actividades;
        $this->precio = $this->calcularPrecio();
    }

    public function clonar() {
        return clone $this;
    }

    private function calcularPrecio(): int {
        $precio = self::PRECIO_BASE;

        if ($this->incluyeDesayuno === 'Si') {
            $precio += self::COSTO_DESAYUNO_POR_NOCHE * $this->cantidadNoches;
        }

        if ($this->transporteIncluido === 'Si') {
            $precio += self::COSTO_TRANSPORTE;
        }

        if ($this->guiaTuristico === 'Si') {
            $precio += self::COSTO_GUIA_TURISTICO;
        }
        if ($this->seguroDeViaje === 'Si') {
            $precio += self::COSTO_SEGURO_VIAJE;
        }

        // Costos de actividades
        foreach ($this->actividades as $actividadId) {
            if (isset(self::$costosActividades[$actividadId])) {
                $precio += self::$costosActividades[$actividadId]['precio'];
            }
        }
        return $precio;
    }
}
