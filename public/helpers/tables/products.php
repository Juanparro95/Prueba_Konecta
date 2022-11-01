<?php

use ParroFramework\Functions\Funciones;

if (!empty($data['products']['rows'])) : ?>
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
                <?php foreach ($data['products']['rows'] as $product) : ?>
                    <tr>
                        <td align="center"><?= $product['id'] ?></td>
                        <td align="center"><?= $product['name'] ?></td>
                        <td align="center"><?= $product['price'] ?></td>
                        <td align="center"><?= $product['weight'] ?></td>
                        <td align="center">
                            <?php if ($product['stock'] > 10) : ?>
                                <span class="badge badge-success"><?= "Disponibles: " . $product['stock'] ?></span>
                            <?php elseif ($product['stock'] > 5 && $product['stock'] < 9) : ?>
                                <span class="badge badge-info"><?= "Quedan: " . $product['stock'] ?></span>
                            <?php elseif ($product['stock'] > 1 && $product['stock'] < 4) : ?>
                                <span class="badge badge-warning"><?= "Solo quedaN: " . $product['stock'] ?></span>
                            <?php else : ?>
                                <span class="badge badge-danger">Sin Stock</span>
                            <?php endif ?>

                        </td>
                        <td align="center">
                            <div class="button-group">
                                <button class="btn btn-outline-info edit_product" data-id="<?= $product['id'] ?>"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-outline-danger delete_product" data-id="<?= $product['id'] ?>" data-name="<?= $product['name'] ?>"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php echo$data['products']['pagination']; ?>
    </div>
<?php else : ?>
    <div class="py-5 text-center">
        <img src="<?php echo IMAGES . 'undraw_empty.png'; ?>" alt="No hay registros" style="width: 250px;">
        <p class="text-muted">No hay registros en la base de datos.</p>
    </div>
<?php endif; ?>


<script src="<?= JS.'Product/Index.js' ?>"></script>