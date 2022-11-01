<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">INSTRUCCIONES</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <p>        Para iniciar, ingresar al menu izquierdo y seleccionar cualquiera, el primero para agregar productos, el segundo para comprarlos
</p>
        <h2>Consultas SQL</h2>
        <pre>
            <p>1. SELECT name, reference, price, weight, category_id, MAX(stock) FROM konecta_products</p>
            <p>2. SELECT p.name, SUM(s.amount) as 'Mas vendido' FROM konecta_products p 
                JOIN konecta_shoppings s ON s.product_id = p.id
                GROUP BY p.id
                ORDER BY SUM(s.amount) DESC</p>
        </pre>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->