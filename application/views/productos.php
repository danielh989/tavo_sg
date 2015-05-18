
        <div class="container-fluid">
          <div class="col-md-12">
            <!-- Button trigger modal -->
            <table class="table table-striped">

              <tr class="new-entry">
                <td><a data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus-sign"></span> Agregar Producto</a></td>
                <td colspan="6" class="text-right">
                  <a href="#" class="export"><span class="glyphicon glyphicon-file"></span> Exportar</a>
                  <a href="#"><span class="glyphicon glyphicon-print"></span> Imprimir</a>
                </td>
              </tr>

              <tr class="table-info">
                <th>Producto</th>
                <th>Categoría</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th class="text-right acciones">Acciones</th>
              </tr>

              <?php foreach ($productos as $row): ?>
                <tr data-id-producto="<?= $row->id ?>">
                  <td class="nombre"><?= $row->nombre ?></td>
                  <td class="categoria" data-idcat="<?=$row->id_cat?>"><?= $row->categoria ?></td>
                  <td class="descripcion"><?= $row->descripcion ?></td>
                  <td class="precio"><?= $row->precio ?></td>
                  <td class="text-right edit-col acciones">
                    <a class="btn-editar" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil" type="submit"></span></a>
                    <a data-toggle="modal" data-target="#eliminarProducto"><span class="glyphicon glyphicon-remove-sign" type="submit"></span></a>
                  </td>
                </tr>
              <?php endforeach; ?>

              <tr class="table-info">
              	<td colspan="5">Total entradas: </td>
              </tr>

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