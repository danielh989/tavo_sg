/**
 * Generar un nuevo pedido
 */
function crear_orden()
{
    var pedido = {
        "id_mesa": "",
        "productos": []
    };
    var categorias = {};
    var header = $('.modal-header'),
        body = $('.modal-body'),
        footer = $('.modal-footer');

    // Borrar pedido al cerrar el modal
    $('#myModal').on('hidden.bs.modal', function()
    {
        pedido = {
            "id_mesa": "",
            "productos": []
        };
    });

    // Funcion para traer las mesas disponibles
    $('.table-add').on('click', function()
    {
        var that = $(this),
            url = '/tavo_sg/mesas/libres',
            type = 'get',
            data = {};

        $.ajax({
            url: url,
            type: type,
            data: data,
            success: function(mesas)
            {
                body.html("");
                footer.html("");
                $.get('/tavo_sg/assets/templates/mesas_disponibles.mst', function(template) {
                    $.each(mesas, function(index, value){
                        body.append(Mustache.render(template, mesas[index]));
                    });
                });
            }
        });
    });

    // Funcion para traer categorias
    $(body).on('click', '.mesa-libre', function()
    {
        var that = $(this),
            url = 'categorias/getJSON',
            type = 'post',
            data = {};

        // Guardando el ID de la mesa seleccionada
        pedido.id_mesa = that.data('id');
        $.ajax({
            url: url,
            type: type,
            data: data,
            success: function(response)
            {
                categorias = response; // Llenamos la variable con las categorias
                body.html(""); // Borramos el modal
                footer.html(""); // Borramos el footer del modal

                // Renderizando el btn de completar la order
                $.get('assets/templates/btn-completar.mst', function(template) {
                    footer.append(Mustache.render(template));
                });
                // Renderizando las categorias
                $.get('assets/templates/categorias.mst', function(template) {
                    $.each(response, function(index, value) {
                        body.append(Mustache.render(template, response[index]));
                    });
                });
            }
        });
    });

    // Traer los productos de una categoria
    $('.modal-body').on('click', '.categoria', function()
    {
        var that = $(this),
            url = 'productos/getJSON',
            type = 'post',
            data = {};

        // Guardamos ID de la categoria seleccionada
        data['id_cat'] = $(this).data('id');
        $.ajax({
            url: url,
            type: type,
            data: data,
            success: function(productos)
            {   
                // Borramos el contenido del modal
                body.html("");
                footer.html("");
                // Renderizando el btn de completar la order
                $.get('assets/templates/btn-completar.mst', function(template) {
                    footer.append(Mustache.render(template));
                });

                if (productos.length > 0) 
                {
                    // Colocamos el btn "atras"
                    $.get('assets/templates/back-btn.mst', function(template) {
                        body.append(Mustache.render(template));
                    });

                    // Renderizamos los productos
                    $.get('assets/templates/productos.mst', function(template) {
                        $.each(productos, function(index, value) {
                            body.append(Mustache.render(template, productos[index]));
                        });
                    });
                }
                else
                {   
                    // Colocamos el btn "atras"
                    $.get('assets/templates/back-btn.mst', function(template) {
                        body.append(Mustache.render(template));
                        body.append('<h3 class="text-center text-muted">No hay productos</h3>');
                    });
                }
            }
        });
    });

    // Agregar producto al pedido
    body.on('click', '.btn-agregar', function()
    {
        var that = $(this),
            flag = 0,
            cantidad = that.closest('.number-wrapper').find('.cantidad'),
            valor = parseInt(cantidad.text());

        // Borramos posibles cantidades anteriores
        cantidad.html(""); 
        if (pedido.productos == '')
        {
            pedido.productos.push({
                "id": that.data('id'),
                "cantidad": "1",
                "nombre": that.data('nombre'),
            });
            cantidad.append("1");
        }
        else
        {
            // Buscamos el ID en el arreglo de productos,
            // si existe, se le suma uno a la cantidad.
            $.each(pedido.productos, function(index, value)
            {
                // Si el ID del producto existe en el arreglo
                // sumale uno a la cantidad
                if (pedido.productos[index].id === that.data('id'))
                {
                    pedido.productos[index].cantidad = parseInt(pedido.productos[index].cantidad) + 1;
                    pedido.productos[index].id = that.data('id');
                    pedido.productos[index].nombre = that.data('nombre');
                    cantidad.append(valor + 1);
                    flag = 1;
                }
            });

            // Si el ID no existe en el arreglo, agregamos un
            // producto nuevo
            if (flag == 0)
            {
                pedido.productos.push({
                    "id": that.data('id'),
                    "cantidad": "1",
                    "nombre": that.data('nombre'),
                });
                cantidad.append("1");
            }
        }
    });

    // Volver al menu de categorias
    body.on('click', '.btn-atras', function()
    {
        var json = $.merge(categorias, pedido);

        // Borramos el contenido del modal
        body.html(""); 
        console.log(pedido.productos);
        $.get('assets/templates/categorias.mst', function(template) {
            $.each(categorias, function(index, value) {
                body.append(Mustache.render(template, json[index]));
            });
        });

        // Borramos el contenido del footer
        footer.html("")
        footer.append('<h3 class="text-center" style="text-transform: uppercase">Resumen de Orden</h3>');
        $.get('assets/templates/resumen-pedido.mst', function(template) {
            footer.append(Mustache.render(template));
            $.each(pedido.productos, function(index, value){
                var table = $('.table tbody');

                table.append('<tr> <td>' + pedido.productos[index].nombre + '</td> <td>' + pedido.productos[index].cantidad + '</td></tr>');
            });

            // Renderizando el btn de completar la order
            $.get('assets/templates/btn-completar.mst', function(template) {
                footer.append(Mustache.render(template));
            });
        });
    });

    // Completar y generar la orden
    footer.on('click', '.btn-completar', function() {
        var type = 'post',
            url = 'pedidos/add',
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