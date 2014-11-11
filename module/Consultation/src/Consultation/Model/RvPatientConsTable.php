<?php
namespace Consultation\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\XmlRpc\Value\String;
use Doctrine\Tests\Common\Annotations\Null;

class RvPatientConsTable{
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getRendezVous($id){
		$rowset = $this->tableGateway->select ( array (
				'ID_CONS' => $id
		) );
		$row =  $rowset->current ();
		if (! $row) { 
 			//throw new \Exception ( "Could not find row $id" );
 			return $row;
 		}
		//\Zend\Debug\Debug::dump($row); exit();
		return $row;
	}
}