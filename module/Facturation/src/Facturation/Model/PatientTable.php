<?php
namespace Facturation\Model;

use Zend\Db\TableGateway\TableGateway;

class PatientTable{

	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}
	public function getPatient($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id_personne' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function savePatient(Patient $patient)
	{
		$data = array(
				'prenom' => $patient->prenom,
				'nom'  => $patient->nom,
				'date_naissance'  => $patient->date_naissance,
				'adresse'  => $patient->adresse,
				'sexe'  => $patient->sexe,
				'nom'  => $patient->nom,
				'nationalite_actuelle'  => $patient->nationalite_actuelle,
		);

		$id = (int)$patient->id_personne;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getPatient($id)) {
				$this->tableGateway->update($data, array('id_personne' => $id));
			} else {
				throw new \Exception('Form id does not exist');
			}
		}
	}

	public function deletePatient($id)
	{
		$this->tableGateway->delete(array('id_personne' => $id));
	}
}