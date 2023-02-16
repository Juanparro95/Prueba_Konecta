<?php

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

    /**
     * Metodo para mostrar todas las compras
     */

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
     * Metodo para guardar una nueva compra
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

            if(!Shopping::add(KONECTA_SHOPPING_TABLE, ['product_id' => $id,'amount' => $amount, 'user_id' => Funciones::getUser('id') ,'created_at' => Funciones::now()])){
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

   
}
