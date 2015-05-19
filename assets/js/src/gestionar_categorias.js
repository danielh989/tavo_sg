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