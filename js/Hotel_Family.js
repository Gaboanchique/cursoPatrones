const CREAR_HOTELES_ABSTRACT = 102;


function spinner(activar) {
    if (activar) {
        $('.spinner').removeClass("hidden");
    } else {
        $('.spinner').addClass("hidden");
    }
}

$(document).ready(function () {
    $("#obtenerDetalles").on("click", function () {
        registrarDatos();
    });

});

function registrarDatos() {
    var tipoHotel = $('#hotelType').val();
    if (tipoHotel != 0) {
        let datos = {
            tipoHotel: tipoHotel
        };

        spinner("cargando...");
        $.ajax({
            url: 'php/HotelesAbstractFactory.php',
            method: 'POST',
            dataType: 'html',
            data: {accion: CREAR_HOTELES_ABSTRACT, datos: JSON.stringify(datos)},
            success: function (data) {
                $('#tablaRegistros').empty();
                spinner(false);
                alert('Se ha obtenido un resultado exitoso.');
                var data = JSON.parse(data).data;
                var nombre = data.nombre;
                var reserva = data.reserva;
                var servicio = data.servicio;
                var pago = data.pago;
                $(data).each(function (index, obj) {
                    var row = $('<tr>');
                    row.append($('<td>').text(nombre));
                    row.append($('<td>').text(reserva));
                    row.append($('<td>').text(servicio));
                    row.append($('<td>').text(pago));
                    $('#tablaRegistros').append(row);
                });
            },
            error: function (xhr, status, error) {
                console.log('Error: ' + error);
                alert('Hubo un problema al obtener detalles. Intente de nuevo más tarde.');
            }
        });
    } else {
        alert("por favor seleccione un tipo de hotel");
    }
}