<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Title Page</title>
        <!-- Bootstrap CSS -->
        <link href="<?=base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
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

                     
                            <td><a href="<?=base_url("main/pedido/$row->id_pedido")?>"><?= $row->fecha ?></a></td>
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