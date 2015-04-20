<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Title Page</title>
        <!-- Bootstrap CSS -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container">

            <div class="col-md-8 col-md-offset-2">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success btn-agregar" data-toggle="modal" data-target="#myModal">
                Agregar
                </button>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $row): ?>
                        <tr data-id-producto="<?= $row->id ?>">
                            <td class="nombre"><?= $row->nombre ?></td>
                            <td class="categoria"><?= $row->categoria ?></td>
                            <td class="descripcion"><?= $row->descripcion ?></td>
                            <td class="precio"><?= $row->precio ?></td>
                            <td>
                                <span><button class="btn btn-default btn-editar" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-edit" type="submit"></span></button></span>
                                <span><button class="btn btn-default"><span class="glyphicon glyphicon-remove" type="submit"></span></button></span>
                            </td>
                        </tr>
                        <?php endforeach ?>


                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Agregar Producto</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group row">

                            <div class="col-md-6">

                                <input type="text" name="nombre" class="form-control" placeholder="Nombre"><p></p>
                                <div class="input-group">

                                    <input type="text" name="precio" class="form-control" id="precio" placeholder="Precio">
                                    <div class="input-group-addon">Bs.F.</div>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <select name="categorias" id="categorias" class="form-control" placeholder="Categoría">
                                    <option value="">Categoría</option>
                                </select><p></p>
                                <textarea name="descripcion" id="" cols="30" rows="6" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- jQuery -->
        <script src="//code.jquery.com/jquery.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <!-- Custom JS -->
        <script src="<?=base_url('assets/js/tavo.js')?>"></script>
    </body>
</html>