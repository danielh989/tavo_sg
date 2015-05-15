
		<div class="container">
				<form action="descuento/update" method="POST" role="form">
					<legend>Descuento Familiar</legend>
					<div class="col-md-6">

						<div class="form-group">
							<label for="">Descuento</label>
							<input type="text" class="form-control" value="<?=$descuento->valor?>" name="descuento" placeholder="Descuento">
						</div>

						<button type="submit" class="btn btn-primary">Guardar</button>
					</div>
				</form>
		</div>

		<script src="assets/js/base.min.js"></script>
	</body>
</html>