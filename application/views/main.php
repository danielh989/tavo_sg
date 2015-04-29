<!DOCTYPE html>
<body>
<head>
	<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Mesas | SG</title>
	
	<!-- Google Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
	<!-- Bootstrap -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<!-- Custom Style -->
	<link rel="stylesheet" href="<?=base_url('assets/css/style.css')?>">
</head>
<body>

	<nav class="navbar navbar-inverse" role="navigation">
		<ul class="nav navbar-nav navbar-right">
			<li>
				<a href="#">Ayuda</a>
			</li>
			<li>
				<a href="<?=base_url('main/productos')?>">Productos</a>
			</li>
			<li>
				<a href="#">Cerrar Sesión</a>
			</li>
		</ul>
	</nav>
	
	<div class="table-container">
		
		<!-- Mesas abiertas -->

		<?php foreach ($mesas_activas as $row):?>
			<a href="<?=base_url('main/pedido/'.$row->id_pedido)?>" class="table-unit">
				<div class="number-wrapper">
					<h2 class="number"><?=$row->numero?></h2>
				</div>
			</a>
		<?php endforeach;?>
		

		<!-- Agregar mesa -->
		<a href="#" class="table-unit table-add" data-toggle="modal" data-target="#myModal">
			<div class="number-wrapper">
				<h2 class="number">+</h2>
			</div>
		</a>

		<!-- Modal -->
		<div class="modal order-modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h2 class="modal-title text-center" id="myModalLabel">Nueva Orden</h2>
		      </div>
		      <div class="modal-body">
		      </div>
		      <div class="modal-footer">
		      </div>
		    </div>
		  </div>
		</div>

	</div>

	<template id="select-table">
		<a href="#" class="mesa-libre" data-id="{{id}}">
			<div class="number-wrapper">
				<h2 class="number">{{numero}}</h2>
			</div>
		</a>
	</template>

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
		<div class="go-back">
			<div class="btn-wrapper">
				<a href="#" class="btn-atras">
					<span class="arrow"></span>
			    <span class="arrow-inner"></span>
					<span class="button">Atrás</span>
				</a>
			</div>
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
	
	<script src="//code.jquery.com/jquery-2.1.3.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="<?=base_url('node_modules/mustache/mustache.min.js')?>"></script>
	<script src="<?=base_url('assets/js/tavo.js')?>"></script>
</body>
</body>