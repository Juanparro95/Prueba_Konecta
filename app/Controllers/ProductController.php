<?php

class ProductController extends Controller
{
    function __construct()
    {
        if (!Auth::validate()) {
            Redirect::to('Home');
        }
    }

    /**
     * Metodo de la vista inicial del listado de Productos
     *
     * @return void
     */
    public function index()
    {
        $data = [
            'title' => 'Cafetería',
            'categories' => Category::list(KONECTA_CATEGORIES_TABLE),
            'products' => Product::all_paginated()
        ];

        Funciones::register_scripts([JS.'Product/Index.js'], "Script cafetería konecta");

        View::render('Index', $data);
    }
    /**
     * Metodo de la vista inicial del listado de Productos
     *
     * @return void
     */
    public function get_data()
    {
        try{
            $data = [
                'products' => Product::all_paginated()
            ];
            ob_start();
            include TABLES_VIEW."products.php";
            $templateFilePath = ob_get_contents();
            ob_end_clean();

            Funciones::json_output(Funciones::json_build(200, $templateFilePath));
        }catch (Exception $ex) {
            Funciones::json_output(Funciones::json_build(400, null, $ex->getMessage()));
        }
    }

    public function show($id)
    {
        try{

            if (!isset($id) && $id != null) {
                throw new Exception('Por favor ingresa el id del producto ha consultar');
            }

            $product = Product::list(KONECTA_PRODUCTS_TABLE, ['id' => $id], 1);

            Funciones::json_output(Funciones::json_build(200, $product));
        }catch (Exception $ex) {
            Funciones::json_output(Funciones::json_build(400, null, $ex->getMessage()));
        } catch (PDOException $pdoEx) {
            Funciones::json_output(Funciones::json_build(400, null, $pdoEx->getMessage()));
        }
    }

    /**
     * Metodo para guardar un nuevo producto
     *
     * @return void
     */
    public function store()
    {
        try {

            if (!validateCsrf(['name', 'reference', 'price', 'weight', 'category_id', 'stock'])) {
                throw new Exception('Acceso no autorizado, por favor valide todos los campos que no estén vacios.');
            }

            // Data pasada del formulario
            $name    = Funciones::clean($_POST['name']);
            $reference    = Funciones::clean($_POST['reference']);
            $price = $_POST['price'];
            $weight = $_POST['weight'];
            $category_id = $_POST['category_id'];
            $stock = $_POST['stock'];

            if(Product::list(KONECTA_PRODUCTS_TABLE, ['name' => $name], 1)){
                throw new Exception('El producto ya se encuentra registado en la cafetería');
            }

            if(!Product::add(KONECTA_PRODUCTS_TABLE, ['name' => $name,'reference' => $reference,'price' => $price,'weight' => $weight,'category_id' => $category_id,'stock' => $stock, 'created_at' => Funciones::now()])){
                throw new Exception('Hubo un error al registrar el producto, por favor intentelo de nuevo');
            }        
            
            Funciones::json_output(Funciones::json_build(200, null, "Se ha registrado el producto correctamente a la cafetería de Konecta."));

        } catch (Exception $ex) {
            Funciones::json_output(Funciones::json_build(400, null, $ex->getMessage()));
        } catch (PDOException $pdoEx) {
            Funciones::json_output(Funciones::json_build(400, null, $pdoEx->getMessage()));
        }
    }

    /**
     * Metodo para actualizar un producto
     *
     * @return void
     */
    public function update()
    {
        try {

            if (!validateCsrf(['id', 'name', 'reference', 'price', 'weight', 'category_id', 'stock'])) {
                throw new Exception('Acceso no autorizado, por favor valide todos los campos que no estén vacios.');
            }

            // Data pasada del formulario
            $id = $_POST['id'];
            $name    = Funciones::clean($_POST['name']);
            $reference    = Funciones::clean($_POST['reference']);
            $price = $_POST['price'];
            $weight = $_POST['weight'];
            $category_id = $_POST['category_id'];
            $stock = $_POST['stock'];

            if(!Product::list(KONECTA_PRODUCTS_TABLE, ['id' => $id], 1)){
                throw new Exception('El producto no existe en la cafetería de Konecta');
            }

            if(!Product::update(KONECTA_PRODUCTS_TABLE, ['id' => $id], ['name' => $name,'reference' => $reference,'price' => $price,'weight' => $weight,'category_id' => $category_id,'stock' => $stock, 'created_at' => Funciones::now()])){
                throw new Exception('Hubo un error al actualizar el producto, por favor intentelo de nuevo');
            }        
            
            Funciones::json_output(Funciones::json_build(200, null, "Se ha registrado el producto correctamente a la cafetería de Konecta."));

        } catch (Exception $ex) {
            Funciones::json_output(Funciones::json_build(400, null, $ex->getMessage()));
        } catch (PDOException $pdoEx) {
            Funciones::json_output(Funciones::json_build(400, null, $pdoEx->getMessage()));
        }
    }

    /**
     * Metodo que elimina el producto seleccionado
     *
     * @param [type] $idProduct
     * @return void
     */
    public function destroy($idProduct)
    {
        try{

            if (!isset($idProduct) && $idProduct != null) {
                throw new Exception('Por favor ingresa el id del producto para eliminarlo');
            }

            if(!$product = Product::list(KONECTA_PRODUCTS_TABLE, ['id' => $idProduct], 1)){
                throw new Exception('El producto no está registado en la cafetería');
            }

            Product::remove(KONECTA_PRODUCTS_TABLE, ['id' => $idProduct], 1);

            Funciones::json_output(Funciones::json_build(200, null, "El producto ".$product['name']." se ha eliminado correctamente."));
        }catch (Exception $ex) {
            Funciones::json_output(Funciones::json_build(400, null, $ex->getMessage()));
        } catch (PDOException $pdoEx) {
            Funciones::json_output(Funciones::json_build(400, null, $pdoEx->getMessage()));
        }
    }

    /**
     * Metodo que devuelve todos los productos existentes
     *
     * @return void
     */
    public function all()
    {
        try{
            $product = Product::list(KONECTA_PRODUCTS_TABLE);
            Funciones::json_output(Funciones::json_build(200, $product));
        }catch (Exception $ex) {
            Funciones::json_output(Funciones::json_build(400, null, $ex->getMessage()));
        } catch (PDOException $pdoEx) {
            Funciones::json_output(Funciones::json_build(400, null, $pdoEx->getMessage()));
        }
    }
   
}
