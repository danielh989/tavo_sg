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