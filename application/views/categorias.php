
            <div class="categorias-container">
                <div class="header text-center">
                    <h2 class="page-header">Categorias</h2>
                    <a class="add-categoria" data-toggle="modal" data-target="#myModal">Nueva categoria</a>
                </div>

                <!-- Mesas abiertas -->
                <?php foreach ($categorias as $row):?>
                <div class="pill agregar-categoria" data-id="<?php echo $row->id ?>" data-toggle="modal" data-target="#myModal">
                    <button type="button" class="btn btn-danger eliminar_categoria" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 data-nombre="<?=$row->nombre?>"><?=$row->nombre?></h4>
                </div>
                <?php endforeach;?>

            </div>
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
                                    <form id="form-categoria" action="categorias/add" method="post" class="form-horizontal">

                                        <div class="form-group">
                                            <div class="col-md-8 col-md-offset-2">
                                                <label for="nombre">Nombre</label>
                                                <input type="text" name="nombre" class="form-control">
                                                <input type="hidden" name="id">
                                            </div>
                                        </div>

                                    </div>
                                    <span class="error"></span>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-success btn-block" value="Guardar">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script src="<?=base_url('assets/js/base.min.js')?>"></script>
            <script src="<?=base_url('assets/js/tavo.min.js')?>"></script>
            <script>$(function(){ gestionarCategorias(); })</script>
        </body>
    </body>