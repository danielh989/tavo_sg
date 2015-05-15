/**
 * Formato de los inputs en el modal de pago
 *
 */
function formatoPago() {
    var efectivo = $('#efectivo');
    var debito = $('#debito');
    var total = $('#total_form').data('total');

    efectivo.maskMoney({
        thousands: '.',
        decimal: ',',
        allowZero: false,
        suffix: ' Bs.F'
    });
    debito.maskMoney({
        thousands: '.',
        decimal: ',',
        allowZero: false,
        suffix: ' Bs.F'
    });

    function maskFields() {
        debito.maskMoney('mask');
        efectivo.maskMoney('mask'); 
    }


    maskFields();

    $("#efectivo").keyup(function() {
        valor = $(this).maskMoney('unmasked')[0];


        if (valor > total) {
            $(this).val(total);
            valor = total;
        }
        var resto = total - valor;


        debito.val(resto.toFixed(2));
        maskFields();
        $('#pay-form input[type="radio"]').prop('checked', false);
    });


    $("#debito").keyup(function() {
        valor = $(this).maskMoney('unmasked')[0];

        if (valor > total) {
            $(this).val(total);
            valor = total;
        }
        var resto = total - valor;
        efectivo.val(resto.toFixed(2));
        maskFields();
        $('#pay-form input[type="radio"]').prop('checked', false);
    });



    $("#pay-form").submit(function(e) {
        var self = this;
        e.preventDefault();
        efectivo.val(efectivo.maskMoney('unmasked')[0]);
        debito.val(debito.maskMoney('unmasked')[0]);
        pago = parseFloat(efectivo.val()) + parseFloat(debito.val());
        console.log(pago);
        if (pago < total) {
            maskFields();
            alert("No se ha completado el pago de la orden");
        } else {
            self.submit();
        }
        return false;
    });


    $('input[type=radio]').on('click', function() {
        var sel = $(this).attr('value'),
            btn = $('.modal-footer button[type=submit]');
        switch (sel) {
            case 'efectivo':
                efectivo.val(total);
                debito.val('0.00');
                efectivo.trigger("focus");
                debito.trigger("focus");
                btn.trigger("focus");
                maskFields();
                break;
            case 'debito':
                debito.val(total);
                efectivo.val('0.00');
                debito.trigger("focus");
                efectivo.trigger("focus");
                btn.trigger("focus");
                maskFields();
                break;
        }
    });
}