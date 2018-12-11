<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa_Cliente_Proyecto_Controller extends Oauth2_Controller {
	public function empresa_cliente_proyectos_get($id_empresa, $id_cliente){
		$this->_authenticate();
		$filtro = new Proyecto('select');
		$definition = $this->Intermediate_Model->definition([
			'id' => $this->get('id'),
			'usuario' => $this->get('usuario'),
			'nombre' => $this->get('nombre'),
			'precio' => $this->get('apellido_paterno'),
			'tiempo_registro' => $this->get('tiempo_registro'),
			'tiempo_edicion' => $this->get('tiempo_edicion')
		]);
		$filtro->setData('id_empresa', $id_empresa, ['where' => true]);
		$filtro->setData('id_cliente', $id_cliente, ['where' => true]);
		$filtro->setData('id', $definition['id']['value'], $definition['id']['config']);
		$filtro->setData('nombre', $definition['nombre']['value'], $definition['nombre']['config']);
		$filtro->setData('precio', $definition['precio']['value'], $definition['precio']['config']);
		$filtro->setData('tiempo_registro', $definition['tiempo_registro']['value'], $definition['tiempo_registro']['config']);
		$filtro->setData('tiempo_edicion', $definition['tiempo_edicion']['value'], $definition['tiempo_edicion']['config']);
    $resultado = $this->Database_Model->select($filtro, $this->get('per-page'), $this->get('page'));
		$this->response($resultado ? $resultado : [], 200);
	}
	public function empresa_cliente_proyecto_get($id_empresa, $id_cliente, $id){
		$this->_authenticate();
		$filtro = new Proyecto('select');
		$filtro->setData('id_empresa', $id_empresa, ['where' => true]);
		$filtro->setData('id_cliente', $id_cliente, ['where' => true]);
		$filtro->setData('id', $id, ['where' => true]);
    $resultado = $this->Database_Model->select($filtro);
		$this->response($resultado[0], $resultado ? 200 : 404);
	}

	public function empresa_cliente_proyectos_post($id_empresa, $id_cliente){
		$this->_authenticate();
		$ahora = date('Y-m-d H:i:s');
		$nombre = $this->post('nombre');
		$precio = (int)$this->post('precio');
		$data = [
			'nombre' => [
				'value' => $nombre,
				'type' => 'text',
				'required' => true,
				'trim' => true,
				'minlength' => 4,
				'maxlength' => 128
			],
			'precio' => [
				'value' => $precio,
				'type' => 'integer',
				'required' => true,
				'min' => 1,
				'max' => 5000000
			],
		];
		$error = $this->Intermediate_Model->validate($data);
		if(count($error))
			$this->response($error, 422);

		$filtro = new Proyecto('select');
    $filtro->setData('nombre', $nombre, ['where' => true]);
    if($this->Database_Model->select($filtro))
      $this->response([
        [
          'field' => 'nombre',
          'message' => 'El proyecto '.$nombre.' ya existe'
        ]
      ], 422);

		$filtro = new Proyecto('insert');
		$filtro->setData('id_empresa', $id_empresa);
		$filtro->setData('id_cliente', $id_cliente);
		$filtro->setData('nombre', $nombre);
		$filtro->setData('precio', $precio);
		$filtro->setData('tiempo_registro', $ahora);
		$filtro->setData('tiempo_edicion', $ahora);

		$id = $this->Database_Model->insert($filtro);

		if($id)
			$this->response([
	      'id' => $id,
				'id_cliente' => $id_cliente,
				'id_empresa' => $id_empresa,
				'nombre' => $nombre,
				'precio' => $precio,
				'tiempo_registro' => $ahora,
				'tiempo_edicion' => $ahora
			], 201);
		else
			$this->response([
				[
					'message' => "La combinación empresa '".$id_empresa."' cliente '".$id_cliente."' no es posible"
				]
			], 422);
	}

	public function empresa_cliente_proyecto_patch($id_empresa, $id_cliente, $id){
		$this->_authenticate();
		$ahora = date('Y-m-d H:i:s');
    $nombre = $this->patch('nombre');
		$precio = (int)$this->patch('precio');
		$data = [];
		if($nombre)
			$data['nombre'] = [
				'value' => $nombre,
				'type' => 'text',
				'required' => true,
				'trim' => true,
				'minlength' => 4,
				'maxlength' => 128
			];
		if($precio)
			$data['precio'] = [
				'value' => $precio,
				'type' => 'integer',
				'required' => true,
				'min' => 1,
				'max' => 5000000
			];
		$error = $this->Intermediate_Model->validate($data);
		if(count($error))
			$this->response($error, 422);

    if($nombre){
			$filtro = new Proyecto('select');
			$filtro->setData('id', $id, ['not' => true]);
      $filtro->setData('nombre', $nombre, ['where' => true]);
      if($this->Database_Model->select($filtro))
        $this->response([
          [
            'field' => 'nombre',
            'message' => 'El proyecto '.$nombre.' ya existe'
          ]
        ], 422);
    }

		$filtro = new Proyecto('update');
		$filtro->setData('id', $id, ['where' => true]);
		$filtro->setData('id_empresa', $id_empresa, ['where' => true]);
    $filtro->setData('id_cliente', $id_cliente, ['where' => true]);
		$filtro->setData('nombre', $nombre);
		$filtro->setData('precio', $precio);
		$filtro->setData('tiempo_edicion', $ahora);
		$this->Database_Model->update($filtro);
		$this->response(null, 204);
	}
	public function empresa_cliente_proyecto_delete($id_empresa, $id_cliente, $id){
		$this->_authenticate();
		$filtro = new Proyecto('delete');
		$filtro->setData('id_empresa', $id_empresa, ['where' => true]);
		$filtro->setData('id_cliente', $id_cliente, ['where' => true]);
		$filtro->setData('id', $id, ['where' => true]);
		$resultado = $this->Database_Model->delete($filtro);
		if($resultado)
			$this->response(null, 204);
		else
			$this->response([
				[
					'message' => 'Error relacionado con el borrado de proyecto.'
				]
			], 422);
	}
}
