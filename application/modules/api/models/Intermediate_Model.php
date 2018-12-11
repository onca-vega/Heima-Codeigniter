<?php
class Intermediate_Model extends CI_Model {
  function __construct() {
		parent::__construct();
	}

  const VALIDATEMESSAGE = [
		'required' => 'Es requerido',
		'minlength' => ' caracteres como mínimo',
		'maxlength' => ' caracteres como máximo',
		'min' => 'Mayor o igual a ',
		'max' => 'Menor o igual a ',
	];

	public function validate($data){
		$error = [];
		foreach ($data as $key => $value){
			switch ($value['type']) {
				case 'text':
					if($value['trim'])
						$value['value'] = trim($value['value']);
					if($value['required'] && (!$value['value'] || $value['value'] == ''))
						$error[] = [
							'field' => $key,
							'message' => $this::VALIDATEMESSAGE['required']
						];
					else if($value['minlength'] && strlen($value['value']) < $value['minlength'])
						$error[] = [
							'field' => $key,
							'message' => $value['minlength'].$this::VALIDATEMESSAGE['minlength']
						];
					else if($value['maxlength'] && strlen($value['value']) > $value['maxlength'])
						$error[] = [
							'field' => $key,
							'message' => $value['maxlength'].$this::VALIDATEMESSAGE['maxlength']
						];
					break;
				case 'integer':
					if($value['required'] && (!$value['value'] || $value['value'] == ''))
						$error[] = [
							'field' => $key,
							'message' => $this::VALIDATEMESSAGE['required']
						];
					else if($value['min'] !== null && $value['value'] < $value['min'])
						$error[] = [
							'field' => $key,
							'message' => $this::VALIDATEMESSAGE['min'].$value['min']
						];
					else if($value['max'] !== null && $value['value'] > $value['max'])
						$error[] = [
							'field' => $key,
							'message' => $this::VALIDATEMESSAGE['max'].$value['max']
						];
					break;
			}
		}
		return $error;
	}

  public function definition($data){
    $definition = [];
    foreach($data as $r => $v){
      $definition[$r] = [ 'value' => null, 'config' => [] ];
      if($v){
        $value = explode(",", $v);
        for($i = 0; $i < count($value); $i++){
          $sub = explode("|", trim($value[$i]));
          if(count($sub) === 2 && $sub[0] === "order")
            $definition[$r]['config'][$sub[0]] = $sub[1];
          else if(count($sub) === 2 && ($sub[0] == "like" || $sub[0] == "where")){
            $definition[$r]['config'][$sub[0]] = true;
            $definition[$r]['value'] = $sub[1];
          }
        }
      }
    }
    return $definition;
  }
}
?>
