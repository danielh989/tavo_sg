/**
* Formato de los inputs en el moal de pago
*
*/
function formatoPagos(){
	$('#efectivo, #debito').priceFormat({
    prefix: 'Bs.F ',
    centsSeparator: ',',
    thousandsSeparator: '.'
	});

	$('input[type=radio]').on('click', function(){
		var sel = $(this).attr('value'),
				total = $(this).data('total'),
				efectivo = $('#efectivo'),
				debito = $('#debito'),
				btn = $('.modal-footer button[type=submit]');

		switch (sel){
			case 'efectivo': efectivo.val(total+'');
											 debito.val('0');
											 efectivo.trigger("focus");
											 debito.trigger("focus");
											 btn.trigger("focus");
											 break;
			case 'debito': debito.val(total+'');
										 efectivo.val('0');
										 debito.trigger("focus");
										 efectivo.trigger("focus");
										 btn.trigger("focus");
										 break;
		}
	});
}