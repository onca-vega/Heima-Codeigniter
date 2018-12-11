<?php
class Core_Model extends CI_Model {}

abstract class Core extends CI_Model {

  private $type;
  private $methodDefinition = [
    "insert" => [
      "data" => []
    ],
    "select" => [
      "where" => [],
      "like" => [],
      "not" => [],
      "order" => []
    ],
    "join" => [
      "distinct" => [], //First table

      "on" => [],       //Both tables
      "where" => [],
      "like" => [],
      "order" => []
    ],
    "update" => [
      "data" => [],
      "where" => []
    ],
    "delete" => [
      "where" => []
    ]
  ];

  public $id = null;
  public $tiempo_registro = null;
	public $tiempo_edicion = null;

	function __construct($t) {
		// $t (type) can be:
    //   -> insert
    //   -> select (may be direct, where, like, or not where)
    //   -> join
    //   -> update
    //   -> delete
    $this->setType($t);
	}

  private function setType($t){
    if(array_key_exists($t, $this->methodDefinition))
      $this->type = $t;
    else
      throw new Exception('ERROR: Not allowed method "'.$t.'" for Core data.');
  }

  protected function setActions($row, $def){
    switch ($this->type) {
      case 'insert':
        if($this->$row !== null)
          $this->methodDefinition[$this->type]['data'][] = $row;
        break;
      case 'select':
        if($this->$row !== null && array_key_exists('where', $def) && $def['where'])
          $this->methodDefinition[$this->type]['where'][] = $row;

        else if($this->$row !== null && array_key_exists('like', $def) && $def['like'])
          $this->methodDefinition[$this->type]['like'][] = $row;

        else if($this->$row !== null && array_key_exists('not', $def) && $def['not'])
          $this->methodDefinition[$this->type]['not'][] = $row;

        if(array_key_exists('order', $def) && ($def['order'] == "ASC" || $def['order'] == "DESC"))
          $this->methodDefinition[$this->type]['order'][] = $row." ".$def['order'];
        break;
      case 'join':
        if($this->$row !== null && array_key_exists('where', $def) && $def['where'])
          $this->methodDefinition[$this->type]['where'][] = $row;

        else if($this->$row !== null && array_key_exists('like', $def) && $def['like'])
          $this->methodDefinition[$this->type]['like'][] = $row;

        if(array_key_exists('distinct', $def) && $def['distinct'])
          $this->methodDefinition[$this->type]['distinct'][] = $row;

        if(array_key_exists('on', $def) && $def['on'])
          $this->methodDefinition[$this->type]['on'][] = $row;

        if(array_key_exists('order', $def) && ($def['order'] == "ASC" || $def['order'] == "DESC"))
          $this->methodDefinition[$this->type]['order'][] = $row." ".$def['order'];
          break;
        case 'update':
        if($this->$row !== null && array_key_exists('where', $def) && $def['where'])
          $this->methodDefinition[$this->type]['where'][] = $row;

        else if($this->$row !== null)
          $this->methodDefinition[$this->type]['data'][] = $row;
        break;
      case 'delete':
        if($this->$row !== null && array_key_exists('where', $def) && $def['where'])
          $this->methodDefinition[$this->type]['where'][] = $row;

        else if($this->$row !== null)
          $this->methodDefinition[$this->type]['data'][] = $row;
        break;
      default:
        // code...
        break;
    }
  }

  public function getMethodDefinition(){
    return $this->methodDefinition[$this->type];
  }

  public function setData($row, $value = null, $def = []){
    if(array_key_exists($row, $this)){
      $this->$row = $value;
      $this->setActions($row, $def);
    }
    else
      throw new Exception('ERROR: "'.$row.'" is not an existent attribute for Core data.');
	}
}

class Empresa extends Core{

  public const TABLA = "empresa";
  public $nombre = null;

  function __construct($type){
		parent::__construct($type);
	}
}

class Cliente extends Core{

  public const TABLA = "cliente";
  public $usuario = null;
  public $nombre = null;
  public $apellido_paterno = null;
  public $apellido_materno = null;

  function __construct($type){
		parent::__construct($type);
	}
}

class Proyecto extends Core{

  const TABLA = "proyecto";
	public $id_cliente = null;
	public $id_empresa = null;
	public $nombre = null;
	public $precio = null;

  function __construct($type){
		parent::__construct($type);
	}
}
