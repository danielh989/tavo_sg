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