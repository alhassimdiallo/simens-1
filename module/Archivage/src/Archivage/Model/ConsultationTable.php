<?php
namespace Archivage\Model;

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
		return $row;
	}
	public function getConsultationPatient($id_pat){
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns( array( '*' ));
		$select->from( array( 'c' => 'consultation' ));
		$select->join( array('m' => 'medecin'), 'm.ID_PERSONNE = c.ID_PERSONNE' , array('*'));
		$select->join( array('surv' => 'personnel2'), 'surv.ID_PERSONNE = c.ID_SURVEILLANT' , array('NomSurveillant' => 'NOM', 'PrenomSurveillant' => 'PRENOM'));
		$select->join( array('s' => 'service'), 's.ID_SERVICE = c.ID_SERVICE' , array('nomService' => 'NOM', 'domaineService' => 'DOMAINE'));
		$select->where(array('c.PAT_ID_PERSONNE' => $id_pat));
		$select->order('DATEONLY DESC');
		
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
		
		return $result;
	}
	
	public function updateConsultation($values)
	{
		$donnees = array(
				'POIDS' => $values->get ( "poids" )->getValue (), 
				'TAILLE' => $values->get ( "taille" )->getValue (), 
				'TEMPERATURE' => $values->get ( "temperature" )->getValue (), 
				'PRESSION_ARTERIELLE' => $values->get ( "pressionarterielle" )->getValue (), 
				'POULS' => $values->get ( "pouls" )->getValue (), 
				'FREQUENCE_RESPIRATOIRE' => $values->get ( "frequence_respiratoire" )->getValue (), 
				'GLYCEMIE_CAPILLAIRE' => $values->get ( "glycemie_capillaire" )->getValue (), 
		);
		$this->tableGateway->update( $donnees, array('ID_CONS'=> $values->get ( "id_cons" )->getValue ()) );
	}
	
	public function validerConsultation($values){
		$donnees = array(
				'CONSPRISE' => $values['valide'],
				'ID_PERSONNE' => $values['id_personne'],
				'ARCHIVAGE' => 1,
		);
		$this->tableGateway->update($donnees, array('ID_CONS'=> $values['id_cons']));
	}
	
	public function validerFacturation($id_facturation){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->update('facturation')
		->set(array('cons_archive_applique' => 1))
		->where(array('id_facturation' => $id_facturation));
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$stat->execute();
	}
	
	public function addConsultation($values , $IdDuService, $id_medecin){
		$this->tableGateway->getAdapter()->getDriver()->getConnection()->beginTransaction();
		
		try {
			$result = $this->tableGateway->delete(array('ID_CONS' => $values->get ( "id_cons" )->getValue ()));
			
			$dataconsultation = array(
					'ID_CONS'=> $values->get ( "id_cons" )->getValue (), 
					'ID_PERSONNE'=> $id_medecin,
					'PAT_ID_PERSONNE'=> $values->get ( "id_patient" )->getValue (), 
					'DATE'=> $values->get ( "date_cons" )->getValue (), 
					'POIDS' => $values->get ( "poids" )->getValue (), 
					'TAILLE' => $values->get ( "taille" )->getValue (), 
					'TEMPERATURE' => $values->get ( "temperature" )->getValue (), 
					'PRESSION_ARTERIELLE' => $values->get ( "pressionarterielle" )->getValue (), 
					'POULS' => $values->get ( "pouls" )->getValue (), 
					'FREQUENCE_RESPIRATOIRE' => $values->get ( "frequence_respiratoire" )->getValue (), 
					'GLYCEMIE_CAPILLAIRE' => $values->get ( "glycemie_capillaire" )->getValue (), 
					'DATEONLY' => $values->get ( "date_cons" )->getValue (),
					//'HEURECONS' => $values->get ( "heure_cons" )->getValue (),
					'CONSPRISE' => 1,
					'ID_SERVICE' => $IdDuService
			);
			
			$this->tableGateway->insert($dataconsultation);

			//var_dump($dataconsultation); exit();
			$this->tableGateway->getAdapter()->getDriver()->getConnection()->commit();
		} catch (\Exception $e) {
			$this->tableGateway->getAdapter()->getDriver()->getConnection()->rollback();
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
	
	public function addBandelette($bandelettes){
		$values = array();
		if($bandelettes['albumine'] == 1){
			$values[] = array('ID_TYPE_BANDELETTE'=>1, 'ID_CONS'=>$bandelettes['id_cons'], 'CROIX_BANDELETTE'=>(int)$bandelettes['croixalbumine']);
		}
		if($bandelettes['sucre'] == 1){
			$values[] = array('ID_TYPE_BANDELETTE'=>2, 'ID_CONS'=>$bandelettes['id_cons'], 'CROIX_BANDELETTE'=>(int)$bandelettes['croixsucre']);
		}
		if($bandelettes['corpscetonique'] == 1){
			$values[] = array('ID_TYPE_BANDELETTE'=>3, 'ID_CONS'=>$bandelettes['id_cons'], 'CROIX_BANDELETTE'=>(int)$bandelettes['croixcorpscetonique']);
		}
		
		for($i = 0 ; $i < count($values) ; $i++ ){
			$db = $this->tableGateway->getAdapter();
			$sql = new Sql($db);
			$sQuery = $sql->insert()
			->into('bandelette2')
			->columns(array('ID_TYPE_BANDELETTE', 'ID_CONS', 'CROIX_BANDELETTE'))
			->values($values[$i]);
			$stat = $sql->prepareStatementForSqlObject($sQuery);
			$stat->execute();
		}
		
	}
	
	public function getBandelette($id_cons){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from('bandelette2')
		->columns(array('*'))
		->where(array('id_cons' => $id_cons));
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$result = $stat->execute();
		
		$donnees = array();
		$donnees['temoin'] = 0;
		foreach ($result as $resultat){
			if($resultat['ID_TYPE_BANDELETTE'] == 1){
				$donnees['albumine'] = 1; //C'est à coché
				$donnees['croixalbumine'] = $resultat['CROIX_BANDELETTE'];
			}
			if($resultat['ID_TYPE_BANDELETTE'] == 2){
				$donnees['sucre'] = 1; //C'est à coché
				$donnees['croixsucre'] = $resultat['CROIX_BANDELETTE'];
			}
			if($resultat['ID_TYPE_BANDELETTE'] == 3){
				$donnees['corpscetonique'] = 1; //C'est à coché
				$donnees['croixcorpscetonique'] = $resultat['CROIX_BANDELETTE'];
			}
			
			//temoin
			$donnees['temoin'] = 1;
		}
		
		return $donnees;
	}
	
	public function deleteBandelette($id_cons){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->delete()
		->from('bandelette2')
		->where(array('id_cons' => $id_cons));
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$result = $stat->execute();
	}
}