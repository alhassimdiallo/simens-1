<?php

namespace Facturation\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Predicate\NotIn;
use Zend\Db\Sql\Predicate\Expression;
use Facturation\View\Helper\DateHelper;

class PatientTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function fetchAll() {
		$resultSet = $this->tableGateway->select ();
		return $resultSet;
	}
	public function getPatient($id) {
		$id = ( int ) $id;
		$rowset = $this->tableGateway->select ( array (
				'ID_PERSONNE' => $id
		) );
		$row =  $rowset->current ();
		if (! $row) {
			throw new \Exception ( "Could not find row $id" );
		}
		return $row;
	}
	public function savePatient(Patient $patient) {
		$control = new DateHelper();
		$data = array (
				'civilite' => $patient->civilite,
				'prenom' => $patient->prenom,
				'nom' => $patient->nom,
				'date_naissance' => $Control->convertDateInAnglais($patient->date_naissance),
				'lieu_naissance' => $patient->lieu_naissance,
				'adresse' => $patient->adresse,
				'sexe' => $patient->sexe,
				'nationalite_actuelle' => $patient->nationalite_actuelle,
				'nationalite_origine' => $patient->nationalite_origine,
				'telephone' => $patient->telephone,
				'email' => $patient->email,
				'profession' => $patient->profession,
				'photo' => $patient->photo,
				'date_enregistrement' => $patient->date_enregistrement,

		);

		$id = ( int ) $patient->id_personne;
		if ($id == 0) {
			$this->tableGateway->insert ( $data );
		} else {
			if ($this->getPatient ( $id )) {
				$this->tableGateway->update ( $data, array (
						'ID_PERSONNE' => $id
				) );
			} else {
				throw new \Exception ( 'Patient id does not exist' );
			}
		}
	}
	public function addPatient(Patient $patient, $photo, $date_enregistrement){
		$control = new DateHelper();
		$data = array (
				'civilite' => $patient->civilite,
				'prenom' => $patient->prenom,
				'nom' => $patient->nom,
				'date_naissance' => $control->convertDateInAnglais($patient->date_naissance),
				'lieu_naissance' => $patient->lieu_naissance,
				'adresse' => $patient->adresse,
				'sexe' => $patient->sexe,
				'nationalite_actuelle' => $patient->nationalite_actuelle,
				'nationalite_origine' => $patient->nationalite_origine,
				'telephone' => $patient->telephone,
				'email' => $patient->email,
				'profession' => $patient->profession,
				'photo' => $photo,
				'date_enregistrement' => $date_enregistrement,
		);
		$this->tableGateway->insert ( $data );

	}
	public function addPatientSansPhoto($data){
// 		$control = new DateHelper();
// 		$data = array (
// 				'civilite' => $patient->civilite,
// 				'prenom' => $patient->prenom,
// 				'nom' => $patient->nom,
// 				'date_naissance' => $control->convertDateInAnglais($patient->date_naissance),
// 				'lieu_naissance' => $patient->lieu_naissance,
// 				'adresse' => $patient->adresse,
// 				'sexe' => $patient->sexe,
// 				'nationalite_actuelle' => $patient->nationalite_actuelle,
// 				'nationalite_origine' => $patient->nationalite_origine,
// 				'telephone' => $patient->telephone,
// 				'email' => $patient->email,
// 				'profession' => $patient->profession,
// 				'date_enregistrement' => $date_enregistrement,

// 		);
		return $this->tableGateway->insert ( $data );
	}
	public function deletePatient($id) {
		$this->tableGateway->delete ( array (
				'ID_PERSONNE' => $id
		) );
	}
	function quoteInto($text, $value, $platform, $count = null)
	{
		if ($count === null) {
			return str_replace('?', $platform->quoteValue($value), $text);
		} else {
			while ($count > 0) {
				if (strpos($text, '?') !== false) {
					$text = substr_replace($text, $platform->quoteValue($value), strpos($text, '?'), 1);
				}
				--$count;
			}
			return $text;
		}
	}
	//Réduire la chaine addresse
	function adresseText($Text){
		$chaine = $Text;
		if(strlen($Text)>36){
			$chaine = substr($Text, 0, 36);
			$nb = strrpos($chaine, ' ');
			$chaine = substr($chaine, 0, $nb);
			$chaine .=' ...';
		}
		return $chaine;
	}
	public function getListePatient(){

		$db = $this->tableGateway->getAdapter();

		$aColumns = array('Nom','Prenom','Datenaissance','Sexe', 'Adresse', 'Nationalite', 'id');

		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "id";

		/*
		 * Paging
		*/
		$sLimit = array();
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit[0] = $_GET['iDisplayLength'];
			$sLimit[1] = $_GET['iDisplayStart'];
		}

		/*
		 * Ordering
		*/
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = array();
			$j = 0;
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder[$j++] = $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
								 	".$_GET['sSortDir_'.$i];
				}
			}
		}

		/*
		 * Filtering
		* NOTE this does not match the built-in DataTables filtering which does it
		* word by word on any field. It's possible to do here, but concerned about efficiency
		* on very large tables, and MySQL's regex functionality is very limited
		*/
