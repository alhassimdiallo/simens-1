<?php
namespace Consultation\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
class DonneesExamensPhysiquesTable{
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getExamensPhysiques($id_cons){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->columns(array('*'));
		$select->from(array('dep'=>'donnees_examen_physiquee'));
		$select->where(array('dep.idcons' => $id_cons));
		$select->order('dep.code_examen ASC');
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();

		return $result;
	}
	public function updateExamenPhysique($donnees)
	{
		$this->tableGateway->delete(array('idcons' => $donnees['id_cons']));

 		for($i=1 ; $i<=5; $i++){ // 5 car on s'arrete a 5 champs de données
 			if($donnees['donnee'.$i]){
 				$datadonnee	 = array(
 						'libelle_examen' => $donnees['donnee'.$i],
 						'idcons' => $donnees['id_cons'],
 				);
 				$this->tableGateway->insert($datadonnee);
 			}
	
		}
	}
}
