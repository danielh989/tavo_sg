
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
                            <td class="categoria" data-idcat="<?=$row->id_cat?>"><?= $row->categoria ?></td>
                            <td class="descripcion"><?= $row->descripcion ?></td>
                            <td class="precio"><?= $row->precio ?></td>
                            <td>
                                <span><button class="btn btn-default btn-editar" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-edit" type="submit"></span></button></span>
                                <span><button class="btn btn-default btn-eliminar" data-toggle="modal" data-target="#eliminarProducto"><span class="glyphicon glyphicon-remove" type="submit"></span></button></span>
                            </td>
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
                        <form action="productos/add" id="producto" method="post">
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

        <script src="<?=base_url('assets/js/base.min.js')?>"></script>
        <script src="<?=base_url('assets/js/tavo.min.js')?>"></script>
        <script>$(function(){ gestionarProductos(); })</script>
    </body>
</html>