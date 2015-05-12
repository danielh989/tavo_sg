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