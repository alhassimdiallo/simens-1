<?php

namespace Facturation\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

class FacturationTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getPatientsAdmis() {
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d' );
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns ( array (
				'Nom' => 'NOM',
				'Prenom' => 'PRENOM',
				'Datenaissance' => 'DATE_NAISSANCE',
				'Sexe' => 'SEXE',
				'Adresse' => 'ADRESSE',
				'Nationalite' => 'NATIONALITE_ACTUELLE',
				'Taille' => 'TAILLE',
				'Id' => 'ID_PERSONNE'
		) );
		$select->from ( array (
				'p' => 'patient'
		) );
		$select->join ( array (
				'f' => 'facturation'
		), 'p.ID_PERSONNE = f.id_patient', array (
				'Id_facturation' => 'id_facturation'
		) );
		$select->join ( array (
				's' => 'service'
		), 's.id_service = f.id_service', array (
				'Id_Service' => 'ID_SERVICE',
				'Nomservice' => 'NOM'
		) );
		$select->where ( array (
				'date_cons' => $date
		) );
		$select->order ( 'id_facturation ASC' );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
		return $result;
	}
	public function nbFacturation() {
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d' );
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ( 'facturation' );
		$select->columns ( array (
				'id_facturation'
		) );
		$select->where ( array (
				'date_cons' => $date
		) );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$nb = $stat->execute ()->count ();
		return $nb;
	}
	public function addFacturation($data){
		$donnees = array(
				'id_patient' => $data['id_patient'],
				'id_service' => $data['id_service'],
				'date_cons'  => $data['date'],
				'montant'    => $data['montant'],
				'numero'     => $data['numero'],
		);
		$this->tableGateway->insert($donnees);
	}
	public function deleteAdmissionPatient($id){
		$this->tableGateway->delete(array('id_facturation'=> $id));
	}
	public function getPatientAdmis($id){
		$id = ( int ) $id;
		$rowset = $this->tableGateway->select ( array (
				'id_facturation' => $id
		) );
		$row =  $rowset->current ();
		if (! $row) {
			throw new \Exception ( "Could not find row $id" );
		}
		return $row;
	}
}