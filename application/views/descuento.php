
		<div class="container">
		<form action="descuento/update" method="POST" role="form">
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