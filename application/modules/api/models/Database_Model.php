<?php
class Database_Model extends CI_Model {

	const MINPERPAGE = 5;
  const MAXPERPAGE = 100;
  const PAGE = 1;

	function __construct() {
		parent::__construct();
		date_default_timezone_set('America/Mexico_City');					 			//SET TIMEZONE
	}

	public function insert($filtro){
		$data = $filtro->getMethodDefinition()['data'];
		$value = [];

		$query = "INSERT INTO ".$filtro::TABLA." (";
		for($i = 0; $i < count($data); $i++){
			$value[] = $filtro->{ $data[$i] };

			if($i != count($data) - 1)
				$query .= $data[$i].", ";
			else
				$query .= $data[$i].") VALUES (";
		}
		for($i = 0; $i < count($data); $i++){
			if($i != count($data) - 1)
				$query .= "'".$value[$i]."', ";
			else
				$query .= "'".$value[$i]."');";
		}

		$this->db->query($query);
		return $this->db->insert_id();
	}

	public function select($filtro, $perPage = null, $page = null, $all = false){
		$def = $filtro->getMethodDefinition();
		$where = $def['where'];
		$like = $def['like'];
		$not = $def['not'];
		$order = $def['order'];

		$query = "SELECT * FROM ".$filtro::TABLA." ";
		if(count($where) || count($like) || count($not)){
			$query .= "WHERE ";
			if(count($where))
				for($i = 0; $i < count($where); $i++){
					if($i != count($where) - 1)
						$query .= $where[$i]." = '".$filtro->{ $where[$i] }."' AND ";
					else
						$query .= $where[$i]." = '".$filtro->{ $where[$i] }."' ";
				}
			if(count($like)){
				if(count($where))
					$query .= "AND ";
				for($i = 0; $i < count($like); $i++){
					if($i != count($like) - 1)
						$query .= $like[$i]." LIKE '%".$filtro->{ $like[$i] }."%' OR ";
					else
						$query .= $like[$i]." LIKE '%".$filtro->{ $like[$i] }."%' ";
				}
			}
			if(count($not)){
				if(count($where) || count($like))
					$query .= "AND ";
				for($i = 0; $i < count($not); $i++){
					if($i != count($not) - 1)
						$query .= $not[$i]." != '".$filtro->{ $not[$i] }."' AND ";
					else
						$query .= $not[$i]." != '".$filtro->{ $not[$i] }."' ";
				}
			}
		}
		if(count($order)){
			$query .= "ORDER BY ";
			for($i = 0; $i < count($order); $i++){
				if($i != count($order) - 1)
					$query .= $order[$i].", ";
				else
					$query .= $order[$i]." ";
			}
		}

		if($all)
			$query .= ";";
		else{
			$pagination = $this->pagination($filtro, str_replace('*', 'COUNT(1) AS total', $query).';', $perPage, $page);
			$query .= "LIMIT ".$pagination[0].", ".$pagination[1].";";
		}

		$resultado = $this->db->query($query);
		if($resultado->num_rows() > 0)
			$objeto = $resultado->result();
		else
			$objeto = null;
		return $objeto;
	}

