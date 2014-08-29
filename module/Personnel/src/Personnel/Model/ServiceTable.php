<?php
namespace Personnel\Model;

use Zend\Db\TableGateway\TableGateway;

class ServiceTable{
	protected $tableGateway;

	public function getServiceAffectation($id){
		$select = $this->tableGateway->select(array('ID_SERVICE' => $id));
		$serviceRow = $select->current();
		return $serviceRow;
	}
}