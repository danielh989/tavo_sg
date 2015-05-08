/*
 * Gestionar los productos a nivel de Administrador
 */
function gestionarCategorias() {
    // Editar una mesa
    $('.agregar-categoria').on('click', function() {
        var categoria = $(this).find('div'),
            id = categoria.find('p').data('id');
        nombre = categoria.find('h4').data('nombre');
        $('input[name=id]').val(id);
        $('input[name=nombre]').val(nombre);
        $('span.error').empty();
    });
    $('.eliminar_categoria').on('click', function() {
        var categoria = $(this).closest('div'),
            id = categoria.find('p').data('id');
        console.log(id);
        $.ajax({
            type: 'POST',
            url: 'eliminar_categoria',
            data: {
                id_categoria: id
            },
            success: function(response) {
                console.log(response);
                if ($.parseJSON(response).code == 1451) {
                    alert('No se puede eliminar la categoria porque pertenece a un pedido');
                } else {
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