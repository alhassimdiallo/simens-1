<?php
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

class UtilisateurTable{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	public function getProfilUtilisateur($login){
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ('authentification');
		$select->columns(array ('TYPE'));
		$select->where(array('login'=>$login));
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute()->current();
		return $result;
	}
	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}
	public function fetchUtilisateur($login)
	{
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ('authentification');
		$select->where(array('login'=>$login));
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute()->current();
		return $result;
	}
}