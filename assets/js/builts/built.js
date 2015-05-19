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
                $.get('assets/templates/mesas_disponibles.mst', function(template) {
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
                "cantidad": "1"
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
                    "cantidad": "1"
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
        $.get('assets/templates/categorias.mst', function(template) {
            $.each(categorias, function(index, value) {
                body.append(Mustache.render(template, json[index]));
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
/*
 * Gestionar los productos a nivel de Administrador
 */
function gestionarCategorias() {

    // Editar una mesa
    $('.agregar-categoria').on('click', function() {
        var categoria = $(this),
            id = categoria.data('id');
        nombre = categoria.find('h4').data('nombre');
        $('input[name=id]').val(id);
        $('input[name=nombre]').val(nombre);
        $('span.error').empty();
    });

    $('.eliminar_categoria').on('click', function() {
        var categoria = $(this).closest('.agregar-categoria'),
            id = categoria.data('id'),
            data = {};

            data['id_categoria'] = id;
            console.log(id);
       
        $.ajax({
            type: 'POST',
            url: 'categorias/delete',
            data: data,
            success: function(response) {
                if ($.parseJSON(response).code == 1451)
                {
                    alert('No se puede eliminar la categoria porque pertenece a un pedido');
                } 
                else
                {
                    categoria.remove();
                    location.reload();
                }
            }
        });
    });

    $("#form-categoria").submit(function(e) {
        e.preventDefault();
        var form = $('#form-categoria'),
            type = form.attr('method'),
            url = form.attr('action'),
            data = form.serialize();
        $.ajax({
            type: type,
            url: url,
            data: data,
            success: function(response) {
                if ($.parseJSON(response).code == 1062) {
                    $('span.error').empty().append('Ya existe una categoria con ese nombre');
                } else {
                    location.reload();
                }
            }
        });
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
   
        $.ajax({
            type: 'POST',
            url: 'mesas/delete',
            data: {
                id_mesa: id
            },
            success: function(response) {
            
                if ($.parseJSON(response).code == 1451) {
                    alert('No se puede eliminar la mesa porque pertenece a un pedido');
                } else {
                    mesa.closest('a').remove();
                    //location.reload();
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
            url = '/tavo_sg/Productosxpedido/delete',
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
    $('.btn-eliminar-devuelto').on('click', function() {
        var type = 'post',
            url = '/tavo_sg/Productosxpedido/deleteDevuelto',
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
    $('.btn-devolver').on('click', function() {
        var type = 'post',
            url = '/tavo_sg/Productosxpedido/devolver',
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
                if (response.st) {
                    location.reload();
                } else {
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
        $('#eliminarProducto a').attr('href', 'productos/delete/' + idProducto);
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
        url = '/tavo_sg/categorias/getJSON',
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