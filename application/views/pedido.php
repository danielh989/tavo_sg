<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Pedido | Mesa <?=$detalle->numero?></title>
	
	<!-- Google Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
	<!-- Bootstrap -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<!-- Custom Style -->
	<link rel="stylesheet" href="<?=base_url('assets/css/style.css')?>">
</head>
<body>

	
	<div class="pedido-container">
		<div class="btn-wrapper">
			<div class="btn-atras">
				<a href="<?=base_url('main')?>">
					<span>&lt; Volver</span>
				</a>
			</div>
		</div>

		<header>
			<h1 class="numero-mesa">Mesa <?=$detalle->numero?></h1>
		</header>

		<hr>
		
		<div class="pedido-opciones">

			<div class="total-pedido">
				<span>Bs.F </span><?=$total[0]?><span>.<?=$total[1]?></span>
				<h4 class="text-center">Total Orden</h4>
			</div>

			<div class="btn-pedido">
				<a href="<?=base_url('main/pagar/'.$detalle->id)?>"><span class="glyphicon glyphicon-credit-card"></span><span class="title">Pagar</span></a>
			</div>

			<div class="btn-pedido btn-ordenar">
				<a href="#"><span class="glyphicon glyphicon-cutlery" data-toggle="modal" data-target="#myModal"></span><span class="title">Ordenar</span></a>
			</div>

			<div class="btn-pedido btn-ordenar">
				<a href="#"><span class="glyphicon glyphicon-transfer" data-toggle="modal" data-target="#myModal"></span><span class="title">Mesa</span></a>
			</div>

		</div>

		<div class="detalle-pedido">
			<h4 class="text-center" style="font-weight:800;text-transform:uppercase">Detalle Orden</h4>

			<?php foreach($productos as $producto): ?>
				<div class="producto">
					<h3 class="detalles name"><?=$producto->nombre?></h3>
					<h2 class="detalles qty">x<?=$producto->cantidad?></h2>
					<h4 class="detalles">Bs.F <?=$producto->precio_total?></h4>
					<div class="acciones">
						<button class="btn btn-warning btn-pedido" title="Devolver">Devolver</button>
						<button class="btn btn-danger btn-pedido" title="Eliminar">Eliminar</button>
					</div>
				</div>
			<?php endforeach; ?>
		</div>


		<!-- Modal -->
		<div class="modal order-modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h2 class="modal-title text-center" id="myModalLabel">Agregar Producto</h2>
		      </div>
		      <div class="modal-body">
		      </div>
		      <div class="modal-footer">
		      </div>
		    </div>
		  </div>
		</div>

		<template id="categorias-template">
			<a href="#" class="categoria" data-id="{{id}}">
				<div class="number-wrapper">
					<h2 class="number text-center">{{nombre}}</h2>
				</div>
			</a>
		</template>

		<template id="btn-completar">
			<button class="btn btn-success btn-block btn-completar">Completar</button>
		</template>
		
		<template id="back-button">
			<div class="btn-wrapper">
				<a href="#" class="btn-atras">
					<span class="arrow"></span>
			    <span class="arrow-inner"></span>
					<span class="button">Atrás</span>
				</a>
			</div>
		</template>

		<template id="productos-template">
			<a href="#" class="producto" data-id="{{id}}">
				<div class="number-wrapper">
					<h2 class="number">{{nombre}}</h2>
					<div class="precio">{{precio}} Bs.F</div>
					<div class="cantidad">{{cantidad}}</div>
					<div class="btn-group" role="group" aria-label="...">
					  <button type="button" data-id="{{id}}" class="btn btn-default"><span class="glyphicon glyphicon-minus"></span></button>
					  <button type="button" data-id="{{id}}" class="btn btn-default btn-agregar"><span class="glyphicon glyphicon-plus"></span></button>
					</div>
				</div>
			</a>
		</template>
	</div>

	<script src="//code.jquery.com/jquery-2.1.3.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="<?=base_url('node_modules/mustache/mustache.min.js')?>"></script>
	<script src="<?=base_url('assets/js/tavo.js')?>"></script>
</body>
</html>