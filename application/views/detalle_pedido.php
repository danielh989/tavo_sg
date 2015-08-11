<div class="pedido-container">
    <div class="go-back">
        <a href="<?=base_url('/')?>"><span class="glyphicon glyphicon-th"></span></a>
    </div>
    <header>
        <h1 class="numero-mesa">Mesa <?=$detalle->numero?></h1>
        <div class="hidden" id="id_pedido" data-id-pedido="<?php echo $detalle->id ?>"></div>
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
            <a href="" class="pagar" data-toggle="modal" data-target="#opciones"><span class="glyphicon glyphicon-credit-card"></span><span class="title">Pagar</span></a>
        </div>
        <div class="btn-pedido btn-ordenar">
            <a href="#" class="ordenar" data-id="<?=$detalle->numero?>" data-toggle="modal" data-target="#opciones"><span class="glyphicon glyphicon-cutlery" data-toggle="modal" data-target="#pedido"></span><span class="title">Ordenar</span></a>
        </div>
        <div class="btn-pedido btn-ordenar">
            <a href="#" class="table-add" data-toggle="modal" data-target="#opciones"><span class="glyphicon glyphicon-transfer"></span><span class="title">Mesa</span></a>
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
        <?php else: ?>
            <h4 class="text-muted text-center">No hay productos devueltos</h4>
        <?php endif; ?>
    </div>
    <!-- Modal para Pedido-->
    <div class="table-container" style="background:#FFFFFF">
        <div class="modal order-modal fade" id="opciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h2 class="modal-title text-center" id="myModalLabel"></h2>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <template id="payment-body">
        <div class="row">
            <form action="<?php echo base_url('pedidos/pagar') ?>" id="pay-form" method="POST">
                <div class="col-md-12">
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

                <div class="col-md-12 payment-method">

                    <div class="etiquetas">
                        <label for="efectivo">Efectivo</label>
                        <label for="debito">Débito/Credito</label>
                    </div>
                    <div class="inputs">
                        <input type="text" name="efectivo" id="efectivo" value="0.00" spellcheck="false" maxlength="15">
                        <input type="text" name="debito" id="debito" value="0.00" spellcheck="false" maxlength="15">
                        <input hidden id="total_form" data-total="<?=$total?>" value="566">
                        <input hidden id="porc_des" data-descuento="<?=$porc_des?>">
                        <label><input type="radio" name="pago" value="efectivo"> Solo efectivo</label>
                        <label><input type="radio" name="pago" value="debito"> Solo debito</label>
                    </div>
                </div>
            </form>
        </div>
    </template>

    <template id="pagar-buttons">
        <button type="button" class="btn btn-danger-empty" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success" form="pay-form">Pagar</button>
        </form>
    </template>
            
        </div>
        
        <script src="<?=base_url('assets/js/base.min.js')?>"></script>
        <script src="<?=base_url('assets/js/tavo.min.js')?>"></script>
        <script>$(function(){ formatoPago(); gestionarPedidos(); opciones_pedido();})</script>
    </body>
</html>