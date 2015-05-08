/*
* Gestionar los productos a nivel de Administrador
*/
function gestionarMesas() {
  // Editar una mesa
  $('.agregar-mesa').on('click', function() {
    console.log('ajaaaaaaaaaaaa');
    var mesa = $(this).closest('div'),
        id = mesa.data('id'),
        nombre = mesa.data('nombre'),
        numero = mesa.data('numero');
    $('input[name=id]').val(id);
    $('input[name=nombre]').val(nombre);
    $('input[name=numero]').val(numero);
  });
}