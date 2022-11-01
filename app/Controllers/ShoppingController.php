<?php

use ParroFramework\Configs\Controller;
use ParroFramework\Configs\Flasher;
use ParroFramework\Configs\Redirect;
use ParroFramework\Configs\View;
use ParroFramework\Functions\Funciones;

class ShoppingController extends Controller
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
            'title' => 'Tienda',
        ];

        Funciones::register_scripts([JS.'Shopping/Index.js'], "Script Tienda konecta");

        View::render('Index', $data);
    }

    public function show()
    {
        try{
            $product = Shopping::getAll();
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

            $id = $_POST['id'];
            $amount = $_POST['amount'];

            if(!$product = Product::list(KONECTA_PRODUCTS_TABLE, ['id' => $id], 1)){
                throw new Exception('El producto no existe en la cafetería');
            }

            if($product['stock'] == '0'){
                throw new Exception('Lo sentimos, el producto "'.$product['name'].'" no tiene stocks disponibles.');
            }

            if($amount > $product['stock']){
                throw new Exception('Lo sentimos, la cantidad supera el stock del producto, solo tenemos disponibles "'.$product['stock'].'" productos');
            }

            if(!Shopping::add(KONECTA_SHOPPING_TABLE, ['product_id' => $id,'amount' => $amount, 'created_at' => Funciones::now()])){
                throw new Exception('Hubo un error al registrar la compra, por favor intentelo de nuevo');
            }        

            $newStock = $product['stock'] - $amount;

            if(!Product::update(KONECTA_PRODUCTS_TABLE, ['id' => $id], ['stock' => $newStock])){
                throw new Exception('Hubo un error al actualizar el producto, por favor intentelo de nuevo');
            }  
            
            Funciones::json_output(Funciones::json_build(200, null, "Se ha registrado la compra correctamente."));

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
   
}
