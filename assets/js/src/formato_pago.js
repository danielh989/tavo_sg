/**
 * Formato de los inputs en el modal de pago
 *
 */
function formatoPago() {
    var efectivo = $('#efectivo');
    var debito = $('#debito');
    var total = $('#total_form').data('total');
    //Porcentaje del descuento
    var porc_des = $('#porc_des').data('descuento');


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


    $('#descuento').change(function() {
        if (this.checked) {
            total = parseFloat(total) - (parseFloat(total) * (parseFloat(porc_des) / 100));
            total = RoundToDecimal(total, 2);
            total_text = total.toString().split('.');
            $('#total_0').text(total_text[0]);
            $('#total_1').text('.' + total_text[1]);
            debito.val('0.00');
            efectivo.val('0.00');
            maskFields();
            $('#pay-form input[type="radio"]').prop('checked', false);
        } else {
            total = $('#total_form').data('total');
            total = RoundToDecimal(total, 2);
            total_text = total.toString().split('.');
            $('#total_0').text(total_text[0]);
            $('#total_1').text('.' + total_text[1]);
            debito.val('0.00');
            efectivo.val('0.00');
            maskFields();
            $('#pay-form input[type="radio"]').prop('checked', false);
        }
    });
    maskFields();
    $("#efectivo").keyup(function() {
        valor = $(this).maskMoney('unmasked')[0];
        valor = RoundToDecimal(valor, 2);
        if (valor > total) {
            $(this).val(total);
            valor = total;
        }
        var resto = total - valor;
        debito.val(RoundToDecimal(resto, 2));
        maskFields();
        $('#pay-form input[type="radio"]').prop('checked', false);
    });
    $("#debito").keyup(function() {
        valor = $(this).maskMoney('unmasked')[0];
        valor = RoundToDecimal(valor, 2);
        if (valor > total) {
            $(this).val(total);
            valor = total;
        }
        var resto = total - valor;
        efectivo.val(RoundToDecimal(resto, 2));
        maskFields();
        $('#pay-form input[type="radio"]').prop('checked', false);
    });
    $("#pay-form").submit(function(e) {
        var self = this;
        e.preventDefault();
        efectivo.val(efectivo.maskMoney('unmasked')[0]);
        debito.val(debito.maskMoney('unmasked')[0]);
        pago = parseFloat(efectivo.val()) + parseFloat(debito.val());
        pago = RoundToDecimal(pago, 2);
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
                efectivo.val(RoundToDecimal(total, 2));
                debito.val('0.00');
                efectivo.trigger("focus");
                debito.trigger("focus");
                btn.trigger("focus");
                maskFields();
                break;
            case 'debito':
                debito.val(RoundToDecimal(total, 2));
                efectivo.val('0.00');
                debito.trigger("focus");
                efectivo.trigger("focus");
                btn.trigger("focus");
                maskFields();
                break;
        }
    });
}
//Esta funcion es para que JavaScript redondee igual que php y los numeros coincidan
//Por defecto JavaScript redondea hacia abajo y PHP hacia arriba cuando existe un .5
function RoundToDecimal(number, decimal) {
    var zeros = new String(1.0.toFixed(decimal));
    zeros = zeros.substr(2);
    var mul_div = parseInt("1" + zeros);
    var increment = parseFloat("." + zeros + "01");
    if (((number * (mul_div * 10)) % 10) >= 5) {
        number += increment;
    }
    return (Math.round(number * mul_div) / mul_div).toFixed(decimal);
}