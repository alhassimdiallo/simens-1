<?php

namespace Facturation\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

class NaissanceTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getNaissance() {
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->from ( array (
				'p' => 'patient'
		) );
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
		$select->join ( array (
				'n' => 'naissances'
		), 'p.ID_PERSONNE = n.id_bebe' );
		$select->order ( 'p.ID_PERSONNE DESC' );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
		return $result;
	}
	public function nbPatientNaissance() {
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ( 'naissances' );
		$select->columns ( array (
				'id_bebe'
		) );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$nb = $stat->execute ()->count ();
		return $nb;
	}
	public function getPatientNaissance($id)
	{
		$id = ( int ) $id;
		$rowset = $this->tableGateway->select ( array (
				'id_bebe' => $id
		) );
		$row = $rowset->current ();
		if (! $row) {
			throw new \Exception ( "Could not find row $id" );
		}
		return $row;

	}
	public function updateBebe($data){
		$donnees = array(
				'heure_naissance' => $data['heure_naissance'],
				'poids' => $data['poids'],
				'taille' => $data['taille'],
				'groupe_sanguin' =>$data['groupe_sanguin'],
				'date_naissance' =>$data['date_naissance'],
		);
		$this->tableGateway->update ( $donnees, array (
				'id_bebe' => $data['id_bebe']
		) );
	}
	public function deleteNaissance($id){
		$this->tableGateway->delete ( array (
				'id_bebe' => $id
		) );
	}
	public function addNaissance($donneesNaissance){
		$this->tableGateway->insert($donneesNaissance);
	}
	
	public function addBebe($data, $date_enregistrement){
		$donnees = array(
				'id_bebe' => $data['id_bebe'],
				'id_maman' => $data['id_maman'],
				'heure_naissance' => $data['heure_naissance'],
				'poids' => $data['poids'],
				'taille' => $data['taille'],
				'groupe_sanguin' =>$data['groupe_sanguin'],
				'date_naissance' =>$data['date_naissance'],
				'date_enregistrement' => $date_enregistrement,
		);
		$this->tableGateway->insert($donnees);
	}
}