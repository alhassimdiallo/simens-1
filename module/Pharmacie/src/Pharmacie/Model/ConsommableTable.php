<?php
namespace Pharmacie\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;
//use Zend\Db\Adapter\Adapter;

class ConsommableTable{
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function compteNBLigne(){
		$resultSet = $this->tableGateway->select ();
		$nb = $resultSet->count();
		return $nb;
	}
	public function addConsommable($data){
		$this->tableGateway->insert($data);
	}
	public function getAllConsommable(){
		$resultSet = $this->tableGateway->select ();
		return $resultSet;
	}
	public function getConsommable($id){
		$id = ( int ) $id;
		$rowset = $this->tableGateway->select ( array (
				'ID_MATERIEL' => $id
		) );
		$row =  $rowset->current ();
		if (! $row) {
			throw new \Exception ( "Could not find row $id" );
		}
		return $row;
	}
	public function deleteConsommable($id){
		$this->tableGateway->delete ( array (
				'ID_MATERIEL' => $id
		) );
	}
	public function fetchCommandes()
	{
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql ( $adapter );
		$select = $sql->select();
		$select->from(array('cons'=>'consommable'));
		//$select->columns(array(SQL_STAR ));
		$select->join(array (
				'cs' => 'commande_consommable'
		), 'cons.ID_MATERIEL = cs.ID_MATERIEL', array('ID_COMMANDE', 'ID_MATERIEL', 'QUANTITE', 'ETAT', 'Grandtotal'=>new Expression('SUM((cons.PRIX)*QUANTITE)')));
		$select->join(array (
				'com' => 'commande'
		), 'cs.ID_COMMANDE = com.ID_COMMANDE');
		$select->group('cs.ID_COMMANDE');
		$stat = $sql->prepareStatementForSqlObject($select);
		$listeCommandes =  $stat->execute();
// 		$sql ="SELECT * ,SUM((cons.PRIX)*Quantite) AS Grandtotal
// 			   FROM commande com, commande_consommable cs, consommable cons
// 			   WHERE com.ID_COMMANDE = cs.ID_COMMANDE and cs.ID_MATERIEL = cons.ID_MATERIEL
// 			   GROUP BY cs.ID_COMMANDE";
		//var_dump($listeCommandes);exit();
		return $listeCommandes;
	}
	public function compteNBCommandes(){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql ( $adapter );
		$select = $sql->select ( 'commande' );
		$select->group('ID_COMMANDE');
		$stat = $sql->prepareStatementForSqlObject($select);
		$nb = $stat->execute()->count();
		//var_dump($nb);exit();
		return $nb;
	}
}