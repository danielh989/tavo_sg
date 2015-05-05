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