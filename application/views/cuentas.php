<div class="container">
    <div class="row">
        <form action="cuentas" method="POST">
            <div class="col-md-4" >
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker9'>
                        <input readonly type='text' class="form-control" name="fecha" id="fecha" value="<?= $fecha_input ?>" />
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar">
                        </span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
                <input class="form-control" type="submit" value="Filtrar"></div>
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
                    <td><?= (empty($row->descuento)) ? '' : $row->descuento.'%' ?></td>
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
            <h3 class="panel-title">Efectivo+Debito</h3>
        </div>
        <div class="panel-body">
            <?= $totales->total_pagar  ?>
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

<script src="<?=base_url('assets/js/base.min.js')?>"></script>
<script src="<?=base_url('assets/js/tavo.min.js')?>"></script>
<script type="text/javascript">
                $(function () {
                    $('#datetimepicker9').datetimepicker({
                        viewMode: 'days'
                    ,
                    format: 'DD/MM/YYYY',
                    locale: 'es',
                    ignoreReadonly: true
                    });
                });
</script>
</body>
</html>