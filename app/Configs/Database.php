<?php 

namespace ParroFramework\Configs;

use Exception;
use ParroFramework\Functions\Funciones;
use ParroFramework\Helpers\Helper;
use PDO;
use PDOException;

class Database
{
  private $link = null;
  private $engine;
  private $host;
  private $name;
  private $user;
  private $pass;
  private $charset;
  private $options;
  
  /**
   * Constructor para nuestra clase
   */
  public function __construct()
  {
    $this->engine  = Helper::connection()['engine'];
    $this->name    = Helper::connection()['database'];
    $this->user    = Helper::connection()['username'];
    $this->pass    = Helper::connection()['password'];
    $this->charset = Helper::connection()['charset'];
    $this->host    = Helper::connection()['host'];
    $this->options = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false
		];

    return $this;    
  }

  /**
   * Método para abrir una conexión a la base de datos
   * @param bool $throw_exception | para evitar die en error, en caso de no existe la conexión lanza excepción
   *
   * @return mixed
   */
  public static function connect($throw_exception = false) 
  {
    try {
      $self       = new self();
      if ($self->link !== null) return $self->link;
      $self->link = new PDO($self->engine.':host='.$self->host.';dbname='.$self->name.';charset='.$self->charset, $self->user, $self->pass, $self->options);
      return $self->link;
    } catch (PDOException $e) {
      if ($throw_exception === true) {
        throw new Exception($e->getMessage());
      }
      Funciones::logger("Error al conectarse a la base de datos: Mensaje (" . $e->getMessage() . ")", ERRORES_LOG[5]);
      die(sprintf('No hay conexión a la base de datos, hubo un error: %s', $e->getMessage()));
    }
  }

  /**
   * Método para hacer un query a la base de datos
   *
   * @param string $sql
   * @param array $params
   * @param integer $transaction
   * @return mixed
   */
  public static function query($sql, $params = [], $options = [])
  {
    $id          = null;
    $last_id     = false;
    $transaction = isset($options['transaction']) ? ($options['transaction'] === true ? true : false) : true;
    $debug       = isset($options['debug']) ? ($options['debug'] === true ? true : false) : false;
    $start       = isset($options['start']) ? ($options['start'] === true ? true : false) : false;
    $commit      = isset($options['commit']) ? ($options['commit'] === true ? true : false) : false;
    $rollback    = isset($options['rollback']) ? ($options['rollback'] === true ? true : false) : false;

    // Inicia conexión PDO
    $link  = self::connect();

    // Inicio de la transacción
    if ($transaction === true || $start === true) {
      $link->beginTransaction();
    }

    try {
      $query = $link->prepare($sql);
      $res   = $query->execute($params);
  
      // Manejando el tipo de query
      // SELECT | INSERT
      // SELECT * FROM usuarios;
      if(strpos($sql, 'SELECT') !== false) {
        
        return $query->rowCount() > 0 ? $query->fetchAll() : false; // no hay resultados
  
      } elseif(strpos($sql, 'INSERT') !== false) {
  
        $id      = $link->lastInsertId();
        $last_id = true;
  
      }

      // UPDATE | DELETE | ALTER TABLE | DROP TABLE | TRUNCATE | etc
      if ($transaction === true || $commit === true) {
        $link->commit();
      }

      return $id !== null && $last_id === true ? $id : true;
        
    } catch (Exception $e) {
      if ($debug === true) {
        Funciones::logger(sprintf('DB Error: %s', $e->getMessage()));
      }

      // Manejando errores en el query o la petición
      if ($transaction === true || $rollback === true) {
        $link->rollBack();
      }

      throw new PDOException($e->getMessage());
    }
  }
}