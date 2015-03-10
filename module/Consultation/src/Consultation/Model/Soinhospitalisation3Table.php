<?php

namespace Consultation\Model;

use Zend\Db\TableGateway\TableGateway;
use Facturation\View\Helper\DateHelper;
use Zend\Db\Sql\Sql;

class Soinhospitalisation3Table {
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
				//'heure_recommandee' => $SoinHospitalisation->heure_recommandee,
				'motif' => $SoinHospitalisation->motif,
				'note' => $SoinHospitalisation->note,
				'id_personne' => $id_medecin,
		);
			
		$id_sh = (int)$SoinHospitalisation->id_sh;
		if($id_sh == 0){
			return($this->tableGateway->getLastInsertValue($this->tableGateway->insert($data)));
			//$this->tableGateway->insert($data);
		} else {
			$data = array(
					'date_modification'=> $date_enreg,
					'date_recommandee' => $this->conversionDate->convertDateInAnglais($SoinHospitalisation->date_recommandee)." ".$SoinHospitalisation->heure_recommandee,
					'duree' => $SoinHospitalisation->duree,
					'note' => $SoinHospitalisation->note,
					'motif' => $SoinHospitalisation->motif,
			);
			if($this->getSoinhospitalisationWithId_sh($id_sh)) {
				$this->tableGateway->update($data, array('id_sh' => $id_sh));
			} 
		}
	}
	
	public function supprimerHospitalisation($id_sh) {
		
		if($this->getSoinhospitalisationWithId_sh($id_sh)){
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
	
}