<?php

namespace Facturation\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use  Zend\Db\Sql\Predicate\NotIn;

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
				'id_personne' => $id
		) );
		$row = $rowset->current ();
		if (! $row) {
			throw new \Exception ( "Could not find row $id" );
		}
		return $row;
	}
	public function savePatient(Patient $patient) {
		$data = array (
				'prenom' => $patient->prenom,
				'nom' => $patient->nom,
				'date_naissance' => $patient->date_naissance,
				'adresse' => $patient->adresse,
				'sexe' => $patient->sexe,
				'nom' => $patient->nom,
				'nationalite_actuelle' => $patient->nationalite_actuelle
		);

		$id = ( int ) $patient->id_personne;
		if ($id == 0) {
			$this->tableGateway->insert ( $data );
		} else {
			if ($this->getPatient ( $id )) {
				$this->tableGateway->update ( $data, array (
						'id_personne' => $id
				) );
			} else {
				throw new \Exception ( 'Form id does not exist' );
			}
		}
	}
	public function deletePatient($id) {
		$this->tableGateway->delete ( array (
				'id_personne' => $id
		) );
	}
	public function getListePatient() {
		$db = $this->tableGateway;

		$aColumns = array (
				'Nom',
				'Prenom',
				'Datenaissance',
				'Sexe',
				'Adresse',
				'Nationalite',
				'id'
		);

		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "id";

		/*
		 * Paging
		 */
		$sLimit = array ();
		if (isset ( $_GET ['iDisplayStart'] ) && $_GET ['iDisplayLength'] != '-1') {
			$sLimit [0] = $_GET ['iDisplayLength'];
			$sLimit [1] = $_GET ['iDisplayStart'];
		}

		/*
		 * Ordering
		 */
		if (isset ( $_GET ['iSortCol_0'] )) {
			$sOrder = array ();
			$j = 0;
			for($i = 0; $i < intval ( $_GET ['iSortingCols'] ); $i ++) {
				if ($_GET ['bSortable_' . intval ( $_GET ['iSortCol_' . $i] )] == "true") {
					$sOrder [$j ++] = $aColumns [intval ( $_GET ['iSortCol_' . $i] )] . "
								 	" . $_GET ['sSortDir_' . $i];
				}
			}
		}

		/*
		 * Filtering NOTE this does not match the built-in DataTables filtering which does it word by word on any field. It's possible to do here, but concerned about efficiency on very large tables, and MySQL's regex functionality is very limited
		 */
		$sOrWhere = array ();
		// if ( $_GET['sSearch'] != "" )
		// {
		// for ( $i=0 ; $i<count($aColumns) ; $i++ )
		// {
		// $column = $db->quoteIdentifier($aColumns[$i]);
		// $sOrWhere[$i] = $db->quoteInto("$column LIKE ?", "%".$_GET['sSearch']."%");
		// }
		// }

		$sWhere = array ();
		$w = 0;
		// for ( $i=0 ; $i<count($aColumns) ; $i++ )
		// {
		// if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		// {
		// $column = $db->quoteIdentifier($aColumns[$i]);
		// $sWhere[$w++] = $db->quoteInto("$column LIKE ?", "%".$_GET['sSearch_'.$i]."%");
		// }
		// }

		/*
		 * SQL queries
		 */

		$sQuery = $db->select ();
		// ->from(array('pat' => 'patient') ,array('Nom'=>'NOM','Prenom'=>'PRENOM','Datenaissance'=>'DATE_NAISSANCE','Sexe'=>'SEXE','Adresse'=>'ADRESSE','Nationalite'=>'NATIONALITE_ACTUELLE','Taille'=>'TAILLE','id'=>'ID_PERSONNE'));
		if (count ( $sOrWhere ) > 0) {
			for($i = 0; $i < count ( $sOrWhere ); $i ++) {
				$sQuery->orWhere ( $sOrWhere [$i] );
			}
			$where = $sQuery->getPart ( 'where' );
			$sQuery->reset ( 'where' )->where ( new Zend_Db_Expr ( implode ( '', $where ) ) );
		}

		for($i = 0; $i < count ( $sWhere ); $i ++) {
			$sQuery->Where ( $sWhere [$i] );
		}

		// print $sQuery;

		/* Data set length after filtering */
		// $rResultFt = $db->fetchAll($sQuery);
		$rResultFt = $sQuery;
		$iFilteredTotal = count ( $rResultFt );

		/*
		 * Get data to display
		 */
		$sQuery->order ( $sOrder );
		if (count ( $sLimit ) > 0) {
			$sQuery->limit ( $sLimit [0], $sLimit [1] );
		}

		$rResult = $db->fetchAll ( $sQuery );

		$output = array (
				"sEcho" => intval ( $_GET ['sEcho'] ),
				"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => array ()
		);

		/*
		 * $Control pour convertir la date en fran�ais
		 */
		$Control = new Facturation_Model_Helpers_Aides ();

		/*
		 * Pr�parer la liste
		 */
		foreach ( $rResult as $aRow ) {
			$row = array ();
			for($i = 0; $i < count ( $aColumns ); $i ++) {
				if ($aColumns [$i] != ' ') {
					/* General output */
					if ($aColumns [$i] == 'Nom') {
						$row [] = "<khass id='nomMaj' style='color: rede;'>" . $aRow [$aColumns [$i]] . "</khass>";
					}

					else if ($aColumns [$i] == 'Datenaissance') {
						$row [] = $Control->convertDate ( $aRow [$aColumns [$i]] );
					}

					else if ($aColumns [$i] == 'Adresse') {
						$row [] = $this->adresseText ( $aRow [$aColumns [$i]] );
					}

					else if ($aColumns [$i] == 'id') {
						// $html = "<a href='".$this->basePath()."/facturation/Facturation/infopatient/id_patient/".$aRow[ $aColumns[$i] ]."'>";
						$html = "<a href='/simens/public/facturation/info-patient/id_patient/" . $aRow [$aColumns [$i]] . "'>";
						$html .= "<img style='display: inline;' src='/simens/public/images_icons/vue.PNG' title='d&eacute;tails'></a>&nbsp;&nbsp;&nbsp;";

						$html .= "<a href='/simens/public/facturation/modifier/id_patient/" . $aRow [$aColumns [$i]] . "'>";
						$html .= "<img style='display: inline;' src='/simens/public/images_icons/modifier.PNG' title='Modifier'></a>&nbsp;&nbsp;&nbsp;";

						$html .= "<a href='javascript:envoyer(" . $aRow [$aColumns [$i]] . ")'>";
						$html .= "<img style='display: inline;' src='/simens/public/images_icons/trash_16.PNG' title='Supprimer'></a>";

						$row [] = $html;
					}

					else {
						$row [] = $aRow [$aColumns [$i]];
					}
				}
			}
			$output ['aaData'] [] = $row;
		}
		// Zend_Debug::dump($output); exit();
		return $output;
	}
	public function tousPatientsAdmis() {
		// $sql = $this->tableGateway->selectWith($select);
	}
	public function listePatients() {
		$adapter = $this->tableGateway->getAdapter();
		$sql1 = new Sql($adapter);
		$subselect = $sql1->select();
		$subselect->from(array('d'=>'deces'));
		$subselect->columns(array('id_personne'));
		$sql2 = new Sql($adapter);
		$rowset = $sql2->select();
		$rowset->from (array(
				'p' => 'patient'
		) );
		$rowset->columns (array(
				'Nom' => 'p.NOM',
				'Prenom' => 'p.PRENOM',
				'Datenaissance' => 'p.DATE_NAISSANCE',
				'Sexe' => 'p.SEXE',
				'Adresse' => 'p.ADRESSE',
				'Nationalite' => 'p.NATIONALITE_ACTUELLE',
				'Taille' => 'p.TAILLE',
				'Id' => 'p.ID_PERSONNE'
		));
		$rowset->where(array('p.ID_PERSONNE > 800', 'p.SEXE =\'FEMININ\'', new NotIn('p.ID_PERSONNE',$subselect)) );
		$rowset->order ( 'p.ID_PERSONNE ASC' );
		return $rowset;
	}
	public function getPhoto($id){
		$donneesPatient = $this->getPatient($id);

		$nom = $donneesPatient['PHOTO'];
		if($nom){
			return $nom.'.jpg';
		}
		else {return 'identite.jpg';}
	}
}