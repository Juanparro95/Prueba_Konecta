<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Listado</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createProduct">
                <i class="fas fa-plus"></i> Agregar Producto
            </button>
        </div>
    </div>
    <div class="card-body">
        <?php

        use ParroFramework\Functions\Funciones;

        if (!empty($d->products->rows)) : ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">#</th>
                            <th class="text-center">PRODUCTO</th>
                            <th class="text-center">PRECIO</th>
                            <th class="text-center">PESO</th>
                            <th class="text-center">STOCK</th>
                            <th class="text-center" width="10%">ACCION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($d->products->rows as $product) : ?>
                            <tr>
                                <td align="center"><?= $product->id ?></td>
                                <td align="center"><?= $product->name ?></td>
                                <td align="center"><?= $product->price ?></td>
                                <td align="center"><?= $product->weight ?></td>
                                <td align="center">
                                    <?php if ($product->stock > 10) : ?>
                                        <span class="badge badge-success"><?= "Disponibles: " . $product->stock ?></span>
                                    <?php elseif ($product->stock > 5 && $product->stock < 9) : ?>
                                        <span class="badge badge-info"><?= "Quedan: " . $product->stock ?></span>
                                    <?php elseif ($product->stock > 1 && $product->stock < 4) : ?>
                                        <span class="badge badge-warning"><?= "Solo quedaN: " . $product->stock ?></span>
                                    <?php else : ?>
                                        <span class="badge badge-danger">Sin Stock</span>
                                    <?php endif ?>

                                </td>
                                <td align="center">
                                    <div class="button-group">
                                        <button class="btn btn-outline-info edit_product" data-id="<?= $product->id ?>"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-outline-danger delete_product" data-id="<?= $product->id ?>" data-name="<?= $product->name ?>"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php echo $d->products->pagination; ?>
            </div>
        <?php else : ?>
            <div class="py-5 text-center">
                <img src="<?php echo IMAGES . 'undraw_empty.png'; ?>" alt="No hay registros" style="width: 250px;">
                <p class="text-muted">No hay registros en la base de datos.</p>
            </div>
        <?php endif; ?>

    </div>
    <!-- /.card-body -->
    <div class="card-footer">

    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->

<!-- Modal -->
<div class="modal fade" id="createProduct" tabindex="-1" aria-labelledby="createProductLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="nuevo_producto_form">
                <?= Funciones::insert_inputs(); ?>
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Nombre:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Referencia:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="reference" name="reference">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Precio:</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="price" name="price">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Peso:</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="weight" name="weight">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Categoría:</label>
                        <div class="col-sm-10">
                            <select name="category_id" id="category_id" class="form-control">
                                <?php foreach ($d->categories as $category) : ?>
                                    <option value="<?php echo $category->id ?>"><?php echo $category->name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Stock:</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="stock" name="stock">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeModal" data-dismiss="modal">Cerrar Ventana</button>
                    <button type="button" class="btn btn-primary" id="buttonSave">Guardar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>