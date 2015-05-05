/*!
* Tavo SG JavaScript
* 
* @author Jesus Torres
* @author Daniel Arroy
* @author Pedro Flores
*
* Copyright 20015 Lab 707.
*
* Date: 02/05/2015
*/
$(function() {
    mesasDisponibles();
    gestionarProductos();
    gestionarPedidos();
    formatoPagos();
});
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
/**
* Gestionar los detalles de un pedido
* (Agregar productos, cambiar mesa, pagar)
*/
function gestionarPedidos() {
  $('.btn-eliminar').on('click', function() {
    var type = 'post',
        url = '/tavo_sg/main/eliminar_producto_pedido',
        data = {};
    data['id_pedido'] = $(this).data('pedido');
    data['id_producto'] = $(this).data('producto');
    console.log(data);
    $.ajax({
      type: type,
      url: url,
      data: data,
      success: function(response) {
        location.reload();
      }
    });
  });

  $('.btn-eliminar-devuelto').on('click', function() {
    var type = 'post',
        url = '/tavo_sg/main/eliminar_producto_devuelto',
        data = {};
    data['id_pedido'] = $(this).data('pedido');
    data['id_producto'] = $(this).data('producto');
    console.log(data);
    $.ajax({
      type: type,
      url: url,
      data: data,
      success: function(response) {
        location.reload();
      }
    });
  });


  $('.btn-devolver').on('click', function() {
    var type = 'post',
        url = '/tavo_sg/main/devolver_producto_pedido',
        data = {};
    data['id_pedido'] = $(this).data('pedido');
    data['id_producto'] = $(this).data('producto');
    $.ajax({
      type: type,
      url: url,
      data: data,
      success: function(response) {
        location.reload();
      }
    });
  });
}

/**
* Cargar categorias en un select (Generica)
*
* @param select String 
* @param auto BOOL
* @param categoria String
* 
* @return void
*/
function getCategorias(select, auto, categoria) {
  var type = 'post',
      url = '/tavo_sg/main/getCategorias',
      data = {};
  $.ajax({
    type: type,
    url: url,
    data: data,
    success: function(json) {
      sel = $(select);
      sel.empty();
      sel.append('<option value="0">Seleccionar...</option>');
      $.each(json, function(index, value) {
          sel.append('<option value"' + json[index].id + '">' + json[index].nombre + '</option>');
      });
      if (auto == 1) {
          sel.val(categoria);
      }
    }
  });
}

/*
* Gestionar los productos a nivel de Administrador
*/
function gestionarProductos() {
  // Abrir el modal para agregar producto
  $('.btn-agregar').on('click', function() {
      getCategorias('#id_cat', 0); // Dejar el select en opcion 0
      $('input').val(""); // Borrar contenido los inputs
      $('textarea').val(""); // Borrar contenido del textarea
  });

  // Enviar datos para almacenarlos en la DB (Agregar Pedido)
  $('.btn-guardar').on('click', function() {
    var form = $('form#producto'),
        type = form.attr('method'),
        url = form.attr('action'),
        data = form.serializeArray();
        data.push({ name: "id_cat", value: $('#id_cat').prop("selectedIndex") });


    $.ajax({
      type: type,
      url: url,
      data: data,
      success: function(response) {
          console.log(response);
      }
    });
  });

  // Editar un producto
  $('.table tbody .btn-editar').on('click', function() {
      var fila = $(this).closest('tr'),
          id = fila.data('id-producto'),
          cat = fila.find('.categoria').text();
      $('input[name=id]').val(id);
      $('input[name=nombre]').val(fila.find('.nombre').text());
      $('input[name=precio]').val(fila.find('.precio').text());
      $('textarea[name=descripcion]').val(fila.find('.descripcion').text());
      getCategorias('#id_cat', 1, cat);
  });
  // Eliminar producto
  $('.table tbody .btn-eliminar').on('click', function() {
      var row = $(this).closest('tr'),
          idProducto = row.data('id-producto');
      $('#eliminarProducto a').attr('href', 'eliminar/' + idProducto);
  });
}

