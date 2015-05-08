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
	<link href="<?=base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
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

		<?php foreach ($mesas as $row):?>
			<a href="#" class="table-unit agregar-mesa" data-toggle="modal" data-target="#myModal">
				<div class="number-wrapper">
					<p hidden id="id" data-id="<?=$row->id?>"></p>
					<h2 id="numero" class="number" data-numero="<?=$row->numero?>"><?=$row->numero?></h2>
					<h4 id="nombre" data-nombre="<?=$row->nombre?>"><?=$row->nombre?></h4>
				</div>
			</a>
		<?php endforeach;?>
		

		<!-- Agregar mesa -->
		<a href="#" class="table-unit agregar-mesa" data-toggle="modal" data-target="#myModal">
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
		        <h2 class="modal-title text-center" id="myModalLabel">Editar Mesa</h2>
		      </div>
		      <div class="modal-body">

		      <form action="" class="form-group">
		      	<p><label for="numero">Numero</label></p>
		      	<input type="text" name="numero">
		      	<p><label for="nombre">Nombre</label></p>
		      	<input type="text" name="nombre">
		      	<input type="hidden" name="id">
		      </form>
		      </div>
		      <div class="modal-footer">
		      </div>
		    </div>
		  </div>
		</div>
	</div>
	
	<script src="<?=base_url('assets/js/jquery-2.1.4.min.js')?>"></script>
	<script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
	<script src="<?=base_url('node_modules/mustache/mustache.min.js')?>"></script>
	<script src="<?=base_url('assets/js/tavo.min.js')?>"></script>
</body>
</body>