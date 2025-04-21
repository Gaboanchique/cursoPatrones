<?php

/**
 * Description of PaqueteTuristicoSP
 *
 * @author gabriel.anchique
 */
class PaqueteTuristicoSP {

    private $nombre;
    private $precio;
    private $incluyeDesayuno;
    private $cantidadNoches;
    private $transporteIncluido;
    private $guiaTuristico;
    private $actividades = [];
    private $seguroDeViaje;
    private $actividadesObligatorias = [];

    public function __construct() {
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function getIncluyeDesayuno() {
        return $this->incluyeDesayuno;
    }

    public function setIncluyeDesayuno($incluyeDesayuno) {
        $this->incluyeDesayuno = $incluyeDesayuno;
    }

    public function getCantidadNoches() {
        return $this->cantidadNoches;
    }

    public function setCantidadNoches($cantidadNoches) {
        $this->cantidadNoches = $cantidadNoches;
    }

    public function getTransporteIncluido() {
        return $this->transporteIncluido;
    }

    public function setTransporteIncluido($transporteIncluido) {
        $this->transporteIncluido = $transporteIncluido;
    }

    public function getGuiaTuristico() {
        return $this->guiaTuristico;
    }

    public function setGuiaTuristico($guiaTuristico) {
        $this->guiaTuristico = $guiaTuristico;
    }

    public function getActividades() {
        return $this->actividades;
    }

    public function setActividades($actividades) {
        $this->actividades =array_unique(array_merge($this->actividadesObligatorias, $actividades));
    }

    public function getSeguroDeViaje() {
        return $this->seguroDeViaje;
    }

    public function setSeguroDeViaje($seguroDeViaje) {
        $this->seguroDeViaje = $seguroDeViaje;
    }

    public function getActividadesObligatorias() {
        return $this->actividadesObligatorias;
    }

    public function setActividadesObligatorias($actividadesObligatorias) {
        $this->actividadesObligatorias = $actividadesObligatorias;
    }
    
}