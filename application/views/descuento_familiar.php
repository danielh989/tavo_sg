<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Title Page</title>

		<!-- Bootstrap CSS -->
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
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
				<a href="<?=base_url('main/editar_mesas')?>">Mesas</a>
			</li>

			<li>
				<a href="<?=base_url('main/cuentas')?>">Cuentas</a>
			</li>

			<li>
				<a href="<?=base_url('main/editar_categorias')?>">Categorias</a>
			</li>

			<li>
				<a href="<?=base_url('main/descuento_familiar')?>">Descuento Familiar</a>
			</li>
			<li>
				<a href="#">Cerrar Sesión</a>
			</li>
		</ul>
	</nav>
		<div class="container">
		<form action="submit_descuento" method="POST" role="form">
			<legend>Descuento Familiar</legend>
		
			<div class="col-md-6">
			<div class="form-group">

				<label for="">Descuento</label>
				<input type="text" class="form-control" value="<?= $descuento->valor ?>" name="descuento" placeholder="Descuento">
	
				</div>
			
		
			
		
			<button type="submit" class="btn btn-primary">Guardar</button>
			</div>
		</form>
</div>
		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	</body>
</html>