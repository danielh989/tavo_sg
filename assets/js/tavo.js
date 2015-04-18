$(function(){

	// var ejemplo = {
	// 	"mesas": [
	// 		{"id":"1"}
	// 	],
	// 	"productos": [
	// 		{"id":"2", "cant":"1"}
	// 	]
	// }

	// $.each(ejemplo.productos, function(index, value){
	// 	ejemplo.productos[index].cant = parseInt(ejemplo.productos[index].cant) + 1;
	// 	console.log(ejemplo.productos[index].cant);
	// });

	mesasDisponibles();

});

function mesasDisponibles(){

	var pedido = {
		"mesa": "",
		"productos": []
	};

	var categorias = {};

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
				pedido.mesa = that.data('id');

				$.ajax({
					url: url,
					type: type,
					data: data,
					success: function(response){
						categorias = jQuery.parseJSON(response);
						var template = $('#categorias-template').html(),
							  btn-template = $('#btn-completar').html();

						$('.modal-body').html("");
						$.each(categorias, function(index, value){
							$('.modal-body').append(Mustache.render(template, categorias[index]));
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

						var template = $('#productos-template').html(),
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
		var that = $(this),
			  flag = 0,
			  cantidad = that.closest('.number-wrapper').find('.cantidad'),
			  valor = parseInt(cantidad.text());

		cantidad.html("");

		if (pedido.productos == ''){
			pedido.productos.push({"id":that.data('id'),"cantidad":"1"});
			cantidad.append("1");
		}
		else {
			// Buscamos el ID en el arreglo de productos,
			// si existe, se le suma uno a la cantidad.
			$.each(pedido.productos, function(index, value){
				// Si el ID del producto existe en el arreglo
				// sumale uno a la cantidad
				if( pedido.productos[index].id === that.data('id') ){
					pedido.productos[index].cantidad = parseInt(pedido.productos[index].cantidad) + 1;
					pedido.productos[index].id = that.data('id');

					cantidad.append(valor + 1);

					flag = 1;
				}
			});

			// Si el ID no existe en el arreglo, agregamos un
			// producto nuevo
			if (flag == 0){
				pedido.productos.push({"id":that.data('id'),"cantidad":"1"});
				cantidad.append("1");
			}
		}
	});

	$('.modal-body').on('click', '.btn-atras', function(){
		var template = $('#categorias-template').html();
				var json = $.merge(categorias, pedido);

		$('.modal-body').html("");
		$.each(categorias, function(index, value){
			$('.modal-body').append(Mustache.render(template, json[index]));
		});
	});

	$('.modal-footer').on('click', '.btn-completar', function(){
		var type = 'post',
				url = 'index.php/main/crear_pedido',
				data = pedido;

				$.ajax({
					url: url,
					type: type,
					data: data,
					success: function (response){
						console.log(response);
					}
				});
	});
}