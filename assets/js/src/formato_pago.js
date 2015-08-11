/**
 * Formato de los inputs en el modal de pago
 *
 */
function formatoPago() {
    var total = null;

    function maskFields(debito, efectivo) {
        debito.maskMoney('mask');
        efectivo.maskMoney('mask');
    }

    $(document).on('change', '#descuento', function() {
            total = $('#total_form').data('total');
            efectivo = $('#efectivo');
            debito = $('#debito');
            porc_des = $('#porc_des').data('descuento');

        if (this.checked) {
            total = parseFloat(total) - (parseFloat(total) * (parseFloat(porc_des) / 100));
            total = RoundToDecimal(total, 2);
            total_text = total.toString().split('.');
            $('#total_0').text(total_text[0]);
            $('#total_1').text('.' + total_text[1]);
            debito.val('0.00');
            efectivo.val('0.00');
            maskFields(debito, efectivo);
            $('input[type="radio"]').prop('checked', false);
        } else {
            total = $('#total_form').data('total');
            total = RoundToDecimal(total, 2);
            total_text = total.toString().split('.');
            $('#total_0').text(total_text[0]);
            $('#total_1').text('.' + total_text[1]);
            debito.val('0.00');
            efectivo.val('0.00');
            maskFields(debito, efectivo);
            $('input[type="radio"]').prop('checked', false);
        }
    });

    $(document).on('keyup', "#efectivo", function() {
        var efectivo = $('#efectivo'),
            debito = $('#debito');
            total = (total == null) ? total = $('#total_form').data('total') : total = total;

        efectivo.maskMoney({
            thousands: '.',
            decimal: ',',
            allowZero: false,
            suffix: ' Bs.F'
        });

        efectivo.maskMoney('mask');

        valor = $(this).maskMoney('unmasked')[0];
        valor = RoundToDecimal(valor, 2);
        if (parseFloat(valor) > parseFloat(total)) {
            $(this).val(total);
            valor = total;
        }
        var resto = total - valor;
        debito.val(RoundToDecimal(resto, 2));
      

        maskFields(debito, efectivo);
        $('#pay-form input[type="radio"]').prop('checked', false);
    });

    $(document).on('keyup', '#debito', function() {
        var efectivo = $('#efectivo'),
            debito = $('#debito'),
            total = $('#total_form').data('total');

        debito.maskMoney({
            thousands: '.',
            decimal: ',',
            allowZero: false,
            suffix: ' Bs.F'
        });

        debito.maskMoney('mask');

        valor = $(this).maskMoney('unmasked')[0];
        valor = RoundToDecimal(valor, 2);
        if (parseFloat(valor) > parseFloat(total)) {
            $(this).val(total);
            valor = total;
        }
        var resto = parseFloat(total) - parseFloat(valor);
        efectivo.val(RoundToDecimal(resto, 2));

        maskFields(debito, efectivo);
        $('#pay-form input[type="radio"]').prop('checked', false);
    });

    $(document).on('submit', "#pay-form", function(event) {
        var self = $(this),
            efectivo = $('#efectivo'),
            debito = $('#debito');
            total = (total == null) ? total = $('#total_form').data('total') : total = total;

        pago = parseFloat(efectivo.maskMoney('unmasked')[0])
             + parseFloat(debito.maskMoney('unmasked')[0]);
        pago = RoundToDecimal(pago, 2);
        if (parseFloat(pago) < parseFloat(total)) {
            maskFields(debito, efectivo);
            alert("No se ha completado el pago de la orden");
        } else {
            self.submit();
        }
        return false;
    });

    $(document).on('click', 'input[type=radio]',function() {
        var sel = $(this).attr('value'),
            btn = $('.modal-footer button[type=submit]'),
            efectivo = $('#efectivo'),
            debito = $('#debito');
            total = (total == null) ? total = $('#total_form').data('total') : total = total;

        switch (sel) {
            case 'efectivo':
                efectivo.val(RoundToDecimal(total, 2));
                debito.val('0.00');
                efectivo.trigger("focus");
                debito.trigger("focus");
                btn.trigger("focus");
                maskFields(debito, efectivo);
                break;
            case 'debito':
                debito.val(RoundToDecimal(total, 2));
                efectivo.val('0.00');
                debito.trigger("focus");
                efectivo.trigger("focus");
                btn.trigger("focus");
                maskFields(debito, efectivo);
                break;
        }
    });
}
//Esta funcion es para que JavaScript redondee igual que php y los numeros coincidan
//Por defecto JavaScript redondea hacia abajo y PHP hacia arriba cuando existe un .5

//OJO: Devuelve un String

function RoundToDecimal(number, decimal) {
    var zeros = new String(1.0.toFixed(decimal));
    zeros = zeros.substr(2);
    var mul_div = parseFloat("1" + zeros);
    var increment = parseFloat("." + zeros + "01");
    if (((number * (mul_div * 10)) % 10) >= 5) {
        number += increment;
    }
    return (Math.round(number * mul_div) / mul_div).toFixed(decimal);
}