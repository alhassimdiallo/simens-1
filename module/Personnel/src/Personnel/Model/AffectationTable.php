<?php

namespace Personnel\Model;

use Zend\Db\TableGateway\TableGateway;
use Facturation\View\Helper\DateHelper;

class AffectationTable {
	protected $tableGateway;
	protected $conversionDate;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function getConversionDate(){
		$this->conversionDate = new DateHelper();
		
		return $this->conversionDate;
	}
	
	public function getAffectation($id_personne)
	{
		$id_personne  = (int) $id_personne;
		$rowset = $this->tableGateway->select(array('ID_PERSONNE' => $id_personne));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id_personne");
		}
		return $row;
	}
	
	public function saveAffectation(Personnel $personnel, $id_personnel)
	{
		$this->getConversionDate();
		
 		$data = array(
 				'id_personne' => $id_personnel,
 				'id_service' => $personnel->service_accueil,
 				'date_debut' => $this->conversionDate->convertDateInAnglais($personnel->date_debut),
 				'date_fin' => $this->conversionDate->convertDateInAnglais($personnel->date_fin),
 				'numero_os' => $personnel->numero_os,
 		);
 		
 		$id_personne = (int)$personnel->id_personne;
 		if($id_personne == 0){
 			$this->tableGateway->insert($data);
 		} else {
 			if($this->getAffectation($id_personne)) {
 				$this->tableGateway->update($data, array('ID_PERSONNE' => $id_personne));
 			} else {
 				throw new \Exception('Cette personne n existe pas');
 			}
 		}
	}
}