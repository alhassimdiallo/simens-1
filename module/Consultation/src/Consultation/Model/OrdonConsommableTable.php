<?php
namespace Consultation\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\XmlRpc\Value\String;
use Consultation\Model;
class OrdonConsommableTable{
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}

	public function getOrdonnance($id){
		$rowset = $this->tableGateway->select ( array (
				'ID_CONS' => $id
		) );
		$row =  $rowset->current ();
		if (! $row) {
			return $row = null;
		}
		return $row;
	}
	
	public function getMedicamentsParIdOrdonnance($idOrdonnance){
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns( array('*'));
		$select->from( array( 'oc' => 'ordon_consommable' ));
		$select->join( array( 'o' => 'ordonnance'
		), 'oc.ID_DOCUMENT = o.ID_DOCUMENT' , array ('*') );
		$select->where ( array( 'o.ID_DOCUMENT' => $idOrdonnance));
		
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
		
		return $result;
	}

	/**
	 * 
	 * @param $tab : Tableau des médicaments
	 * @param $donnees : Duree traitement et id_cons
	 */
	public function updateOrdonConsommable($tab, $idOrdonnance){
		/**
		 * On supprime d'abord tous les medicaments
		 */
		$this->tableGateway->delete(array("id_document" =>$idOrdonnance));
		
		/**
		 * S'il y a des medicaments on les ajoute sinon on supprime l'ordonnance
		 */
		if($tab) {
			for($i = 1; $i<count($tab); $i++){
				$data = array(
						'id_document'=>$idOrdonnance,
						'id_materiel'=>$tab[$i++],
						'posologie'=>$tab[$i++],
						'quantite'=>$tab[$i],
						//'duree_traitement'=>$tab[$i],
				);
				$this->tableGateway->insert($data);
			}
			return true;
		}else{
			return false;
		}
	}
}
