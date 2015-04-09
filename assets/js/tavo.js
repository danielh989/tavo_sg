$(function(){

	mesasDisponibles();

});

function mesasDisponibles(){

	$('.table-add').on('click', function(){
		var that = $(this),
				url  = 'index.php/main/getMesas',
				type = 'get',
				data = {};

		$.ajax({
			url: url,
			type: type,
			data: data,
			success: function(response){
				json = jQuery.parseJSON(response);
				console.log(json);
				var template = $('#select-table').html();
				$('.modal-body').html("");
				$.each(json, function(index, value){
					$('.modal-body').append(Mustache.render(template, json[index]));
				});
			}
		});
	});

	$('.modal-body').on('click', '.mesa-libre',function(){
		var that = $(this),
				url = 'index.php/main/crearSesionOrden',
				type = 'post',
				data = {};

				data['id'] = that.data('id');

				$.ajax({
					url: url,
					type: type,
					data: data,
					success: function(response){
						var json = jQuery.parseJSON(response),
						 		template = $('#categorias-template').html();

						console.log(response);
						$('.modal-body').html("");
						$.each(json, function(index, value){
							$('.modal-body').append(Mustache.render(template, json[index]));
						});
					}
				});
		
	});

}