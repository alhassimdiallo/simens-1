<?php

namespace Personnel\Model;

use Zend\Db\TableGateway\TableGateway;

class MedicotechniqueTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function getMedicoTechnique($id_personne)
	{
		$id_personne  = (int) $id_personne;
		$rowset = $this->tableGateway->select(array('ID_PERSONNE' => $id_personne));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id_personne");
		}
		return $row;
	}
	
	public function saveMedicoTechnique(Personnel $personnel, $id_personnel)
	{
 		$data = array(
 				'id_personne' => $id_personnel,
 				'matricule' => $personnel->matricule_medico,
 				'grade' => $personnel->grade_medico,
 				'domaine' => $personnel->domaine_medico,
 				'autres' => $personnel->autres
 		);
 		
 		$id_personne = (int)$personnel->id_personne;
 		if($id_personne == 0){
 			$this->tableGateway->insert($data);
 		} else {
 			if($this->getMedecin($id_personne)) {
 				$this->tableGateway->update($data, array('ID_PERSONNE' => $id_personne));
 			} else {
 				throw new \Exception('Cette personne n existe pas');
 			}
 		}
	}
}