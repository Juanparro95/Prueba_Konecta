<?php

class AuthController extends Controller
{
    private $typeTemplate = TEMPLATE_AUTH;

    function __construct()
    {
        if (Auth::validate()) {
            Redirect::to('Home');
        }
    }

    /**
     * Vista inicial de Autenticación
     *
     * @return void
     */
    public function index()
    {
        $data = [
            'title' => 'Ingresar a tu cuenta',
        ];

        View::render('login', $data, $this->typeTemplate);
    }

    /**
     * Método que retorna al usuario la vista para registrarse
     *
     * @return void
     */
    public function register()
    {
        $data = [
            'title' => 'Crear nueva cuenta',
        ];

        Funciones::register_scripts([JS.'Auth/Register.js'], "Script registro a la plataforma");

        View::render('Register', $data, $this->typeTemplate);
    }

    /**
     * Metodo que obtiene los datos de registro del usuario
     *
     * @return {
     *  1. Si el correo ya existe, retorna un error
     *  2. Si es un nuevo usuario, retorna 201
     * }
     */
    public function post_register(){
        try {
            if (!validateCsrf(['full_name', 'email', 'password'])) {
                throw new Exception('Acceso no autorizado');
            }

            // Data pasada del formulario
            $full_name    = Funciones::clean($_POST['full_name']);
            $email    = Funciones::clean($_POST['email']);
            $password = Funciones::clean($_POST['password']);
            $username = explode(" ", $full_name)[0].uniqid();

            if(Users::list(KONECTA_USERS_TABLE, ['email' => $email], 1)){
                throw new Exception('El correo ya se encuentra registrado en el sistema');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('El correo electrónico no es válido.');
            }

            $passwordEncrypt = password_hash($password.$_ENV['AUTH_SALT'], PASSWORD_BCRYPT);

            if(!$user = Users::add(KONECTA_USERS_TABLE, ['username' => $username, 'email' => $email, 'password' => $passwordEncrypt, 'name' => $full_name, 'created_at' => Funciones::now()])){
                throw new Exception('Hubo un error al registrar el usuario, por favor intentelo de nuevo');
            }

            $newUser = Users::list(KONECTA_USERS_TABLE, ['email' => $email], 1);

            Auth::login($newUser['id'], $newUser);
            Redirect::to('Home');

        } catch (Exception $ex) {
            Flasher::new($ex->getMessage(), 'danger');
            Redirect::back();
        } catch (PDOException $pdoEx) {
            Flasher::new($pdoEx->getMessage(), 'danger');
            Redirect::back();
        }
    }

    /**
     * Metodo que valida si el usuario existe y lo almacena en una sesion
     *
     * @return void
     */
    public function login()
    {
        try {
            if (!validateCsrf(['email', 'password'])) {
                throw new Exception('Acceso no autorizado');
            }

            $email    = Funciones::clean($_POST['email']);
            $password = Funciones::clean($_POST['password']);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('El correo electrónico no es válido.');
            }

            if(!$user = Users::list(KONECTA_USERS_TABLE, ['email' => $email], 1)){
                throw new Exception('El correo y/o contraseña no están registrados en el sistema.');
            }

            if (!password_verify($password.$_ENV['AUTH_SALT'], $user['password'])) {
                throw new Exception('El correo y/o contraseña no son correctas.');
            }

            Auth::login($user['id'], $user);
            Redirect::to('home');

        } catch (Exception $ex) {
            Flasher::new($ex->getMessage(), 'danger');
            Redirect::back();
        } catch (PDOException $pdoEx) {
            Flasher::new($pdoEx->getMessage(), 'danger');
            Redirect::back();
        }
    }
}
