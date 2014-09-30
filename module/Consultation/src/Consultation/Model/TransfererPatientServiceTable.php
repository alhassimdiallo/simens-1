<?php
namespace Consultation\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
class TransfererPatientServiceTable{
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function fetchHopital(){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select('hopital');
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
		foreach ($result as $data) {
			$options[$data['ID_HOPITAL']] = $data['NOM_HOPITAL'];
		}
		return $options;
	}

}
