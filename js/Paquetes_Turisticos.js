const REGISTRARSP = 99;
const REGISTRAR = 100;
const CONSULTAR = 101;

function spinner(activar) {
    if (activar) {
        $('.spinner').removeClass("hidden");
    } else {
        $('.spinner').addClass("hidden");
    }
}

$(document).ready(function () {
    consultar();
    $("#agregar").on("click", function () {
        limpiarModal();
        $("#modalPaquete").modal("show");
    });
    $("#cerrar").on("click", function () {
        $("#modalPaquete").modal("hide");
    });
    $("#registrar").on("click", function () {
        registrarDatos();
    });
    $("#registrarSp").on("click", function () {
        registrarDatosSP();
    });

    $('#confirmarDatos').on('click', function () {
        var confirmar = confirm('¿Está seguro de realizar la reserva? Esta acción es irreversible.');
        if (confirmar) {
            registrarDatos();
        }
    });
});

function registrarDatos() {
    var nombre = $('#nombre').val();
    var incluyeDesayuno = $('#incluyeDesayuno').is(':checked');
    var cantidadNoches = $('#cantidadNoches').val();
    var transporteIncluido = $('#transporteIncluido').is(':checked');
    var guiaTuristico = $('#guiaTuristico').is(':checked');
    var select = document.getElementById('actividades');
    var actividadesSeleccionadas = Array.from(select.selectedOptions).map(option => parseInt(option.value));
    console.log(actividadesSeleccionadas);

    var seguroViaje = $('#seguroViaje').is(':checked');

    let datos = {
        nombre: nombre,
        incluyeDesayuno: incluyeDesayuno,
        cantidadNoches: cantidadNoches,
        transporteIncluido: transporteIncluido,
        guiaTuristico: guiaTuristico,
        actividades: JSON.stringify(actividadesSeleccionadas),
        seguroViaje: seguroViaje
    };

    spinner("cargando...");
    $.ajax({
        url: 'php/Paquetes_Turisticos.php',
        method: 'POST',
        dataType: 'html',
        data: {accion: REGISTRAR, datos: JSON.stringify(datos)},
        success: function (data) {
            spinner(false);
            consultar();
            alert('Se ha registrado exitosamente.');
            $("#modalPaquete").modal("hide");
        },
        error: function (xhr, status, error) {
            console.log('Error: ' + error);
            alert('Hubo un problema al registrar. Intente de nuevo más tarde.');
        }
    });
}
function registrarDatosSP() {
    var nombre = $('#nombre').val();
    var incluyeDesayuno = $('#incluyeDesayuno').is(':checked');
    var cantidadNoches = $('#cantidadNoches').val();
    var transporteIncluido = $('#transporteIncluido').is(':checked');
    var guiaTuristico = $('#guiaTuristico').is(':checked');
    var select = document.getElementById('actividades');
    var actividadesSeleccionadas = Array.from(select.selectedOptions).map(option => parseInt(option.value));
    console.log(actividadesSeleccionadas);

    var seguroViaje = $('#seguroViaje').is(':checked');

    let datos = {
        nombre: nombre,
        incluyeDesayuno: incluyeDesayuno,
        cantidadNoches: cantidadNoches,
        transporteIncluido: transporteIncluido,
        guiaTuristico: guiaTuristico,
        actividades: JSON.stringify(actividadesSeleccionadas),
        seguroViaje: seguroViaje
    };

    spinner("cargando...");
    setTimeout(function () {
        $.ajax({
            url: 'php/Paquetes_Turisticos.php',
            method: 'POST',
            dataType: 'html',
            data: {accion: REGISTRARSP, datos: JSON.stringify(datos)},
            success: function (data) {
                spinner(false);
                consultar();
                alert('Se ha registrado exitosamente.');
                $("#modalPaquete").modal("hide");
            },
            error: function (xhr, status, error) {
                console.log('Error: ' + error);
                alert('Hubo un problema al registrar. Intente de nuevo más tarde.');
            }
        });
    }, 1000);
}

function consultar() {
    $('#tablaPaquetes').empty();
    spinner("cargando...");
    $.ajax({
        url: 'php/Paquetes_Turisticos.php',
        method: 'POST',
        dataType: 'html',
        data: {accion: CONSULTAR},
        success: function (data) {
            spinner(false);
            var data = JSON.parse(data).data;
            $(data).each(function (index, obj) {
                var row = $('<tr>');
                row.append($('<td>').text(obj.nombre));
                row.append($('<td>').text(obj.precio));
                row.append($('<td>').text(obj.incluyeDesayuno));
                row.append($('<td>').text(obj.cantidadNoches));
                row.append($('<td>').text(obj.transporteIncluido));
                row.append($('<td>').text(obj.guiaTuristico));
                row.append($('<td>').text(obj.actividades.join(', ')));
                row.append($('<td>').text(obj.seguroDeViaje));
                $('#tablaPaquetes').append(row);
            });
        },
        error: function (xhr, status, error) {
            console.log('Error: ' + error);
            alert('Hubo un problema al consultar. Intente de nuevo más tarde.');
        }
    });
}


function limpiarModal() {
    $('#nombre').val("");
    $('#cantidadNoches').val(0);
    $('#incluyeDesayuno').prop('checked', false).closest('span').removeClass('checked');
    $('#transporteIncluido').prop('checked', false).closest('span').removeClass('checked');
    $('#guiaTuristico').prop('checked', false).closest('span').removeClass('checked');

    // Deseleccionar todas las opciones del <select>
    $('#actividades').val([]);
//    document.getElementById('actividades').selectedIndex = -1;
}