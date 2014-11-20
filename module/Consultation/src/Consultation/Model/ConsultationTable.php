<?php
namespace Consultation\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

class ConsultationTable {

	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getConsult($id){
		$id = (String) $id;
		$rowset = $this->tableGateway->select ( array (
				'ID_CONS' => $id
		) );
		$row =  $rowset->current ();
 		if (! $row) {
 			throw new \Exception ( "Could not find row $id" );
 		}
	    //\Zend\Debug\Debug::dump($row->id_cons); exit();
		return $row;
	}
	public function getConsultationPatient($id_pat){
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns( array( '*' ));
		$select->from( array( 'c' => 'consultation' ));
		$select->where(array('c.PAT_ID_PERSONNE' =>$id_pat));
		$select->order('DATEONLY DESC');
		
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
		
		return $result;
	}
	public function updateConsultation($values)
	{
		$donnees = array(
				'ID_PERSONNE'=> $values['id_medecin'],
				'PAT_ID_PERSONNE'=> $values['id_patient'],
				'MOTIF_ADMISSION'=> $values['motif_admission'],
				'DATE'=> $values['date_cons'],
				'POIDS' => $values['poids'],
				'TAILLE' => $values['taille'],
				'TEMPERATURE' => $values['temperature'],
				'TENSION' => $values['tension'],
				'POULS' => $values['pouls'],
				'FREQUENCE_RESPIRATOIRE' => $values['frequence_respiratoire'],
				'GLYCEMIE_CAPILLAIRE' => $values['glycemie_capillaire'],
				'BU' => $values['bu'],
				'OBSERVATION'=> $values['observation'],
		);
		$this->tableGateway->update($donnees, array('ID_CONS'=> $values['id_cons']));
	}
	public function validerConsultation($values){
		$donnees = array('CONSPRISE' => $values['valide']);
		$this->tableGateway->update($donnees, array('ID_CONS'=> $values['id_cons']));
	}
	public function addConsultation($values , $IdDuService){
		$this->tableGateway->getAdapter()->getDriver()->getConnection()->beginTransaction();
		try {
			$dataconsultation = array(
					'id_cons'=>$values['id_cons'],
					'id_personne'=> $values['id_medecin'],
					'PAT_ID_PERSONNE'=> $values['id_patient'],
					'MOTIF_ADMISSION'=> $values['motif_admission'],
					'DATE'=> $values['date_cons'],
					'POIDS' => $values['poids'],
					'taille' => $values['taille'],
					'temperature' => $values['temperature'],
					'tension' => $values['tension'],
					'pouls' => $values['pouls'],
					'frequence_respiratoire' => $values['frequence_respiratoire'],
					'glycemie_capillaire' => $values['glycemie_capillaire'],
					'bu' => $values['bu'],
					'observation'=> $values['observation'],
					'DATEONLY' => $values['dateonly'],
					'HEURECONS' => $values['heure_cons'],
					'ID_SERVICE' => $IdDuService
			);
			$this->tableGateway->insert($dataconsultation);

			$this->tableGateway->getAdapter()->getDriver()->getConnection()->commit();
		} catch (\Exception $e) {
			$this->tableGateway->getAdapter()->getDriver()->getConnection()->rollback();
			//Zend_Debug::dump($e->getMessage());
		}
	}
	public function getInfoPatientMedecin($idcons){
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns( array( '*' ));
		$select->from( array( 'c' => 'consultation' ));
		$select->join( array( 
				's' => 'service'
		), 's.ID_SERVICE = c.ID_SERVICE' , array (
				'NomService' => 'NOM',
				'DomaineService' => 'DOMAINE'
		) );
		$select->join( array( 
				'p' => 'patient'
		), 'p.ID_PERSONNE = c.PAT_ID_PERSONNE' , array('*'));
		$select->join( array(
				'm' => 'medecin'
		), 'm.ID_PERSONNE = c.ID_PERSONNE' , array(
				'NomMedecin' => 'NOM', 
				'PrenomMedecin' => 'PRENOM', 
				'AdresseMedecin' => 'ADRESSE',
				'TelephoneMedecin' => 'TELEPHONE'
		));
		$select->where ( array( 'c.ID_CONS' => $idcons));
		
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
		
		return $result;
	}
}