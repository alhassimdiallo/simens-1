<?php
namespace Consultation\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
class DemandeVisitePreanesthesiqueTable{
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}

	public function getDemandeVisitePreanesthesique($id){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from('demande_visite_preanesthesique');
		$select->columns(array('*'));
		$select->where(array('ID_CONS'=>$id));
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute()->current();
		return $result;
	}
	
	public function updateDemandeVisitePreanesthesique($infoDemande){
		$this->tableGateway->delete(array('ID_CONS'=>$infoDemande['ID_CONS']));
		
		if($infoDemande['diagnostic'] !='' && $infoDemande['intervention_prevue'] !=''){
			$donneesVPA = array(
				'ID_CONS'     => $infoDemande['ID_CONS'],
				'DIAGNOSTIC'  => $infoDemande['diagnostic'],
				'OBSERVATION' => $infoDemande['observation'],
				'INTERVENTION_PREVUE' => $infoDemande['intervention_prevue'],
				'NUMERO_VPA'  => $infoDemande['numero_vpa'],
				'TYPE_ANESTHESIE' => $infoDemande['type_anesthesie'],
			);
			$this->tableGateway->insert($infoDemande);
		}
	}
}
