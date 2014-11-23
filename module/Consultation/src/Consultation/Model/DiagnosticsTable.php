<?php
namespace Consultation\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
class DiagnosticsTable{
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}

	public function getDiagnostics($id){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from('diagnostics');
		$select->columns(array('*'));
		$select->where(array('idcons'=>$id));
		$select->order('code_diagnostics ASC');
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
		return $result;
	}
	
	public function updateDiagnostics($donnees){
		$this->tableGateway->delete(array('idcons' => $donnees['id_cons']));
		
		for($i=1 ; $i<5; $i++){
			if($donnees['diagnostic'.$i]){
				$donneeDiagnostic = array(
						'libelle_diagnostics' => $donnees['diagnostic'.$i],
						'idcons' => $donnees['id_cons'],
				);
				$this->tableGateway->insert($donneeDiagnostic);
			}
		
		}
	}

}
