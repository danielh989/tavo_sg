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
                            <td><a href="<?=base_url("main/pedido/$row->id")?>"><?= $row->fecha ?></a></td>
                            
                   
                        </tr>
                        <?php endforeach ?>


                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Editar -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Agregar Producto</h4>
                    </div>
                    <div class="modal-body">
                        <span class="error"></span>
                        <form action="agregar_producto" id="producto" method="post">
                            <div class="form-group row">

                                <div class="col-md-6">
                                    <input type="text" hidden name="id" value="">
                                    <input type="text" name="nombre" class="form-control" placeholder="Nombre"><p></p>
                                    <div class="input-group">
                                        <input type="text" name="precio" class="form-control" id="precio" placeholder="Precio">
                                        <div class="input-group-addon">Bs.F.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <select name="id_cat" id="id_cat" class="form-control" placeholder="Categoría">
                                        <option value="">Categoría</option>
                                    </select><p></p>
                                    <textarea name="descripcion" id="" cols="30" rows="6" class="form-control"></textarea>
                                </div>
                            </div>  
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary btn-guardar">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Eliminar -->
        <div class="modal fade" id="eliminarProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Eliminar Producto?</h4>
              </div>
              <div class="modal-body">
                <p>El producto se eliminara permanentemente</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a type="button" href="" class="btn btn-danger">Continuar</a>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- jQuery -->
        <script src="<?=base_url('assets/js/jquery-2.1.4.min.js')?>"></script>
        <!-- Bootstrap JavaScript -->
        <script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
        <!-- Custom JS -->
        <script src="<?=base_url('assets/js/built.js')?>"></script>
    </body>
</html>