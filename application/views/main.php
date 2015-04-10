<!DOCTYPE html>
<body>
<head>
	<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Mesas | SG</title>
	
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
				<a href="#">Cerrar Sesión</a>
			</li>
		</ul>
	</nav>
	
	<div class="table-container">
		
		<!-- Mesas abiertas -->

		<?php foreach ($mesas_activas as $row):?>
			<a href="#" class="table-unit">
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
	
	<template id="back-button">
		<a href="#" class="back"><span class="glyphicon glyphicon-chevron-left">Atrás</span></a>
	</template>

	<template id="productos-template">
		<a href="#" class="producto" data-id="{{id}}">
			<div class="number-wrapper">
				<h2 class="number">{{nombre}}</h2>
				<div class="precio">{{precio}}</div>
				<div class="cantidad"></div>
				<div class="btn-group" role="group" aria-label="...">
				  <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-minus"></span></button>
				  <button type="button" class="btn btn-default btn-agregar"><span class="glyphicon glyphicon-plus"></span></button>
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