
        <div class="container">
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


        <!-- jQuery -->
        <script src="<?=base_url('assets/js/jquery-2.1.4.min.js')?>"></script>
        <!-- Bootstrap JavaScript -->
        <script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
        <!-- Custom JS -->
        <script src="<?=base_url('assets/js/built.js')?>"></script>

        
    </body>
</html>