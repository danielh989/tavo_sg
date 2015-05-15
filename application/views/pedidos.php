
	
	<div class="table-container">
		
		<!-- Mesas abiertas -->

		<?php foreach ($mesas_activas as $row):?>
			<a href="<?=base_url('pedidos/detalle/'.$row->id_pedido)?>" class="table-unit">
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
	
	<script src="<?=base_url('assets/js/jquery-2.1.4.min.js')?>"></script>
	<script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
	<script src="<?=base_url('node_modules/mustache/mustache.min.js')?>"></script>
	<script src="<?=base_url('assets/js/tavo.min.js')?>"></script>
	<script>
	$(document).ready(function(){ crearOrden(); })</script>
</body>
</body>