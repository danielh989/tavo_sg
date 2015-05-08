/*!
* Tavo SG JavaScript
* fdf
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
    gestionarMesas();
});

/**
* Generar un nuevo pedido
*/
function mesasDisponibles() {
  var pedido = {
      "id_mesa": "",
      "productos": []
  };

  var categorias = {};

  var header = $('.modal-header'),
      body   = $('.modal-body'),
      footer = $('.modal-footer');

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
        body.html("");
        footer.html("");
        $.get('assets/templates/mesas_disponibles.mst', function(template){
          $.each(mesas, function(index, value){
            body.append(Mustache.render(template, mesas[index]));
          });
        });
      }
    });
  });
  // Funcion para traer categorias
  $(body).on('click', '.mesa-libre', function() {
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
        body.html(""); // Borramos el modal
        footer.html(""); // Borramos el footer del modal
        
        // Renderizando el btn de completar la order
        $.get('assets/templates/btn-completar.mst', function(template){
          footer.append(Mustache.render(template));
        });

        // Renderizando las categorias
        $.get('assets/templates/categorias.mst', function(template){
          $.each(response, function(index, value) {
              body.append(Mustache.render(template, response[index]));
          });
        });
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
        body.html(""); // Borramos el contenido del modal
        // Colocamos el btn "atras"
        $.get('assets/templates/back-btn.mst', function(template){
          body.append(Mustache.render(template));
        });
        // Renderizamos los productos
        $.get('assets/templates/productos.mst', function(template){
          $.each(productos, function(index, value) {
            body.append(Mustache.render(template, productos[index]));
          });
        });
      }
    });
  });

  // Agregar producto al pedido
  body.on('click', '.btn-agregar', function() {
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
  body.on('click', '.btn-atras', function() {
    var json = $.merge(categorias, pedido);

    body.html(""); // Borramos el contenido del modal
    $.get('assets/templates/categorias.mst', function(template){
      $.each(categorias, function(index, value) {
          body.append(Mustache.render(template, json[index]));
      });
    });
  });

  // Completar y generar la orden
  footer.on('click', '.btn-completar', function() {
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
/**
* Formato de los inputs en el moal de pago
*
*/
function formatoPagos(){
	/**
	* HAY UN CONFLICTO ENTRE ESTA FUNCION Y LA QUE LE SIGUE
	* !!!REVISAR!!!
	*/
	// $('#efectivo, #debito').priceFormat({
	// 	prefix: 'Bs.F ',
	// 	centsSeparator: ',',
	// 	thousandsSeparator: '.'
	// });

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
/*
 * Gestionar los productos a nivel de Administrador
 */
function gestionarMesas() {
    // Editar una mesa
    $('.agregar-mesa').on('click', function() {
        var mesa = $(this).find('div'),
            id = mesa.find('p').data('id');
        numero = mesa.find('h2').data('numero');
        nombre = mesa.find('h4').data('nombre');
        $('input[name=id]').val(id);
        $('input[name=nombre]').val(nombre);
        $('input[name=numero]').val(numero);
        $('span.error').empty();
    });








    $('.eliminar_mesa').on('click', function() {
        var mesa = $(this).closest('div'),
            id = mesa.find('p').data('id');

            console.log(id); 


        $.ajax({
            type: 'POST',
            url: 'eliminar_mesa',
            data: {
                id_mesa: id
            },
            success: function(response) {

              console.log(response);
                if ($.parseJSON(response).code == 1451) {
                    alert('No se puede eliminar la mesa porque pertenece a un pedido');
                } else {
                    location.reload();
                }
            }
        });


    });






    $("#form-mesa").submit(function(e) {
        e.preventDefault();
        var form = $('#form-mesa'),
            type = form.attr('method'),
            url = form.attr('action'),
            data = form.serialize();
        $.ajax({
            type: type,
            url: url,
            data: data,
            success: function(response) {
                if ($.parseJSON(response).code == 1062) {
                    $('span.error').empty().append('El nombre o numero de mesa ya existe');
                } else {
                    location.reload();
                }
            }
        });
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
        data = form.serialize();

    $.ajax({
      type: type,
      url: url,
      data: data,
      success: function(response) {
          if(response.st){
            location.reload();
          }
          else {
            $('span.error').append('Opps! Ocurrio un error, intentalo nuevamente.');
          }
      }
    });
  });

  // Editar un producto
  $('.table tbody .btn-editar').on('click', function() {
      var fila = $(this).closest('tr'),
          id = fila.data('id-producto'),
          cat = fila.find('.categoria').attr('data-idcat');
          console.log(cat);

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
          sel.append('<option value="' + json[index].id + '">' + json[index].nombre + '</option>');
      });
      if (auto == 1) {
          sel.val(categoria);
      }
    }
  });
}