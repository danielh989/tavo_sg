<div class="container">
    <div class="row">
        <form action="cuentas" method="POST">
            <div class="col-sm-6" style="height:130px;">
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker9'>
                        <input type='text' class="form-control" name="fecha" id="fecha" />
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar">
                        </span>
                        </span>

                    </div>
                    <span><input type="submit" value="Filtrar"></span>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-8 col-md-offset-2">
        <!-- Button trigger modal -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Pedido</th>
                    <th>Mesa</th>
                    <th>A pagar</th>
                    <th>P. Debito</th>
                    <th>P. Efectivo</th>
                    <th>Devuelto</th>
                    <th>Desc. F.</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cuentas as $row): ?>
                <td><a href="<?=base_url("pedidos/detalle/$row->id_pedido")?>"><?= $row->fecha ?></a></td>
                <td><?= $row->numero_mesa ?></td>
                <td><?= $row->total_pagar ?></td>
                <td><?= $row->debito ?></td>
                <td><?= $row->efectivo ?></td>
                <td><?= $row->total_devuelto ?></td>
                <td><?= $row->descuento ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>


</div>

<div class="col-md-2">
    <div class="panel panel-default">
          <div class="panel-heading">
                <h3 class="panel-title">A pagar</h3>
          </div>
          <div class="panel-body">
                <?= $totales->total_pagar  ?>
          </div>
    </div>
</div>

<div class="col-md-2">
    <div class="panel panel-default">
          <div class="panel-heading">
                <h3 class="panel-title">Pagado</h3>
          </div>
          <div class="panel-body">
                <?= $totales->total_pagar  ?>
          </div>
    </div>
</div>

<div class="col-md-2">
    <div class="panel panel-default">
          <div class="panel-heading">
                <h3 class="panel-title">Efectivo</h3>
          </div>
          <div class="panel-body">
                <?= $totales->efectivo  ?>
          </div>
    </div>
</div>

<div class="col-md-2">
    <div class="panel panel-default">
          <div class="panel-heading">
                <h3 class="panel-title">Debito</h3>
          </div>
          <div class="panel-body">
                <?= $totales->debito  ?>
          </div>
    </div>
</div>

<div class="col-md-2">
    <div class="panel panel-default">
          <div class="panel-heading">
                <h3 class="panel-title">Perdida</h3>
          </div>
          <div class="panel-body">
                <?= $totales->perdida  ?>
          </div>
    </div>
</div>

</div>
<!-- jQuery -->
<script src="<?=base_url('assets/js/jquery-2.1.4.min.js')?>"></script>
<!-- Bootstrap JavaScript -->
<script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
<!-- Custom JS -->
<script src="<?=base_url('assets/js/tavo.min.js')?>"></script>
<script src="<?=base_url('assets/js/moment-with-locales.min.js')?>"></script>
<script src="<?=base_url('assets/js/bootstrap-datetimepicker.min.js')?>"></script>
<script type="text/javascript">
                $(function () {
                    $('#datetimepicker9').datetimepicker({
                        viewMode: 'days'
                    ,
                    format: 'DD/MM/YYYY',
                    locale: 'es'});
                });
</script>


</body>
</html>