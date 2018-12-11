<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_Empresa_Controller extends Oauth2_Controller {
	public function cliente_empresas_get($id_cliente){
		$this->_authenticate();
		$filtroObtener = new Empresa('join');
		$definition = $this->Intermediate_Model->definition([
			'id' => $this->get('id'),
			'nombre' => $this->get('nombre'),
			'tiempo_registro' => $this->get('tiempo_registro'),
			'tiempo_edicion' => $this->get('tiempo_edicion')
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
		$resultado = $this->Database_Model->join($filtroObtener, $filtroComparativo, $this->get('per-page'), $this->get('page'));
		$this->response($resultado ? $resultado : [], 200);
	}
	public function cliente_empresa_get($id_cliente, $id_empresa){
		$this->_authenticate();
		$filtroObtener = new Empresa('join');
		$filtroObtener->setData('id', null, ["on" => true]);
		$filtroObtener->setData('nombre', null, ["distinct" => true]);
		$filtroComparativo = new Proyecto('join');
		$filtroComparativo->setData('id_cliente', $id_cliente, ["where" => true]);
		$filtroComparativo->setData('id_empresa', $id_empresa, ["on" => true, "where" => true]);
		$resultado = $this->Database_Model->join($filtroObtener, $filtroComparativo);
		$this->response($resultado[0], $resultado ? 200 : 404);
	}
}
