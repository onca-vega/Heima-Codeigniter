<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_Controller extends Oauth2_Controller {
	public function clientes_get(){
		$this->_authenticate();
		$filtro = new Cliente("select");
		$definition = $this->Intermediate_Model->definition([
			'id' => $this->get('id'),
			'usuario' => $this->get('usuario'),
			'nombre' => $this->get('nombre'),
			'apellido_paterno' => $this->get('apellido_paterno'),
			'apellido_materno' => $this->get('apellido_materno'),
			'tiempo_registro' => $this->get('tiempo_registro'),
			'tiempo_edicion' => $this->get('tiempo_edicion')
		]);
		$filtro->setData('id', $definition['id']['value'], $definition['id']['config']);
		$filtro->setData('usuario', $definition['usuario']['value'], $definition['usuario']['config']);
		$filtro->setData('nombre', $definition['nombre']['value'], $definition['nombre']['config']);
		$filtro->setData('apellido_paterno', $definition['apellido_paterno']['value'], $definition['apellido_paterno']['config']);
		$filtro->setData('apellido_materno', $definition['apellido_materno']['value'], $definition['apellido_materno']['config']);
		$filtro->setData('tiempo_registro', $definition['tiempo_registro']['value'], $definition['tiempo_registro']['config']);
		$filtro->setData('tiempo_edicion', $definition['tiempo_edicion']['value'], $definition['tiempo_edicion']['config']);
		$resultado = $this->Database_Model->select($filtro, $this->get('per-page'), $this->get('page'));

		$embedded = $this->get("embedded") ? explode(".", $this->get("embedded")) : [];
		if($resultado && count($embedded) > 0 && $embedded[0] === "empresa"){
			foreach($resultado as $r){
				$r->_embedded = $this->expandEmpresa($r->id, count($embedded) > 1 && $embedded[1] === "proyecto");
			}
		}

		$this->response($resultado ? $resultado : [], 200);
	}
	public function cliente_get($id){
		$this->_authenticate();
		$filtro = new Cliente("select");
		$filtro->setData('id', $id, ["where" => true]);
		$resultado = $this->Database_Model->select($filtro);

		$embedded = $this->get("embedded") ? explode(".", $this->get("embedded")) : [];
		if($resultado && count($embedded) > 0 && $embedded[0] === "empresa"){
			foreach($resultado as $r){
				$r->_embedded = $this->expandEmpresa($r->id, count($embedded) > 1 && $embedded[1] === "proyecto");
			}
		}

		$this->response($resultado[0], $resultado ? 200 : 404);
	}

	public function clientes_post(){
		$this->_authenticate();
		$ahora = date('Y-m-d H:i:s');
		$usuario = $this->post('usuario');
		$nombre = $this->post('nombre');
		$apellidoPaterno = $this->post('apellido_paterno');
		$apellidoMaterno = $this->post('apellido_materno');
		$data = [
			'usuario' => [
				'value' => $usuario,
				'type' => 'text',
				'required' => true,
				'trim' => true,
				'minlength' => 4,
				'maxlength' => 64
			],
			'nombre' => [
				'value' => $nombre,
				'type' => 'text',
				'required' => true,
				'trim' => true,
				'minlength' => 4,
				'maxlength' => 128
			],
			'apellido_paterno' => [
				'value' => $apellidoPaterno,
				'type' => 'text',
				'required' => true,
				'trim' => true,
				'minlength' => 4,
				'maxlength' => 64
			],
			'apellido_materno' => [
				'value' => $apellidoMaterno,
				'type' => 'text',
				'required' => true,
				'trim' => true,
				'minlength' => 4,
				'maxlength' => 64
			]
		];
		$error = $this->Intermediate_Model->validate($data);
		if(count($error))
			$this->response($error, 422);

		$filtro = new Cliente('select');
		$filtro->setData('usuario', $usuario, ['where' => true]);
		if($this->Database_Model->select($filtro))
			$this->response([
				[
					'field' => 'usuario',
					'message' => 'El cliente con usuario '.$usuario.' ya existe'
				]
			], 422);

		$filtro = new Cliente('insert');
		$filtro->setData('usuario', $usuario);
		$filtro->setData('nombre', $nombre);
		$filtro->setData('apellido_paterno', $apellidoPaterno);
		$filtro->setData('apellido_materno', $apellidoMaterno);
		$filtro->setData('tiempo_registro', $ahora);
		$filtro->setData('tiempo_edicion', $ahora);

		$id = $this->Database_Model->insert($filtro);

		$this->response([
			'id' => $id,
			'usuario' => $usuario,
			'nombre' => $nombre,
			'apellido_paterno' => $apellidoPaterno,
			'apellido_materno' => $apellidoMaterno,
			'tiempo_registro' => $ahora,
			'tiempo_edicion' => $ahora
		], 201);
	}

	public function cliente_patch($id){
		$this->_authenticate();
		$ahora = date('Y-m-d H:i:s');
		$usuario = $this->patch('usuario');
		$nombre = $this->patch('nombre');
		$apellidoPaterno = $this->patch('apellido_paterno');
		$apellidoMaterno = $this->patch('apellido_materno');
		$data = [];
		if($usuario)
			$data['usuario'] = [
				'value' => $usuario,
				'type' => 'text',
				'required' => true,
				'trim' => true,
				'minlength' => 4,
				'maxlength' => 64
			];
		if($nombre)
			$data['nombre'] = [
				'value' => $nombre,
				'type' => 'text',
				'required' => true,
				'trim' => true,
				'minlength' => 4,
				'maxlength' => 128
			];
		if($apellidoPaterno)
			$data['apellido_paterno'] = [
				'value' => $apellidoPaterno,
				'type' => 'text',
				'required' => true,
				'trim' => true,
				'minlength' => 4,
				'maxlength' => 64
			];
		if($apellidoMaterno)
			$data['apellido_materno'] = [
				'value' => $apellidoMaterno,
				'type' => 'text',
				'required' => true,
				'trim' => true,
				'minlength' => 4,
				'maxlength' => 64
			];
		$error = $this->Intermediate_Model->validate($data);
		if(count($error))
			$this->response($error, 422);

		if($usuario){
			$filtro = new Cliente('select');
			$filtro->setData('id', $id, ['not' => true]);
			$filtro->setData('usuario', $usuario, ['where' => true]);
			if($this->Database_Model->select($filtro))
        $this->response([
					[
						'field' => 'usuario',
						'message' => 'El usuario '.$usuario.' ya existe'
					]
        ], 422);
		}

		$filtro = new Cliente('update');
		$filtro->setData('id', $id, ['where' => true]);
		$filtro->setData('usuario', $usuario);
		$filtro->setData('nombre', $nombre);
		$filtro->setData('apellido_paterno', $apellidoPaterno);
		$filtro->setData('apellido_materno', $apellidoMaterno);
		$filtro->setData('tiempo_edicion', $ahora);
		$this->Database_Model->update($filtro);
		$this->response(null, 204);
	}

	public function cliente_delete($id){
		$this->_authenticate();
		$filtro = new Cliente('delete');
		$filtro->setData('id', $id, ['where' => true]);
		$resultado = $this->Database_Model->delete($filtro);
		if($resultado)
			$this->response(null, 204);
		else
			$this->response([
				[
					'message' => 'No se puede borrar un cliente con proyectos existentes.'
				]
			], 422);
	}

	private function expandEmpresa($id_cliente, $proyectos = false){
		$filtroObtener = new Empresa('join');
		$definition = $this->Intermediate_Model->definition([
			'id' => null,
			'nombre' => null,
			'tiempo_registro' => null,
			'tiempo_edicion' => null
		]);
		$definition['id']['config']['on'] = true;
		$definition['nombre']['config']['distinct'] = true;
		$filtroObtener->setData('id', $definition['id']['value'], $definition['id']['config']);
		$filtroObtener->setData('nombre', $definition['nombre']['value'], $definition['nombre']['config']);
		$filtroObtener->setData('tiempo_registro', $definition['tiempo_registro']['value'], $definition['tiempo_registro']['config']);
		$filtroObtener->setData('tiempo_edicion', $definition['tiempo_edicion']['value'], $definition['tiempo_edicion']['config']);
		$filtroComparativo = new Proyecto('join');
		$filtroComparativo->setData('id_cliente', $id_cliente, ["where" => true]);
		$filtroComparativo->setData('id_empresa', null, ["on" => true]);
		$resultado = $this->Database_Model->join($filtroObtener, $filtroComparativo, null, null, true);

		if($resultado && $proyectos){
			foreach($resultado as $r){
				$r->_embedded = $this->expandProyecto($id_cliente, $r->id);
			}
		}

		return $resultado ? $resultado : [];
	}
	private function expandProyecto($id_cliente, $id_empresa){
		$filtro = new Proyecto('select');
		$definition = $this->Intermediate_Model->definition([
			'id' => null,
			'usuario' => null,
			'nombre' => null,
			'precio' => null,
			'tiempo_registro' => null,
			'tiempo_edicion' => null
		]);
		$filtro->setData('id_cliente', $id_cliente, ['where' => true]);
		$filtro->setData('id_empresa', $id_empresa, ['where' => true]);
		$filtro->setData('id', $definition['id']['value'], $definition['id']['config']);
		$filtro->setData('nombre', $definition['nombre']['value'], $definition['nombre']['config']);
		$filtro->setData('precio', $definition['precio']['value'], $definition['precio']['config']);
		$filtro->setData('tiempo_registro', $definition['tiempo_registro']['value'], $definition['tiempo_registro']['config']);
		$filtro->setData('tiempo_edicion', $definition['tiempo_edicion']['value'], $definition['tiempo_edicion']['config']);
    $resultado = $this->Database_Model->select($filtro, null, null, true);
		return $resultado ? $resultado : [];
	}
}
