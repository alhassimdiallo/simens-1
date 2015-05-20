<?php

namespace Consultation\Model;

use Zend\Db\TableGateway\TableGateway;
use Facturation\View\Helper\DateHelper;
use Zend\Db\Sql\Sql;

class SoinhospitalisationTable {
	protected $tableGateway;
	protected $conversionDate;
	
	public function getDateHelper() {
		$this->conversionDate = new DateHelper();
	}
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function getSoinhospitalisationWithId_sh($id_sh)
	{
		$rowset = $this->tableGateway->select(array(
				'id_sh' => (int) $id_sh,
		));
		$row = $rowset->current();
		if (!$row) {
			$row = null;
		}
		return $row;
	}
	
	public function getSoinhospitalisation($id_hosp)
	{
		$rowset = $this->tableGateway->select(array(
				'id_hosp' => (int) $id_hosp,
		));
		$row = $rowset->current();
		if (!$row) {
			$row = null;
		}
		return $row;
	}
	
	public function getAllSoinhospitalisation($id_hosp)
	{ 
		$rowset = $this->tableGateway->select(array(
				'id_hosp' => (int) $id_hosp,
		));
		if (!$rowset) {
			$row = null;
		}
		$row = $rowset->toArray();
		return $row;
	}
	
	public function saveHeure($data, $id_sh)
	{
		for($i=0; $i<count($data->heure_recommandee) ; $i++ ){
			$adapter = $this->tableGateway->getAdapter();
			$sql = new Sql($adapter);
			$select = $sql->insert();
			$select->into('heures_soins');
			$select->columns(array('heure', 'id_sh'));
			$select->values(array('heure'=>$data->heure_recommandee[$i], 'id_sh'=>$id_sh));
			
			$stat = $sql->prepareStatementForSqlObject($select);
			$stat->execute();
		}
	}
	
	public function getHeures($id_sh)
	{
			$adapter = $this->tableGateway->getAdapter();
			$sql = new Sql($adapter);
			$select = $sql->select();
			$select->from('heures_soins');
			$select->where(array('id_sh'=>$id_sh));
				
			$stat = $sql->prepareStatementForSqlObject($select);
			$result = $stat->execute();
			
			$tab = array();
			foreach ($result as $resultat){
				$tab[] = $resultat['heure'];
			}
			return $tab;
	}
	
	public function saveSoinhospitalisation($SoinHospitalisation, $id_medecin)
	{
		$this->getDateHelper();
		$today = new \DateTime ();
		$date_enreg = $today->format ( 'Y-m-d H:i:s' );
		
		$data = array(
				'id_hosp' => $SoinHospitalisation->id_hosp,
				'date_enregistrement'=> $date_enreg,
				'date_application_recommandee' => $this->conversionDate->convertDateInAnglais($SoinHospitalisation->date_application),
				'medicament' => $SoinHospitalisation->medicament,
				'voie_administration' => $SoinHospitalisation->voie_administration,
				'frequence' => $SoinHospitalisation->frequence,
				'dosage' => $SoinHospitalisation->dosage,
				'motif' => $SoinHospitalisation->motif,
				'note' => $SoinHospitalisation->note,
				'id_personne' => $id_medecin,
		);
			
		$id_sh = (int)$SoinHospitalisation->id_sh;
		if($id_sh == 0){
			return($this->tableGateway->getLastInsertValue($this->tableGateway->insert($data)));
		} else {
			$data = array(
					'date_modifcation_medecin'=> $date_enreg,
					'date_application_recommandee' => $this->conversionDate->convertDateInAnglais($SoinHospitalisation->date_application),
					'medicament' => $SoinHospitalisation->medicament,
					'voie_administration' => $SoinHospitalisation->voie_administration,
					'frequence' => $SoinHospitalisation->frequence,
					'dosage' => $SoinHospitalisation->dosage,
					'motif' => $SoinHospitalisation->motif,
					'note' => $SoinHospitalisation->note,
			);
			if($this->getSoinhospitalisationWithId_sh($id_sh)) {
				$this->tableGateway->update($data, array('id_sh' => $id_sh));
			} 
		}
	}
	
	public function supprimerHospitalisation($id_sh) {
		
		if($this->getSoinhospitalisationWithId_sh($id_sh)){
			$adapter = $this->tableGateway->getAdapter();
			$sql = new Sql($adapter);
			$select = $sql->delete();
			$select->from('heures_soins');
			$select->where(array('id_sh'=>$id_sh));
			
			$stat = $sql->prepareStatementForSqlObject($select);
			$result = $stat->execute();
			
			$this->tableGateway->delete(array('id_sh' => $id_sh)); 
		}
	}
	
	public function appliquerSoin($id_sh, $note) {
		$this->getDateHelper();
		$today = new \DateTime ();
		$date_application = $today->format ( 'Y-m-d H:i:s' );
		
		if($this->getSoinhospitalisationWithId_sh($id_sh)){
			$this->tableGateway->update(array('note_application' => $note, 'date_application'=> $date_application , 'appliquer'=>1), array('id_sh' => $id_sh));
		}
	}
	
	
	public function getInfosInfirmiers($id_personne)
	{
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('e' => 'employe'));
		$select->join(array('pers'=>'personne'), 'pers.ID_PERSONNE = e.id_personne', array('*'));
		$select->where(array('e.id_personne' => $id_personne));
	
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute()->current();
			
		return $result;
	}
	
	
	/*Heure suivante*/
	/*Heure suivante*/
	public function getHeureSuivante($id_sh)
	{
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from('heures_soins');
		$select->where(array('id_sh'=>$id_sh, 'applique'=>0));
		$select->order('heure ASC');
	
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute()->current();
			
		return $result;
	}
	
	/*Toutes les heures*/
	/*Toutes les heures*/
	public function getToutesHeures($id_sh)
	{
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from('heures_soins');
		$select->where(array('id_sh'=>$id_sh));
		$select->order('id_heure ASC');
	
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
			
		return $result;
	}
	
	/**
	 * Recuperer au moin une heure ou le soin est appliquer 
	 **/
	public function getHeureAppliquer($id_sh)
	{
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from('heures_soins');
		$select->where(array('id_sh'=>$id_sh, 'applique'=>1));
	
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute()->count();
			
		return $result;
	}
}