<?php
namespace Consultation\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
class DemandeVisitePreanesthesiqueTable{
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}

	public function getDemandeVisitePreanesthesique($id){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from('demande_visite_preanesthesique');
		$select->columns(array('*'));
		$select->where(array('ID_CONS'=>$id));
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute()->current();
		return $result;
	}
	
	public function updateDemandeVisitePreanesthesique($infoDemande){
		if($infoDemande){
			\Zend\Debug\Debug::dump('c bon'); exit();
		}else{
			\Zend\Debug\Debug::dump('c pas bon'); exit();
		}
	}
}
