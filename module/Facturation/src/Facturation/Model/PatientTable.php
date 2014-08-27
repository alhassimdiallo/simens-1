<?php
namespace Facturation\Model;

use Zend\Db\TableGateway\TableGateway;

class PatientTable{

	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
}