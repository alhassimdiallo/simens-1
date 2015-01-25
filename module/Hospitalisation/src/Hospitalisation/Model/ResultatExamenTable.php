<?php

namespace Hospitalisation\Model;

use Zend\Db\TableGateway\TableGateway;

class ResultatExamenTable {
	protected $tableGateway;
	protected $conversionDate;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function getResultatExamen($idDemande)
	{
		$rowset = $this->tableGateway->select(array(
				'idDemande' => (int) $idDemande,
		));
		$row = $rowset->current();
		if (!$row) {
			$row = null;
		}
		return $row;
	}
	
	public function saveResultatsExamens($donnees)
	{
		$data = array(
				'techniqueUtiliser' =>$donnees->techniqueUtiliser,
				'noteResultat' =>$donnees->noteResultat,
				'conclusion' =>$donnees->conclusion,
		);
		
		if($donnees->update == 0) {
			$data['idDemande'] = $donnees->idDemande;
			$this->tableGateway->insert($data);
		} else {
			if($this->getResultatExamen($donnees->idDemande)) {
				$this->tableGateway->update($data, array('idDemande' =>$donnees->idDemande));
			}
		}
	}
	
	/**
	 * Examen envoyer
	 */
	public function examenEnvoyer($idDemande)
	{
		$this->tableGateway->update(array('envoyer' => 1), array('idDemande' => $idDemande));
	}

}