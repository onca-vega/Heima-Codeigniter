<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa_Controller extends Oauth2_Controller {
	public function empresas_get(){
		$this->_authenticate();
		$filtro = new Empresa("select");
		$definition = $this->Intermediate_Model->definition([
			'id' => $this->get('id'),
			'nombre' => $this->get('nombre'),
			'tiempo_registro' => $this->get('tiempo_registro'),
			'tiempo_edicion' => $this->get('tiempo_edicion')
		]);
		$filtro->setData('id', $definition['id']['value'], $definition['id']['config']);
		$filtro->setData('nombre', $definition['nombre']['value'], $definition['nombre']['config']);
		$filtro->setData('tiempo_registro', $definition['tiempo_registro']['value'], $definition['tiempo_registro']['config']);
		$filtro->setData('tiempo_edicion', $definition['tiempo_edicion']['value'], $definition['tiempo_edicion']['config']);
		$resultado = $this->Database_Model->select($filtro, $this->get('per-page'), $this->get('page'));

		$embedded = $this->get("embedded") ? explode(".", $this->get("embedded")) : [];
		if($resultado && count($embedded) > 0 && $embedded[0] === "cliente"){
			foreach($resultado as $r){
				$r->_embedded = $this->expandCliente($r->id, count($embedded) > 1 && $embedded[1] === "proyecto");
			}
		}

		$this->response($resultado ? $resultado : [], 200);
	}
	public function empresa_get($id){
		$this->_authenticate();
		$filtro = new Empresa("select");
		$filtro->setData('id', $id, ["where" => true]);
		$resultado = $this->Database_Model->select($filtro);

		$embedded = $this->get("embedded") ? explode(".", $this->get("embedded")) : [];
		if($resultado && count($embedded) > 0 && $embedded[0] === "cliente"){
			foreach($resultado as $r){
				$r->_embedded = $this->expandCliente($r->id, count($embedded) > 1 && $embedded[1] === "proyecto");
			}
		}

		$this->response($resultado[0], $resultado ? 200 : 404);
	}
	public function empresas_post(){
		$this->_authenticate();
		$ahora = date('Y-m-d H:i:s');
		$nombre = $this->post('nombre');
		$data = [
			'nombre' => [
				'value' => $nombre,
				'type' => 'text',
				'required' => true,
				'trim' => true,
				'minlength' => 4,
				'maxlength' => 128
			]
		];
		$error = $this->Intermediate_Model->validate($data);
		if(count($error))
			$this->response($error, 422);

		$filtro = new Empresa('select');
		$filtro->setData('nombre', $nombre, ['where' => true]);
		if($this->Database_Model->select($filtro))
			$this->response([
				[
					'field' => 'nombre',
					'message' => 'La empresa '.$nombre.' ya existe'
				]
			], 422);

		$filtro = new Empresa('insert');
		$filtro->setData('nombre', $nombre);
		$filtro->setData('tiempo_registro', $ahora);
		$filtro->setData('tiempo_edicion', $ahora);

		$id = $this->Database_Model->insert($filtro);

		$this->response([
			'id' => $id,
			'nombre' => $nombre,
			'tiempo_registro' => $ahora,
			'tiempo_edicion' => $ahora
		], 201);
	}

	public function empresa_patch($id){
		$this->_authenticate();
		$ahora = date('Y-m-d H:i:s');
		$nombre = $this->patch('nombre');
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
		$error = $this->Intermediate_Model->validate($data);
		if(count($error))
			$this->response($error, 422);

		if($nombre){
			$filtro = new Empresa('select');
			$filtro->setData('id', $id, ['not' => true]);
			$filtro->setData('nombre', $nombre, ['where' => true]);
			if($this->Database_Model->select($filtro))
        $this->response([
					[
						'field' => 'nombre',
						'message' => 'La empresa '.$nombre.' ya existe'
					]
        ], 422);
		}

		$filtro = new Empresa('update');
		$filtro->setData('id', $id, ['where' => true]);
		$filtro->setData('nombre', $nombre);
		$filtro->setData('tiempo_edicion', $ahora);
		$this->Database_Model->update($filtro);
		$this->response(null, 204);
	}

	public function empresa_delete($id){
		$this->_authenticate();
		$filtro = new Empresa('delete');
		$filtro->setData('id', $id, ['where' => true]);
		$resultado = $this->Database_Model->delete($filtro);
		if($resultado)
			$this->response(null, 204);
		else
			$this->response([
				[
					'message' => 'No se puede borrar una empresa con proyectos existentes.'
				]
			], 422);
	}

	private function expandCliente($id_empresa, $proyectos = false){
		$filtroObtener = new Cliente('join');
		$definition = $this->Intermediate_Model->definition([
			'id' => null,
			'usuario' => null,
			'nombre' => null,
			'apellido_paterno' => null,
			'apellido_materno' => null,
			'tiempo_registro' => null,
			'tiempo_edicion' => null
		]);
		$definition['id']['config']['on'] = true;
		$definition['usuario']['config']['distinct'] = true;
		$filtroObtener->setData('id', $definition['id']['value'], $definition['id']['config']);
		$filtroObtener->setData('usuario', $definition['usuario']['value'], $definition['usuario']['config']);
		$filtroObtener->setData('nombre', $definition['nombre']['value'], $definition['nombre']['config']);
		$filtroObtener->setData('apellido_paterno', $definition['apellido_paterno']['value'], $definition['apellido_paterno']['config']);
		$filtroObtener->setData('apellido_materno', $definition['apellido_materno']['value'], $definition['apellido_materno']['config']);
		$filtroObtener->setData('tiempo_registro', $definition['tiempo_registro']['value'], $definition['tiempo_registro']['config']);
		$filtroObtener->setData('tiempo_edicion', $definition['tiempo_edicion']['value'], $definition['tiempo_edicion']['config']);
		$filtroComparativo = new Proyecto('join');
    $filtroComparativo->setData('id_empresa', $id_empresa, ["where" => true]);
		$filtroComparativo->setData('id_cliente', null, ["on" => true]);
		$resultado = $this->Database_Model->join($filtroObtener, $filtroComparativo, null, null, true);

		if($resultado && $proyectos){
			foreach($resultado as $r){
				$r->_embedded = $this->expandProyecto($id_empresa, $r->id);
			}
		}

		return $resultado ? $resultado : [];
	}

	private function expandProyecto($id_empresa, $id_cliente){
		$filtro = new Proyecto('select');
		$definition = $this->Intermediate_Model->definition([
			'id' => null,
			'usuario' => null,
			'nombre' => null,
			'precio' => null,
			'tiempo_registro' => null,
			'tiempo_edicion' => null
		]);
		$filtro->setData('id_empresa', $id_empresa, ['where' => true]);
		$filtro->setData('id_cliente', $id_cliente, ['where' => true]);
		$filtro->setData('id', $definition['id']['value'], $definition['id']['config']);
		$filtro->setData('nombre', $definition['nombre']['value'], $definition['nombre']['config']);
		$filtro->setData('precio', $definition['precio']['value'], $definition['precio']['config']);
		$filtro->setData('tiempo_registro', $definition['tiempo_registro']['value'], $definition['tiempo_registro']['config']);
		$filtro->setData('tiempo_edicion', $definition['tiempo_edicion']['value'], $definition['tiempo_edicion']['config']);
    $resultado = $this->Database_Model->select($filtro, null, null, true);
		return $resultado ? $resultado : [];
	}
}