/**
* Generar un nuevo pedido
*/
function mesasDisponibles() {
  var pedido = {
      "id_mesa": "",
      "productos": []
  };

  var categorias = {};

  // Borrar pedido al cerrar el modal
  $('#myModal').on('hidden.bs.modal', function() {
      pedido = {
          "id_mesa": "",
          "productos": []
      };
  });

  // Funcion para traer las mesas disponibles
  $('.table-add').on('click', function() {
    var that = $(this),
        url = 'main/getMesas',
        type = 'get',
        data = {};

    $.ajax({
      url: url,
      type: type,
      data: data,
      success: function(mesas) {
        var template = $('#select-table').html();

        $('.modal-body').html("");
        $.each(mesas, function(index, value) {
            $('.modal-body').append(Mustache.render(template, mesas[index]));
        });
        $('.modal-footer').html("");
      }
    });
  });
  // Funcion para traer categorias
  $('.modal-body').on('click', '.mesa-libre', function() {
    var that = $(this),
        url = 'main/getCategorias',
        type = 'post',
        data = {};

    // Guardando el ID de la mesa seleccionada
    pedido.id_mesa = that.data('id');

    $.ajax({
      url: url,
      type: type,
      data: data,
      success: function(response) {
        categorias = response; // Llenamos la variable con las categorias

        var template = $('#categorias-template').html(),
            btnTemplate = $('#btn-completar').html();

        $('.modal-body').html(""); // Borramos el modal
        $.each(response, function(index, value) {
            $('.modal-body').append(Mustache.render(template, response[index]));
        });
        $('.modal-footer').html(""); // Borramos el footer del modal
        $('.modal-footer').append(Mustache.render(btnTemplate)); // Agregamos el btn de completar
      }
    });
  });

  // Traer los productos de una categoria
  $('.modal-body').on('click', '.categoria', function() {
    var that = $(this),
        url = 'main/getProductosXCategoria',
        type = 'post',
        data = {};

    data['id_cat'] = $(this).data('id'); // Guardamos ID de la categoria seleccionada

    $.ajax({
      url: url,
      type: type,
      data: data,
      success: function(productos) {
    		// Cargamos las plantillas
        var template = $('#productos-template').html(),
            back = $('#back-button').html();

        $('.modal-body').html(""); // Borramos el contenido del modal
        $('.modal-body').append(back); // Colocamos el btn "atras"
        $.each(productos, function(index, value) {
            $('.modal-body').append(Mustache.render(template, productos[index]));
        });
      }
    });
  });

  // Agregar producto al pedido
  $('.modal-body').on('click', '.btn-agregar', function() {
      var that = $(this),
          flag = 0,
          cantidad = that.closest('.number-wrapper').find('.cantidad'),
          valor = parseInt(cantidad.text());

      cantidad.html(""); // Borramos posibles cantidades anteriores

      if (pedido.productos == '') {
          pedido.productos.push({
              "id": that.data('id'),
              "cantidad": "1"
          });
          cantidad.append("1");
      } else {
          // Buscamos el ID en el arreglo de productos,
          // si existe, se le suma uno a la cantidad.
          $.each(pedido.productos, function(index, value) {
              // Si el ID del producto existe en el arreglo
              // sumale uno a la cantidad
              if (pedido.productos[index].id === that.data('id')) {
                  pedido.productos[index].cantidad = parseInt(pedido.productos[index].cantidad) + 1;
                  pedido.productos[index].id = that.data('id');
                  cantidad.append(valor + 1);
                  flag = 1;
              }
          });
          // Si el ID no existe en el arreglo, agregamos un
          // producto nuevo
          if (flag == 0) {
              pedido.productos.push({
                  "id": that.data('id'),
                  "cantidad": "1"
              });
              cantidad.append("1");
          }
      }
  });

	// Volver al menu de categorias
  $('.modal-body').on('click', '.btn-atras', function() {
    var template = $('#categorias-template').html(),
    		json = $.merge(categorias, pedido);

    $('.modal-body').html(""); // Borramos el contenido del modal
    $.each(categorias, function(index, value) {
        $('.modal-body').append(Mustache.render(template, json[index]));
    });
  });

  // Completar y generar la orden
  $('.modal-footer').on('click', '.btn-completar', function() {
    var type = 'post',
        url = 'main/crear_pedido',
        data = pedido;

    $.ajax({
      url: url,
      type: type,
      data: data,
      success: function(response) {
        window.location = 'http://localhost/tavo_sg/';
      }
    });
  });
}