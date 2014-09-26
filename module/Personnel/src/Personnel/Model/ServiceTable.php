<?php
namespace Personnel\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;

class ServiceTable{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getServiceAffectation($id){
		$id = ( int ) $id;
		$select = $this->tableGateway->select(array('ID_SERVICE' => $id));
		$serviceRow = $select->current();
		if (! $serviceRow) {
			throw new \Exception ( "Could not find row $id" );
		}
		return $serviceRow;
	}
	public function listeService(){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('type_pers'=>'service'));
		$select->columns(array('NOM', 'NOM'));
		$select->order('ID_SERVICE ASC');
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
		foreach ($result as $data) {
			$options[$data['NOM']] = $data['NOM'];
		}
		return $options;
	}
	public function fetchService()
	{
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql($adapter);
		$select = $sql->select('service');
		$select->columns(array('ID_SERVICE', 'NOM'));
		//$select->order('NOM');
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
		foreach ($result as $data) {
			$options[$data['ID_SERVICE']] = $data['NOM'];
		}
		return $options;
	}
}