// 		$sOrWhere = array();
// 		if ( $_GET['sSearch'] != "" )
// 		{
// 			for ( $i=0 ; $i<count($aColumns) ; $i++ )
// 			{
// 				$column = $db->getPlatform()->quoteIdentifier($aColumns[$i]);
// 				$sOrWhere[$i] = $this->quoteInto("$column LIKE ?", "%".$_GET['sSearch']."%", $db->getPlatform());
// 			}
// 		}

// 		$sWhere = array();
// 		$w = 0;
// 		for ( $i=0 ; $i<count($aColumns) ; $i++ )
// 		{
// 			if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
// 			{
// 				$column = $db->getPlatform()->quoteIdentifier($aColumns[$i]);
// 				$sWhere[$w++] = $this->quoteInto("$column LIKE ?", "%".$_GET['sSearch_'.$i]."%", $db->getPlatform());
// 			}
// 		}

		/*
		 * SQL queries
		*/
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('pat' => 'patient'))->columns(array('Nom'=>'NOM','Prenom'=>'PRENOM','Datenaissance'=>'DATE_NAISSANCE','Sexe'=>'SEXE','Adresse'=>'ADRESSE','Nationalite'=>'NATIONALITE_ACTUELLE','Taille'=>'TAILLE','id'=>'ID_PERSONNE'));
		//->0joinLeft(array('u'=> 'utilisateurs'),"u.id=iu.utilisateur_id",array('id','loginUtilisateur'));
		//print $sQuery; exit;
// 		if (count($sOrWhere) > 0){
// 			for ( $i=0 ; $i<count($sOrWhere) ; $i++ )
// 			{
// 				$sQuery->where($sOrWhere[$i]);
// 			}
// 			$where = $sQuery->getRawState('where');
// 			$sQuery->reset('where')
// 			->where(new Expression(implode('', $where)));
// 		}

// 		for ( $i=0 ; $i<count($sWhere) ; $i++ )
// 		{
// 			$sQuery->where($sWhere[$i]);
// 		}

		// 		print $sQuery;

		/* Data set length after filtering */
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$rResultFt = $stat->execute();
		$iFilteredTotal = count($rResultFt);

		/*
		 * Get data to display
		*/
