<!DOCTYPE html>
<body>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Mesas | SG</title>

        <!-- Google Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
            <!-- Bootstrap -->
            <link href="<?=base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
            <!-- Custom Style -->
            <link rel="stylesheet" href="<?=base_url('assets/css/style.css')?>">
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
                        <a href="#">Cerrar Sesión</a>
                    </li>
                </ul>
            </nav>

            <div class="table-container">

                <!-- Mesas abiertas -->
                <?php foreach ($categorias as $row):?>
                <a href="#" class="table-unit agregar-categoria" data-toggle="modal" data-target="#myModal">
                <div class="number-wrapper">
                    <button type="button" class="close eliminar_categoria" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <p hidden data-id="<?=$row->id?>"></p>
                    <h4 data-nombre="<?=$row->nombre?>"><?=$row->nombre?></h4>
                </div>
                </a>
                <?php endforeach;?>

                <!-- Agregar mesa -->
                <a href="#" class="table-unit agregar-categoria" data-toggle="modal" data-target="#myModal">
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
                                <h2 class="modal-title text-center" id="myModalLabel">Editar Categoria</h2>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <form id="form-categoria" action="submit_categoria" method="post">
                                        <p><label for="nombre">Nombre</label></p>
                                        <input type="text" name="nombre" class="form-control">
                                        <input type="hidden" name="id">


                                    </div>
                                    <span class="error"></span>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" value="Guardar">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script src="<?=base_url('assets/js/jquery-2.1.4.min.js')?>"></script>
            <script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
            <script src="<?=base_url('node_modules/mustache/mustache.min.js')?>"></script>
            <script src="<?=base_url('assets/js/tavo.min.js')?>"></script>
        </body>
    </body>