<?php
namespace Consultation\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
class MotifAdmissionTable{
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getMotifAdmission($id){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from('motif_admissionn');
		$select->columns(array('Id_motif'=>'id_motif', 'Id_cons'=>'id_cons', 'Libelle_motif'=>'libelle_motif'));
		$select->where(array('id_cons'=>$id));
		$select->order('id_motif ASC');
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
		return $result;
	}
	public function nbMotifs($id){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from('motif_admissionn');
		$select->columns(array('id_motif'));
		$select->where(array('id_cons'=>$id));
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute()->count();
		return $result;
	}
	public function deleteMotifAdmission($id){
		$this->tableGateway->delete(array('id_cons'=>$id));
	}
	public function addMotifAdmission($values){
		for($i=1 ; $i<=5; $i++){ // 5 car on s'arrete a 5 motifs
			if($values['motif_admission'.$i]){
				$datamotifadmission	 = array(
						'libelle_motif' => $values['motif_admission'.$i],
						'id_cons' => $values['id_cons'],
				);
				$this->tableGateway->insert($datamotifadmission);
			}

		}
	}
}
