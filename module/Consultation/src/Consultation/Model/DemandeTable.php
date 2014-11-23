<?php
namespace Consultation\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
class DemandeTable{
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getDemande($id){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->columns(array('*'));
		$select->from(array('d'=>'demande'));
		$select->where(array('d.idCons' => $id));
		$select->order('d.idDemande ASC');
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();

		return $result;
	}
	public function updateDemande($examenDemande, $noteExamen)
	{
		$this->tableGateway->delete(array('idCons' => $examenDemande['id_cons']));

		$today = new \DateTime ();
		$date = $today->format ( 'Y-m-d H:i:s' );
		
		for($i=1; $i<14; $i++){
			if($examenDemande[$i]!= "null"){
				$donneesExamenDemande	 = array(
						'idCons' => $examenDemande['id_cons'],
						'idExamen' => $examenDemande[$i],
						'noteDemande' => $noteExamen[$i],
						'dateDemande' => $date,
				);
				$this->tableGateway->insert($donneesExamenDemande);
			}
		}
	}	

}
