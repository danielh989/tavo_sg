$(function(){

	var ejemplo = {
		"mesas": [
			{"id":"1"}
		],
		"productos": [
			{"id":"2", "cant":"1"}
		]
	}

	$.each(ejemplo.productos, function(index, value){
		ejemplo.productos[index].cant = parseInt(ejemplo.productos[index].cant) + 1;
		console.log(ejemplo.productos[index].cant);
	});

	mesasDisponibles();

});

function mesasDisponibles(){

	var pedido = {
		"mesa": [],
		"productos": []
	};

	// Funcion para traer las mesas disponibles
	$('.table-add').on('click', function(){
		var that = $(this),
				url  = 'index.php/main/getMesas',
				type = 'get',
				data = {};

		$.ajax({
			url: url,
			type: type,
			data: data,
			success: function(response){
				json = jQuery.parseJSON(response);
				var template = $('#select-table').html();
				$('.modal-body').html("");
				$.each(json, function(index, value){
					$('.modal-body').append(Mustache.render(template, json[index]));
				});
			}
		});
	});

	// Funcion para traer categorias
	$('.modal-body').on('click', '.mesa-libre',function(){
		var that = $(this),
				url = 'index.php/main/getCategorias',
				type = 'post',
				data = {};

				// Guardando el ID de la mesa seleccionada
				pedido.mesa.push({"id":that.data('id')});

				$.ajax({
					url: url,
					type: type,
					data: data,
					success: function(response){
						var json = jQuery.parseJSON(response),
						 		template = $('#categorias-template').html();

						$('.modal-body').html("");
						$.each(json, function(index, value){
							$('.modal-body').append(Mustache.render(template, json[index]));
						});
					}
				});
	});

	// Funcion para traer los productos de una categoria
	$('.modal-body').on('click', '.categoria', function(){
		var that = $(this),
				url  = 'index.php/main/getProductosXCategoria',
				type = 'post',
				data = {};

				// ID de la categoria seleccionada
				data['id_cat'] = $(this).data('id');

				$.ajax({
					url: url,
					type: type,
					data: data,
					success: function(response){
						json = jQuery.parseJSON(response);

						var template = $('#productos-template').html();
								back = $('#back-button').html();
						$('.modal-body').html("");
						$('.modal-body').append(back);
						$.each(json, function(index, value){
							$('.modal-body').append(Mustache.render(template, json[index]));
						});
					}
				}); 
	});

	$('.modal-body').on('click', '.btn-agregar', function(){
		var that = $(this);

		if (pedido.productos == ''){
			pedido.productos.push({"id":that.data('id'),"cantidad":"1"});
		}
		else {
			$.each(pedido.productos, function(index, value){
				// Si el ID del producto existe en el arreglo
				// sumale uno a la cantidad
				if( pedido.productos[index].id === that.data('id') ){
					pedido.productos.cantidad = parseInt(pedido.productos.cantidad) + 1;
					
				}
			});
		}

		console.log(pedido);
	});


}