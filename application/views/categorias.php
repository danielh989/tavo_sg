

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
                                    <form id="form-categoria" action="categorias/add" method="post">
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
            <script>
    $(document).ready(function(){ gestionarCategorias(); })</script>
        </body>
    </body>