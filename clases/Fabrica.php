<?php

// Fábrica concreta para itinerarios culturales
class FabricaItinerarioCultural implements FabricaItinerario {
    public function crearItinerario($parametros): Itinerario {
        $destino = $parametros['destino'];
        $hora_salida = $parametros['hora_salida'];
        $duracion = $parametros['duracion'];
        $punto_encuentro = $parametros['punto_encuentro'];
        $desayuno = $parametros['desayuno'];
        $almuerzo = $parametros['almuerzo'];

        // Calcular hora de llegada (aproximada, 8 horas después de la salida)
        $hora_llegada = date('H:i', strtotime($hora_salida . ' +8 hours'));

        // Generar actividades con horarios dinámicos
        $actividades = [
            new Actividad("Visita a museos", $hora_salida, "Explora museos destacados en $destino con un guía."),
            new Actividad("Recorrido histórico", date('H:i', strtotime($hora_salida . ' +2 hours')), "Camina por sitios históricos de $destino."),
            new Actividad("Taller cultural", date('H:i', strtotime($hora_salida . ' +5 hours')), "Participa en un taller de tradiciones locales.")
        ];

        return new Itinerario(
            'Cultural',
            $actividades,
            "$duracion días",
            "Descubre la riqueza cultural de $destino con un itinerario personalizado.",
            $hora_salida,
            $hora_llegada,
            $punto_encuentro,
            $desayuno,
            $almuerzo
        );
    }
}

// Fábrica concreta para itinerarios de aventura
class FabricaItinerarioAventura implements FabricaItinerario {
    public function crearItinerario($parametros): Itinerario {
        $destino = $parametros['destino'];
        $hora_salida = $parametros['hora_salida'];
        $duracion = $parametros['duracion'];
        $punto_encuentro = $parametros['punto_encuentro'];
        $desayuno = $parametros['desayuno'];
        $almuerzo = $parametros['almuerzo'];

        // Calcular hora de llegada (10 horas después de la salida)
        $hora_llegada = date('H:i', strtotime($hora_salida . ' +10 hours'));

        // Generar actividades con horarios dinámicos
        $actividades = [
            new Actividad("Senderismo", $hora_salida, "Explora senderos naturales en $destino."),
            new Actividad("Actividad extrema", date('H:i', strtotime($hora_salida . ' +3 hours')), "Vive una aventura como rafting o escalada."),
            new Actividad("Campamento", date('H:i', strtotime($hora_salida . ' +7 hours')), "Disfruta de una noche al aire libre.")
        ];

        return new Itinerario(
            'Aventura',
            $actividades,
            "$duracion días",
            "Vive una experiencia llena de adrenalina en $destino.",
            $hora_salida,
            $hora_llegada,
            $punto_encuentro,
            $desayuno,
            $almuerzo
        );
    }
}

// Fábrica concreta para itinerarios gastronómicos
class FabricaItinerarioGastronomico implements FabricaItinerario {
    public function crearItinerario($parametros): Itinerario {
        $destino = $parametros['destino'];
        $hora_salida = $parametros['hora_salida'];
        $duracion = $parametros['duracion'];
        $punto_encuentro = $parametros['punto_encuentro'];
        $desayuno = $parametros['desayuno'];
        $almuerzo = $parametros['almuerzo'];

        // Calcular hora de llegada (6 horas después de la salida)
        $hora_llegada = date('H:i', strtotime($hora_salida . ' +6 hours'));

        // Generar actividades con horarios dinámicos
        $actividades = [
            new Actividad("Clase de cocina", $hora_salida, "Aprende a cocinar platos típicos de $destino."),
            new Actividad("Tour por mercados", date('H:i', strtotime($hora_salida . ' +2 hours')), "Visita mercados locales para conocer ingredientes frescos."),
            new Actividad("Cena gourmet", date('H:i', strtotime($hora_salida . ' +4 hours')), "Disfruta de una cena en un restaurante destacado.")
        ];

        return new Itinerario(
            'Gastronómico',
            $actividades,
            "$duracion días",
            "Explora los sabores únicos de $destino con un itinerario culinario.",
            $hora_salida,
            $hora_llegada,
            $punto_encuentro,
            $desayuno,
            $almuerzo
        );
    }
}

// Clase para manejar la solicitud del itinerario
class CreadorItinerario {
    public static function obtenerItinerario($parametros): Itinerario {
        $fabrica = self::obtenerFabrica($parametros['tipo']);
        return $fabrica->crearItinerario($parametros);
    }

    private static function obtenerFabrica($tipo): FabricaItinerario {
        switch (strtolower($tipo)) {
            case 'cultural':
                return new FabricaItinerarioCultural();
            case 'aventura':
                return new FabricaItinerarioAventura();
            case 'gastronomico':
                return new FabricaItinerarioGastronomico();
            default:
                throw new Exception("Tipo de itinerario no válido");
        }
    }
}
?>