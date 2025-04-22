const REGISTRAR_CLIENTE = 101;


function spinner(activar) {
    if (activar) {
        $('.spinner').removeClass("hidden");
    } else {
        $('.spinner').addClass("hidden");
    }
}

$(document).ready(function () {
    $('#phone').change(function () {
        $('#phoneNumber').toggleClass('hidden', !this.checked);
    });
    $('#billing').change(function () {
        $('#billingDetails').toggleClass('hidden', !this.checked);
    });
    $('#lodging').change(function () {
        $('#lodgingDetails').toggleClass('hidden', !this.checked);
    });
    $('#clientType').change(function () {
        $('#membershipDetails').toggleClass('hidden', this.value !== 'premium');
        $('#preferenciasHospedaje').toggleClass('hidden', this.value === 'premium');
        $('#detalleFacturacion').toggleClass('hidden', this.value === 'premium');
    });
    $("#registrar").on("click", function () {
        registrarDatos();
    });

});

function registrarDatos() {
    if ($('#name').val() == "") {
        alert("El campo nombre es obligatorio");
        $('#name').focus();
        return;
    }
    if ($('#email').val() == "") {
        alert("El campo correo es Obligatorio");
        $('#email').focus();
        return;
    }

    const datos = {
        clientType: $('#clientType').val(),
        name: $('#name').val(),
        email: $('#email').val(),
        phone: $('#phone').is(':checked') ? $('#phoneNumber').val() : '',
        sms: $('#sms').is(':checked'),
        emailNotifications: $('#emailNotifications').is(':checked'),
        billing: $('#billing').is(':checked'),
        billingAddress: $('#billingAddress').val(),
        paymentMethod: $('#paymentMethod').val(),
        lodging: $('#lodging').is(':checked'),
        roomType: $('#roomType').val(),
        view: $('#view').val(),
        floor: $('#floor').val(),
        membershipType: $('#membershipType').val()
    };

    spinner("cargando...");
    $.ajax({
        url: 'php/ClienteBuilder.php',
        method: 'POST',
        dataType: 'html',
        data: {accion: REGISTRAR_CLIENTE, datos: JSON.stringify(datos)},
        success: function (data) {
            var data = JSON.parse(data).data;
            $('#result').empty();
            var html = '';
            html += `<p><strong>Nombre:</strong> ${data.nombre}</p>`;
            html += `<p><strong>Correo:</strong> ${data.correo} - ${data.enviaremail ? 'Notificar por correo' : 'No notificar por correo'}</p>`;

            if (data.celular) {
                html += `<p><strong>Celular:</strong> ${data.celular} - ${data.enviarsms ? 'Notificar por SMS' : 'No notificar por SMS'}</p>`;
            }

            if (data.direcionFacturacion) {
                html += `<p><strong>Dirección de Facturación:</strong> ${data.direcionFacturacion}</p>`;
            }

            if (data.metodoPago) {
                html += `<p><strong>Método de Pago:</strong> ${data.metodoPago}</p>`;
            }

            if (data.tipoHabitacion) {
                html += `<p><strong>Tipo de Habitación:</strong> ${data.tipoHabitacion}</p>`;
            }

            if (data.vista) {
                html += `<p><strong>Vista:</strong> ${data.vista}</p>`;
            }

            if (data.piso) {
                html += `<p><strong>Piso:</strong> ${data.piso}</p>`;
            }

            if (data.menbresia) {
                html += `<p><strong>Membresía:</strong> ${data.menbresia}</p>`;
            }

            if (data.menbresiaBeneficios) {
                html += `<p><strong>Beneficios de Membresía:</strong> ${data.menbresiaBeneficios}</p>`;
            }

            $('#result').html(html);
            spinner(false);
            alert('Se ha registrado exitosamente.');
        },
        error: function (xhr, status, error) {
            console.log('Error: ' + error);
            alert('Hubo un problema al obtener detalles. Intente de nuevo más tarde.');
        }
    });
}