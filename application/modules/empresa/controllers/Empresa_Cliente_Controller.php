<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa_Cliente_Controller extends Oauth2_Controller {
	public function empresa_clientes_get($id_empresa){
		$this->_authenticate();
		$filtroObtener = new Cliente('join');
		$definition = $this->Intermediate_Model->definition([
			'id' => $this->get('id'),
			'usuario' => $this->get('usuario'),
			'nombre' => $this->get('nombre'),
			'apellido_paterno' => $this->get('apellido_paterno'),
			'apellido_materno' => $this->get('apellido_materno'),
			'tiempo_registro' => $this->get('tiempo_registro'),
			'tiempo_edicion' => $this->get('tiempo_edicion')
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
		$resultado = $this->Database_Model->join($filtroObtener, $filtroComparativo, $this->get('per-page'), $this->get('page'));
		$this->response($resultado ? $resultado : [], 200);
	}
	public function empresa_cliente_get($id_empresa, $id_cliente){
		$this->_authenticate();
		$filtroObtener = new Cliente('join');
		$filtroObtener->setData('id', null, ["on" => true]);
		$filtroObtener->setData('usuario', null, ["distinct" => true]);
		$filtroComparativo = new Proyecto('join');
    $filtroComparativo->setData('id_empresa', $id_empresa, ["where" => true]);
		$filtroComparativo->setData('id_cliente', $id_cliente, ["on" => true, "where" => true]);
		$resultado = $this->Database_Model->join($filtroObtener, $filtroComparativo);
		$this->response($resultado[0], $resultado ? 200 : 404);
	}
}
