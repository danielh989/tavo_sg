<div class="pedido-container">
    <div class="go-back">
        <a href="<?=base_url('/')?>"><span class="glyphicon glyphicon-th"></span></a>
    </div>
    <header>
        <h1 class="numero-mesa">Mesa <?=$detalle->numero?></h1>
    </header>
    <hr>
    <div class="pedido-opciones">
        <div class="total-pedido">
            <?php if(empty($total)): ?>
            <span>Bs.F </span>0
            <?php else: ?>
            <span>Bs.F </span><?=$total_f[0]?><span>.<?=$total_f[1]?></span>
            <?php endif; ?>
            <h4 class="text-center">Total Orden</h4>
        </div>
        <div class="btn-pedido">
            <a href="" data-toggle="modal" data-target="#modalPagar"><span class="glyphicon glyphicon-credit-card"></span><span class="title">Pagar</span></a>
        </div>
        <div class="btn-pedido btn-ordenar">
            <a href="#"><span class="glyphicon glyphicon-cutlery" data-toggle="modal" data-target="#pedido"></span><span class="title">Ordenar</span></a>
        </div>
        <div class="btn-pedido btn-ordenar">
            <a href="#" class="table-add" data-toggle="modal" data-target="#mesa"><span class="glyphicon glyphicon-transfer"></span><span class="title">Mesa</span></a>
        </div>
    </div>
    <div class="detalle-pedido">
        <h4 class="text-center" style="font-weight:800;text-transform:uppercase">Detalle Orden</h4>
        <?php $productos = array_filter($productos); ?>
        <?php if(!empty($productos)): ?>
        <?php foreach($productos as $producto): ?>
        <div class="producto">
            <h3 class="detalles name"><?=$producto->nombre?></h3>
            <h2 class="detalles qty">x<?=$producto->cantidad?></h2>
            <h4 class="detalles">Bs.F <?=$producto->precio_total?></h4>
            <div class="acciones">
                <button data-pedido="<?=$detalle->id?>" data-producto="<?=$producto->id_producto?>" class="btn btn-warning btn-pedido btn-devolver" title="Devolver">Devolver</button>
                <button data-pedido="<?=$detalle->id?>" data-producto="<?=$producto->id_producto?>" class="btn btn-danger btn-pedido btn-eliminar" title="Eliminar">Eliminar</button>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <h2 class="text-center" style="color:#828282">No hay productos</h2>
        <?php endif; ?>
    </div>
    <div class="detalle-pedido">
        <h4 class="text-center" style="font-weight:800;text-transform:uppercase">Productos Devueltos</h4>
        <?php $devoluciones = array_filter($devoluciones); ?>
        <?php if(!empty($devoluciones)): ?>
        <?php foreach($devoluciones as $row): ?>
        <div class="producto">
            <h3 class="detalles name"><?=$row->nombre?></h3>
            <h2 class="detalles qty">x<?=$row->cantidad?></h2>
            <h4 class="detalles">Bs.F <?=$row->precio_total?></h4>
            <div class="acciones">
                <button data-pedido="<?=$detalle->id?>" data-producto="<?=$row->id_producto?>" class="btn btn-danger btn-pedido btn-eliminar-devuelto" title="Eliminar">Eliminar</button>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <!-- Modal para Pedido-->
    <div class="modal order-modal fade" id="mesa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h2 class="modal-title text-center" id="myModalLabel">Agregar Producto</h2>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para Pagar-->
    <div class="modal fade" id="modalPagar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Pagar</h4>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <form action="/tavo_sg/pedidos/pagar" id="pay-form" method="POST">
                            <div class="pull-right">

                                <label><input type="checkbox" name="descuento" id="descuento">Descuento Familiar</label>
                            </div>

                            <div class="total-pedido">
                                <?php if(empty($total)): ?>
                                <span>Bs.F </span>0
                                <?php else: ?>
                                <span>Bs.F </span><span  id="total_0"><?=$total_f[0]?></span><span id="total_1">.<?=$total_f[1]?></span>
                                <?php endif; ?>
                                <h4 class="text-center">Total Orden</h4>
                            </div>
                        </div>
                        <div class="row payment-method">

                            <div class="etiquetas">
                                <label for="efectivo">Efectivo</label>
                                <label for="debito">Débito/Credito</label>
                            </div>
                            <div class="inputs">
                                <input type="text" name="efectivo" id="efectivo" value="0.00" spellcheck="false" maxlength="15">
                                <input type="text" name="debito" id="debito" value="0.00" spellcheck="false" maxlength="15">
                                <input hidden id="total_form" data-total="<?=$total?>">
                                <input hidden id="porc_des" data-descuento="<?=$porc_des?>">
                                <label><input type="radio" name="pago" value="efectivo"> Solo efectivo</label>
                                <label><input type="radio" name="pago" value="debito"> Solo debito</label>
                            </div>
                        </div>
                        </div><!-- Cierra modal-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger-empty" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Pagar</button>
                        </form>
                        </div> <!-- Cierra modal-footer -->
                    </div>
                </div>
            </div>
            <!-- Plantilla para mesas -->
            <template id="select-table">
            <a href="#" class="mesa-libre" data-id="{{id}}">
            <div class="number-wrapper">
                <h2 class="number">{{numero}}</h2>
            </div>
            </a>
            </template>
            <!-- Plantilla de categorias -->
            <template id="categorias-template">
            <a href="#" class="categoria" data-id="{{id}}">
            <div class="number-wrapper">
                <h2 class="number text-center">{{nombre}}</h2>
            </div>
            </a>
            </template>
            <template id="btn-completar">
            <button class="btn btn-success btn-block btn-completar">Completar</button>
            </template>
            <template id="back-button">
            <div class="btn-wrapper">
                <a href="#" class="btn-atras">
                <span class="arrow"></span>
                <span class="arrow-inner"></span>
                <span class="button">Atrás</span>
                </a>
            </div>
            </template>
            <template id="productos-template">
            <a href="#" class="producto" data-id="{{id}}">
            <div class="number-wrapper">
                <h2 class="number">{{nombre}}</h2>
                <div class="precio">{{precio}} Bs.F</div>
                <div class="cantidad">{{cantidad}}</div>
                <div class="btn-group" role="group" aria-label="...">
                    <button type="button" data-id="{{id}}" class="btn btn-default"><span class="glyphicon glyphicon-minus"></span></button>
                    <button type="button" data-id="{{id}}" class="btn btn-default btn-agregar"><span class="glyphicon glyphicon-plus"></span></button>
                </div>
            </div>
            </a>
            </template>
        </div>
<<<<<<< HEAD

=======
        
>>>>>>> eb44d186ab8ba6945a49418272bae2c503f99b14
        <script src="<?=base_url('assets/js/base.min.js')?>"></script>
        <script src="<?=base_url('assets/js/tavo.min.js')?>"></script>
        <script>$(function(){ formatoPago(); gestionarPedidos();})</script>
    </body>
</html>