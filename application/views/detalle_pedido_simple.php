
	<div class="pedido-container">
	
		<header>
			<h1 class="numero-mesa">Mesa <?=$detalle->numero?></h1>

		</header>

		<hr>
		
		<div class="pedido-opciones">

			<div class="total-pedido">
				<?php if(empty($total)): ?>
					<span>Bs.F </span>0
				<?php else: ?>
					<span>Bs.F </span><?=$total_f[0]?><span>.<?=$total_f[1]?></span>
				<?php endif; ?>
				<h4 class="text-center">Total Orden</h4>
			</div>




		</div>
		<div><?= (($detalle->descuento) ? 'Con '.$detalle->descuento.'% de descuento familiar.' : '') ?></div>

		<div class="detalle-pedido">
			<h4 class="text-center" style="font-weight:800;text-transform:uppercase">Detalle Orden</h4>
			<?php $productos = array_filter($productos); ?>
			<?php if(!empty($productos)): ?>
				<?php foreach($productos as $producto): ?>
					<div class="producto">
						<h3 class="detalles name"><?=$producto->nombre?></h3>
						<h2 class="detalles qty">x<?=$producto->cantidad?></h2>
						<h4 class="detalles">Bs.F <?=$producto->precio_total?></h4>
						
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<h2 class="text-center" style="color:#828282">No hay productos</h2>
			<?php endif; ?>
		</div>

		<div class="detalle-pedido">
			<h4 class="text-center" style="font-weight:800;text-transform:uppercase">Productos Devueltos</h4>
			<?php $devoluciones = array_filter($devoluciones); ?>
			<?php if(!empty($devoluciones)): ?>
				<?php foreach($devoluciones as $row): ?>
					<div class="producto">
						<h3 class="detalles name"><?=$row->nombre?></h3>
						<h2 class="detalles qty">x<?=$row->cantidad?></h2>
						<h4 class="detalles">Bs.F <?=$row->precio_total?></h4>
						
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
</div>



	<script src="<?=base_url('assets/js/base.min.js')?>"></script>
	<script src="<?=base_url('assets/js/tavo.min.js')?>"></script>
	<script>$(function(){ formatoPago(); gestionarPedidos();})</script>
</body>
</html>