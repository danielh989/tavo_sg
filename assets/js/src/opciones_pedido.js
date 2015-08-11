function opciones_pedido()
{
	var opciones = {
		pedido: {
			'id_pedido': "",
			'id_mesa': "",
			'productos': [],
		},
		init: function() {
			this.cacheDOM();
			this.bindEvents();
			this.cambiarMesa();
			this.pedido.id_pedido = $('#id_pedido').data('id-pedido');
		},
		cacheDOM: function() {
			this.$header 				 = $('.modal-header');
      this.$body 					 = $('.modal-body');
			this.$footer 				 = $('.modal-footer');
			this.$modalTitle 		 = $('.modal-title');
			this.$opciones 			 = $('.pedido-opciones');
			this.$btnMesa 			 = $('.pedido-opciones .table-add');
			this.$btnOrdenar 		 = $('.pedido-opciones .ordenar');
			this.$btnPagar 			 = $('.pedido-opciones .pagar');
			this.$mesaDisponible = $('.mesa-para-cambio');
			this.$idPedido 			 = $('#id_pedido');
			this.$categoria 		 = $(document);
			this.$btnBack 			 = $(document);
			this.$btnCompletar   = $(document);
			this.$btnAgregar   	 = $(document);
		},
		bindEvents: function() {
			this.$btnMesa.on('click', this.mesasDisponibles.bind(this));
			this.$btnPagar.on('click', this.pagar.bind(this));
			this.$btnOrdenar.on('click', this.ordenar.bind(this));
			this.$categoria.on('click', '.categoria', this.mostrarProductos);
			this.$btnBack.on('click', '.go-back', this.ordenar.bind(this));
			this.$btnAgregar.on('click', '.btn-agregar', this.agregarProducto.bind(this));
			this.$btnCompletar.on('click', '.btn-completar', this.completarOrden.bind(this));
		},
		mesasDisponibles: function() {
			var that = this;
					url = '/tavo_sg/mesas/libres',
			    type = 'get';

			$.ajax({
			    url: url,
			    type: type,
			    success: function(mesas)
			    {
			    	that.$modalTitle.text("Cambiar Mesa");
		        that.$body.html("");
		        that.$footer.html("");
		        $.get('/tavo_sg/assets/templates/mesas_disponibles_cambio.mst', function(template) {
		            $.each(mesas, function(index, value){
		                that.$body.append(Mustache.render(template, mesas[index]));
		            });
		        });
			    }
			});
		},
		cambiarMesa: function() {
			var IDPedido = this.$idPedido.data('id-pedido');
			$(document).on('click', '.mesa-para-cambio', function(){
				 var IDMesa = $(this).data('id'),
				 		 url = '/tavo_sg/pedidos/cambiar_mesa',
				 		 type = 'post',
				 		 data = {};

				 		 data['id_pedido'] = IDPedido;
				 		 data['id_mesa'] = IDMesa;

				 		 $.ajax({
				 			url: url,
				 			type: type,
				 			data: data,
				 			success: function(response){
				 				location.reload();
				 			}
				 		 });
			});
		},
		pagar: function() {
			var that = this,
					template = $('#payment-body').html(),
					btns = $('#pagar-buttons').html();

			that.$body.html("");
			that.$modalTitle.text("Pagar");
			that.$body.append(Mustache.render(template));

			that.$footer.html("");
			that.$footer.append(Mustache.render(btns));
		},
		ordenar: function() {
	    var that = this,
          url = '/tavo_sg/categorias/getJSON',
          type = 'post',
          data = {};

			// Setting up the modal title
			this.$modalTitle.text("Ordenar");

      // Guardando el ID de la mesa seleccionada
      this.pedido.id_mesa = this.$btnOrdenar.data('id');

      $.ajax({
        url: url,
        type: type,
        data: data,
        success: function(response)
        {
          categorias = response; // Llenamos la variable con las categorias
          that.$body.html(""); // Borramos el modal
          that.$footer.html(""); // Borramos el footer del modal

          // Renderizando el btn de completar la order
          $.get('/tavo_sg/assets/templates/btn-completar.mst', function(template) {
            that.$footer.append(Mustache.render(template));
          });
          // Renderizando las categorias
          $.get('/tavo_sg/assets/templates/categorias.mst', function(template) {
            $.each(response, function(index, value) {
                that.$body.append(Mustache.render(template, response[index]));
	          });
          });
        }
      });
		},
		mostrarProductos: function() {
      var that = $(this),
          url = '/tavo_sg/productos/getJSON',
          type = 'post',
          data = {},
    			modalTitle = $('.modal-title'),
          body = $('.modal-body'),
    			footer = $('.modal-footer');

      // Guardamos ID de la categoria seleccionada
      data['id_cat'] = $(this).data('id');

      $.ajax({
          url: url,
          type: type,
          data: data,
          success: function(productos)
          {   
              // Borramos el contenido del modal
              // modalTitle.text("")
              body.html("");
              footer.html("");
              // Renderizando el btn de completar la order
              $.get('/tavo_sg/assets/templates/btn-completar.mst', function(template) {
                  footer.append(Mustache.render(template));
              });

              if (productos.length > 0) 
              {
                  // Colocamos el btn "atras"
                  $.get('/tavo_sg/assets/templates/back-btn.mst', function(template) {
                      body.append(Mustache.render(template));
                  });

                  // Renderizamos los productos
                  $.get('/tavo_sg/assets/templates/productos.mst', function(template) {
                      $.each(productos, function(index, value) {
                          body.append(Mustache.render(template, productos[index]));
                      });
                  });
              }
              else
              {   
                  // Colocamos el btn "atras"
                  $.get('/tavo_sg/assets/templates/back-btn.mst', function(template) {
                      body.append(Mustache.render(template));
                      body.append('<h3 class="text-center text-muted">No hay productos</h3>');
                  });
              }
          }
      });
		},
		agregarProducto: function(e) {
			// console.log($(e.target).closest('.number-wrapper').find('.cantidad'));
			var that = this,
			    flag = 0,
			    cantidad = $(e.target).closest('.number-wrapper').find('.cantidad'),
			    valor = parseInt(cantidad.text()),
			    btn = $(e.target).closest('.btn-agregar');

			// Borramos posibles cantidades anteriores
			cantidad.html(""); 
			if (that.pedido.productos == '')
			{
			    that.pedido.productos.push({
			        "id": btn.data('id'),
			        "cantidad": "1",
			        "nombre": btn.data('nombre'),
			    });
			    cantidad.append("1");
			}
			else
			{
			    // Buscamos el ID en el arreglo de productos,
			    // si existe, se le suma uno a la cantidad.
			    $.each(that.pedido.productos, function(index, value)
			    {
			        // Si el ID del producto existe en el arreglo
			        // sumale uno a la cantidad
			        if (that.pedido.productos[index].id === btn.data('id'))
			        {
			            that.pedido.productos[index].cantidad = parseInt(that.pedido.productos[index].cantidad) + 1;
			            that.pedido.productos[index].id = btn.data('id');
			            that.pedido.productos[index].nombre = btn.data('nombre');
			            cantidad.append(valor + 1);
			            flag = 1;
			        }
			    });

			    // Si el ID no existe en el arreglo, agregamos un
			    // producto nuevo
			    if (flag == 0)
			    {
			        that.pedido.productos.push({
			            "id": btn.data('id'),
			            "cantidad": "1",
			            "nombre": btn.data('nombre'),
			        });
			        cantidad.append("1");
			    }
			}
		},
		completarOrden: function(e) {
			var type = 'post',
			    url = '/tavo_sg/pedidos/add_product_to_order',
			    data = this.pedido;
					redirect = 'http://localhost/tavo_sg/pedidos/detalle/' + this.pedido.id_pedido;

			$.ajax({
			    url: url,
			    type: type,
			    data: data,
			    success: function(response) {
			    	window.location = redirect;
			    }
			});
		},
	};

	opciones.init();
	
}