	public function join($filtro, $filtroComparativo, $perPage = null, $page = null, $all = false){
		$defA = $filtro->getMethodDefinition();
		$distinct = $defA["distinct"];
		$onA = $defA["on"];
		$whereA = $defA['where'];
		$likeA = $defA['like'];
		$orderA = $defA['order'];

		$defB = $filtroComparativo->getMethodDefinition();
		$onB = $defB["on"];
		$whereB = $defB['where'];
		$likeB = $defB['like'];
		$orderB = $defB['order'];

		$query = "SELECT ".$filtro::TABLA.".* FROM ".$filtro::TABLA." ";
		if(count($onA) && count($onB) && count($onA) === count($onB)){
			$query .= "INNER JOIN ".$filtroComparativo::TABLA." ON ";
			for($i = 0; $i < count($onA); $i++){
				if($i != count($onA) - 1)
					$query .= $filtro::TABLA.".".$onA[$i]." = ".$filtroComparativo::TABLA.".".$onB[$i]." AND ";
				else
					$query .= $filtro::TABLA.".".$onA[$i]." = ".$filtroComparativo::TABLA.".".$onB[$i]." ";
			}
		}
		if(count($whereA) || count($likeA) || count($whereB) || count($likeB)){
			$query .= "WHERE ";
			if(count($whereA))
				for($i = 0; $i < count($whereA); $i++){
					if($i != count($whereA) - 1)
						$query .= $filtro::TABLA.".".$whereA[$i]." = '".$filtro->{ $whereA[$i] }."' AND ";
					else
						$query .= $filtro::TABLA.".".$whereA[$i]." = '".$filtro->{ $whereA[$i] }."' ";
				}
			if(count($whereB)){
				if(count($whereA))
					$query .= "AND ";
				for($i = 0; $i < count($whereB); $i++){
					if($i != count($whereB) - 1)
						$query .= $filtroComparativo::TABLA.".".$whereB[$i]." = '".$filtroComparativo->{ $whereB[$i] }."' AND ";
					else
						$query .= $filtroComparativo::TABLA.".".$whereB[$i]." = '".$filtroComparativo->{ $whereB[$i] }."' ";
				}
			}
			if(count($likeA)){
				if(count($whereB) || count($whereB))
					$query .= "AND ";
				for($i = 0; $i < count($likeA); $i++){
					if($i != count($likeA) - 1)
						$query .= $filtro::TABLA.".".$likeA[$i]." LIKE '%".$filtro->{ $likeA[$i] }."%' OR ";
					else
						$query .= $filtro::TABLA.".".$likeA[$i]." LIKE '%".$filtro->{ $likeA[$i] }."%' ";
				}
			}
			if(count($likeB)){
				if(count($whereB) || count($whereB) || count($likeA))
					$query .= "AND ";
				for($i = 0; $i < count($likeB); $i++){
					if($i != count($likeB) - 1)
						$query .= $filtroComparativo::TABLA.".".$likeB[$i]." LIKE '%".$filtroComparativo->{ $likeB[$i] }."%' OR ";
					else
						$query .= $filtroComparativo::TABLA.".".$likeB[$i]." LIKE '%".$filtroComparativo->{ $likeB[$i] }."%' ";
				}
			}
		}
		if(count($distinct)){
			$query .= "GROUP BY ";
			for($i = 0; $i < count($distinct); $i++){
				if($i != count($distinct) - 1)
					$query .= $filtro::TABLA.".".$distinct[$i]." AND ";
				else
					$query .= $filtro::TABLA.".".$distinct[$i]." ";
			}
		}
		if(count($orderA)){
			$query .= "ORDER BY ";
			for($i = 0; $i < count($orderA); $i++){
				if($i != count($orderA) - 1)
					$query .= $filtro::TABLA.".".$orderA[$i].", ";
				else
					$query .= $filtro::TABLA.".".$orderA[$i]." ";
			}
		}
		if(count($orderB)){
			if(!count($orderA))
				$query .= "ORDER BY ";
			for($i = 0; $i < count($orderB); $i++){
				if($i != count($orderB) - 1)
					$query .= $filtroComparativo::TABLA.".".$orderB[$i].", ";
				else
					$query .= $filtroComparativo::TABLA.".".$orderB[$i]." ";
			}
		}

		if($all)
			$query .= ";";
		else{
			$pagination = $this->pagination($filtro, 'SELECT COUNT(1) AS total FROM ('.$query.') as my_group;', $perPage, $page);
			$query .= "LIMIT ".$pagination[0].", ".$pagination[1].";";
		}

		$resultado = $this->db->query($query);
		if($resultado->num_rows() > 0)
			$objeto = $resultado->result();
		else
			$objeto = null;
		return $objeto;
	}

	public function update($filtro){
		$def = $filtro->getMethodDefinition();
		$data = $def['data'];
		$where = $def['where'];

		$query = "UPDATE ".$filtro::TABLA." SET ";
		for($i = 0; $i < count($data); $i++){
			if($i != count($data) - 1)
				$query .= $data[$i]."='".$filtro->{ $data[$i] }."', ";
			else
				$query .= $data[$i]."='".$filtro->{ $data[$i] }."' ";
		}
		if(count($where)){
			$query .= "WHERE ";
			for($i = 0; $i < count($where); $i++){
				if($i != count($where) - 1)
					$query .= $where[$i]." = '".$filtro->{ $where[$i] }."' AND ";
				else
					$query .= $where[$i]." = '".$filtro->{ $where[$i] }."' ";
			}
		}
		$query .= ";";

		return $this->db->query($query);
	}

	public function delete($filtro){
		$where = $filtro->getMethodDefinition()['where'];

		$query = "DELETE FROM ".$filtro::TABLA." ";
		if(count($where)){
			$query .= "WHERE ";
			for($i = 0; $i < count($where); $i++){
				if($i != count($where) - 1)
					$query .= $where[$i]." = '".$filtro->{ $where[$i] }."' AND ";
				else
					$query .= $where[$i]." = '".$filtro->{ $where[$i] }."' ";
			}
		}
		$query .= ";";

		return $this->db->query($query);
	}

	private function pagination($filtro, $queryCount, $perPage, $page){
    $count = $this->db->query($queryCount)->result();
    $count = (int)$count[0]->total;

    $perPage = (!$perPage || $perPage < $this::MINPERPAGE) ? ($perPage > $this::MAXPERPAGE) ? $this::MAXPERPAGE : $this::MINPERPAGE : (int)$perPage;
    $totalPages = ceil($count/$perPage);
    $page = (!$page || $page < $this::PAGE || $page > $totalPages) ? $this::PAGE : (int)$page;

		header('Xpg-Actual-Page: '.$page);
		header('Xpg-Per-Page: '.$perPage);
		header('Xpg-Total-Pages: '.$totalPages);
    header('Xpg-Total-Rows: '.$count);

		$offset = ($page - 1) * $perPage;

    return [ $offset, $perPage ];
  }
}
