<?php

namespace Consultation\Model;

use Zend\Db\TableGateway\TableGateway;
use Facturation\View\Helper\DateHelper;

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
	
	public function saveSoinhospitalisation(Soinhospitalisation2 $SoinHospitalisation)
	{
		$this->getDateHelper();
		$today = new \DateTime ();
		$date_enreg = $today->format ( 'Y-m-d H:i:s' );
		
		$data = array(
				'id_sh' => $SoinHospitalisation->id_sh,
				'id_hosp' => $SoinHospitalisation->id_hosp,
				'id_soins' => $SoinHospitalisation->id_soins,
				'date_enreg'=> $date_enreg,
				'date_recommandee' => $this->conversionDate->convertDateInAnglais($SoinHospitalisation->date_recommandee)." ".$SoinHospitalisation->heure_recommandee,
				'duree' => $SoinHospitalisation->duree,
				'note' => $SoinHospitalisation->note,
				'motif' => $SoinHospitalisation->motif,
		);
			
		$id_sh = (int)$SoinHospitalisation->id_sh;
		if($id_sh == 0){
			$this->tableGateway->insert($data);
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