// 		$sQuery->order($sOrder);
// 		if (count($sLimit) > 0){
// 			$sQuery->limit($sLimit[0]);
// 			$sQuery->offset($sLimit[1]);
// 		}
// 		//$stat1 = $sql->prepareStatementForSqlObject($sQuery);
		$rResult = $rResultFt;

		/* Total data set length */
		// 		$sQuery = $db->select()
		// 		->from('hospitalisation', "count($sIndexColumn)");
		// 		$iTotal = $db->fetchOne($sQuery);
		//print($sQuery); exit;
		/*
		 * Output
		*/
		$output = array(
				//"sEcho" => intval($_GET['sEcho']),
				//"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => array()
		);

		/*
		 * $Control pour convertir la date en fran�ais
		 */
		$Control = new DateHelper();


		/*
		 * Pr�parer la liste
		 */
		foreach ( $rResult as $aRow )
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != ' ' )
				{
					/* General output */
					if ($aColumns[$i] == 'Nom'){
						$row[] = "<khass id='nomMaj' style='color: rede;'>".$aRow[ $aColumns[$i]]."</khass>";
					}

				    else if ($aColumns[$i] == 'Datenaissance') {
						$row[] = $Control->convertDate($aRow[ $aColumns[$i] ]);
					}

					else if ($aColumns[$i] == 'Adresse') {
						$row[] = $this->adresseText($aRow[ $aColumns[$i] ]);
					}

					else if ($aColumns[$i] == 'id') {
						$html ="<a href='/simens/public/facturation/info-patient/id_patient/".$aRow[ $aColumns[$i] ]."'>";
						$html .="<img style='display: inline;' src='/simens/public/images_icons/vue.PNG' title='d&eacute;tails'></a>&nbsp;&nbsp;&nbsp;";

						$html .= "<a href='/simens/public/facturation/modifier/id_patient/".$aRow[ $aColumns[$i] ]."'>";
						$html .="<img style='display: inline;' src='/simens/public/images_icons/modifier.PNG' title='Modifier'></a>&nbsp;&nbsp;&nbsp;";

						$html .= "<a href='javascript:envoyer(".$aRow[ $aColumns[$i] ].")'>";
						$html .="<img style='display: inline;' src='/simens/public/images_icons/trash_16.PNG' title='Supprimer'></a>";

						$row[] = $html;
					}

					else {
						$row[] = $aRow[ $aColumns[$i] ];
					}

				}
			}
			$output['aaData'][] = $row;
		}
		//var_dump($output);exit();
		return $output;
	}
	public function tousPatientsAdmis() {
		// $sql = $this->tableGateway->selectWith($select);
	}
	public function listePatients() {
		$adapter = $this->tableGateway->getAdapter ();
		$sql1 = new Sql ( $adapter );
		$subselect = $sql1->select ();
		$subselect->from ( array (
				'd' => 'deces'
		) );
		$subselect->columns ( array (
				'id_personne'
		) );
		$sql2 = new Sql ( $adapter );
		$rowset = $sql2->select ();
		$rowset->from(array (
				'p' => 'patient'
		) );
		$rowset->columns( array (
				'Nom' => 'NOM',
				'Prenom' => 'PRENOM',
				'Datenaissance' => 'DATE_NAISSANCE',
				'Sexe' => 'SEXE',
				'Adresse' => 'ADRESSE',
				'Nationalite' => 'NATIONALITE_ACTUELLE',
				'Taille' => 'TAILLE',
				'Id' => 'ID_PERSONNE'
		) );
		$rowset->where(array (
				'ID_PERSONNE > 800',
				'SEXE =\'FEMININ\'',
				new NotIn ( 'ID_PERSONNE', $subselect )
		) );
		$rowset->order( 'ID_PERSONNE ASC' );
		$statement = $sql2->prepareStatementForSqlObject ( $rowset );
		$result = $statement->execute ();
		return $result;
	}
	public function getPhoto($id) {
		$donneesPatient =  $this->getPatient ( $id );

		$nom = $donneesPatient->photo;
		if ($nom) {
			return $nom . '.jpg';
		} else {
			return 'identite.jpg';
		}
	}
	// LISTE DES PATIENTS SAUF LES PATIENTS DECEDES
	public function laListePatients() {
		$date = new \DateTime ("now");
		$formatDate = $date->format ( 'Y-m-d' );
		$adapter = $this->tableGateway->getAdapter ();
		$sql1 = new Sql ($adapter );
		$subselect1 = $sql1->select ();
		$subselect1->from ( array (
				'd' => 'deces'
		) );
		$subselect1->columns (array (
				'id_personne'
		) );
		$sql2 = new Sql ($adapter);
		$subselect2 = $sql2->select ();
		$subselect2->from ('facturation');
		$subselect2->columns ( array (
				'id_patient'
		) );
		$subselect2->where ( array (
				'date_cons' => $formatDate
		) );
		$sql3 = new Sql($adapter);
		$rowset = $sql3->select ();
		$rowset->from ( array (
				'p' => 'patient'
		) );
		$rowset->columns(array (
				'Nom' => 'NOM',
				'Prenom' => 'PRENOM',
				'Datenaissance' => 'DATE_NAISSANCE',
				'Sexe' => 'SEXE',
				'Adresse' => 'ADRESSE',
				'Nationalite' => 'NATIONALITE_ACTUELLE',
				'Taille' => 'TAILLE',
				'Id' => 'ID_PERSONNE'
		) );
		$rowset->where( array (
				'ID_PERSONNE > 800',
				new NotIn ( 'ID_PERSONNE', $subselect1 ),
				new NotIn ( 'ID_PERSONNE', $subselect2 )
		) );
		$rowset->order('ID_PERSONNE ASC');
		//$req = $sql3->getSqlStringForSqlObject($rowset);
		//var_dump($req); exit();
		$statement = $sql3->prepareStatementForSqlObject($rowset);
		$result = $statement->execute();
		return $result;
	}
	//Modification des donnees du bebe
	public function updatePatientBebe($data)
	{
		$donnees = array(
				'PRENOM' => $data['prenom'],
				'NOM' => $data['nom'],
				'DATE_NAISSANCE' => $data['date_naissance'],
				'LIEU_NAISSANCE' => $data['lieu_naissance'],
				'SEXE' =>$data['sexe'],
				'CIVILITE' =>$data['civilite'],
		);
		$this->tableGateway->update($donnees, array('ID_PERSONNE'=> $data['id_bebe']));
	}

	//Tous les patients qui ont pour ID_PESONNE > 900
	public function tousPatients(){
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->from ( array (
				'p' => 'patient'
		) );
		$select->columns(array (
				'Nom' => 'NOM',
				'Prenom' => 'PRENOM',
				'Datenaissance' => 'DATE_NAISSANCE',
				'Sexe' => 'SEXE',
				'Adresse' => 'ADRESSE',
				'Nationalite' => 'NATIONALITE_ACTUELLE',
				'Taille' => 'TAILLE',
				'Id' => 'ID_PERSONNE'
		) );
		$select->where( array (
				'ID_PERSONNE > 900'
		) );
		$select->order('ID_PERSONNE DESC');

		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		return $result;
	}

	//le nombre de patients qui ont pour ID_PESONNE > 900
	public function nbPatientSUP900(){
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ('patient');
		$select->columns(array ('ID_PERSONNE'));
		$select->where( array (
				'ID_PERSONNE > 900'
		) );
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		return $result->count();
	}
	public function listePays()
	{
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->from(array('nation'=>'nationalite'));
		$select->columns(array ('PAYS', 'PAYS'));
		$select->order('PAYS ASC');
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		foreach ($result as $data) {
			$options[$data['PAYS']] = $data['PAYS'];
		}
		return $options;
	}
}