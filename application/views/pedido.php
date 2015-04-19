<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Pedido | Mesa <?=$detalle->numero?></title>

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
					<span>&lt;Atras</span>
				</a>
			</div>
		</div>

		<header>
			<h1 class="numero-mesa">Mesa <?=$detalle->numero?></h1>
			<div class="total-pedido">
				Bs.F <?=$total[0]?><span>.<?=$total[1]?></span>
			</div>
		</header>

		<hr>

		<div class="detalle-pedido">
			<h3 class="text-center">Detalle</h3 class="text-center">

			<?php foreach($productos as $producto): ?>
				<div class="producto">
					<h3 class="detalles"><?=$producto->nombre?></h3>
					<h4 class="detalles">Bs.F <?=$producto->precio_total?></h4>
					<h2 class="detalles">x<?=$producto->cantidad?></h2>
					<div class="acciones">
						<button class="btn btn-warning" title="Devolver">D</button>
						<button class="btn btn-danger" title="Eliminar">E</button>
					</div>
				</div>
			<?php endforeach; ?>
			
			<div class="col-md-4 col-md-offset-4">
				<a href="#" class="btn btn-success btn-block"><h2 class="pagar">Pagar</h2></a>
			</div>
		</div>
	</div>

	<script src="//code.jquery.com/jquery-2.1.3.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="<?=base_url('node_modules/mustache/mustache.min.js')?>"></script>
	<script src="<?=base_url('assets/js/tavo.js')?>"></script>
</body>
</html>