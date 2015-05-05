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