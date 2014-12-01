<?php
namespace Facturation\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

class TarifConsultationTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getActe($id) {
		$id = ( int ) $id;
		$rowset = $this->tableGateway->select ( array (
				'ID_TARIF_CONSULTATION' => $id
		) );
		$row =  $rowset->current ();
		if (! $row) {
			throw new \Exception ( "Could not find row $id" );
		}
		return $row;
	}
	public function fetchService()
	{
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql($adapter);
		$select = $sql->select('tarif_consultation');
		$select->columns(array('ID_TARIF_CONSULTATION', 'LIBELLE'));
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
		foreach ($result as $data) {
			$options[$data['ID_TARIF_CONSULTATION']] = $data['LIBELLE'];
		}
		return $options;
	}

}