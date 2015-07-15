<?php
return array(
    'acl' => array(
    		
        'roles' => array(
        		'guest'   => null,
        		'infirmier' => 'guest',
        		'laborantin' => 'guest',
        		'admin' => 'guest',
        		'facturation' => 'guest',
        		'radiologie' => 'guest',
        		'anesthesie' => 'guest',
        		'major' => 'guest',
        		
        		'surveillant' => 'guest',
        		'medecin'     => 'surveillant',
        		
        		'superAdmin'  => 'medecin'
        ),
    		

    		'resources' => array(
    		
    				'allow' => array(
    						
    						/***
    						 * AdminController
    						 */
    						
    						'Admin\Controller\Admin' => array(
    								'login' => 'guest',
    								'logout' => 'guest',
    								'bienvenue' => 'guest',
    								'modifier-password' => 'guest',
    								'verifier-password' => 'guest',
    								'utilisateurs' => 'superAdmin',
    								'liste-utilisateurs-ajax' => 'superAdmin',
    								'modifier-utilisateur' => 'superAdmin',
    								'liste-agent-personnel-ajax' => 'superAdmin',
    								'visualisation' => 'superAdmin',
    								'nouvel-utilisateur' => 'superAdmin',
    								'verifier-username' => 'superAdmin',

    								'parametrages' => 'superAdmin',
    								'gestion-des-hopitaux' => 'superAdmin',
    								'liste-hopitaux-ajax' => 'superAdmin',
    								'get-departements' => 'superAdmin',
    								'ajouter-hopital' => 'superAdmin',
    								'get-infos-hopital' => 'superAdmin',
    								'get-infos-modification-hopital' => 'superAdmin',
    								
    								'gestion-des-batiments' => 'superAdmin',
    								
    						),
    						
    						
    						/***
    						 * FacturationController
    						 */
    						
    						'Facturation\Controller\Facturation' => array(
    								/*Menu Dosssier*/
    								'ajouter' => 'facturation',
    								'info-patient' => 'facturation',
    								'modifier' => 'facturation',
    								'enregistrement-modification' => 'facturation',
    								'enregistrement' => 'facturation',
    								
    								'liste-patient' => 'facturation',
    								'liste-patient-ajax' => 'facturation',
    								
    								/*Menu Naissance*/
    								'ajouter-naissance' => 'facturation',
    								'lepatient' => 'facturation',
    								'enregistrer-bebe' => 'facturation',
    								'ajouter-naissance-ajax' => 'facturation',
    								
    								'liste-naissance' => 'facturation',
    								'liste-naissance-ajax' => 'facturation',
    								'vue-naissance' => 'facturation',
    								'vue-info-maman' => 'facturation',
    								'modifier-naissance' => 'facturation',
    								
    								/*MENU DECES*/
    								'declarer-deces' => 'facturation',
    								'liste-patient-declaration-deces-ajax' => 'facturation',
    								'le-patient' => 'facturation',
    								
    								'liste-patients-decedes' => 'facturation',
    								'liste-patient-deces-ajax' => 'facturation',
    								'vue-patient-decede' => 'facturation',
    								'modifier-deces' => 'facturation',
    								'supprimer-deces' => 'facturation',
    								
    								/*MENU ADMISSION*/
    								'admission' => 'facturation',
    								'liste-admission-ajax' => 'facturation',
    								'montant' => 'facturation',
    								'enregistrer-admission' => 'facturation',
    								
    								'liste-patients-admis' => 'facturation',
    								'vue-patient-admis' => 'facturation',
    								'supprimer-admission' => 'facturation',
    								'enregistrer-deces' => 'facturation',
    								
    						),
    						
    						
    						/***
    						 * ConsultationController
    						 */

    						'Consultation\Controller\Consultation' => array(
    								//============  SURVEILLANT  ===================
    								'recherche' => 'surveillant',
    								'espace-recherche-surv' => 'surveillant',
    								'maj-consultation' => 'surveillant',
    								'ajout-constantes' => 'surveillant',
    								'ajout-donnees-constantes' => 'surveillant',
    								'maj-cons-donnees' => 'surveillant',
    								
    								//============ MEDECIN =========================
    								'consultation-medecin' => 'medecin',
    								'espace-recherche-med' => 'medecin',
    								'complement-consultation' => 'medecin',
    								'services' => 'medecin',
    								'update-complement-consultation' => 'medecin',
    								'maj-complement-consultation' => 'medecin',
    								'visualisation-consultation' => 'medecin',
    								'visualisation-hospitalisation' => 'medecin',
    								'liste-soins-visualisation-hosp' => 'medecin',
    								
    								'imagesExamensMorphologiques' => 'medecin',
    								'supprimerImage' => 'medecin', 
    								'demande-examen' => 'medecin',
    								'demande-examen-biologique' => 'medecin',
    								
    								'en-cours' => 'medecin',
    								'liste-patient-encours-ajax' => 'medecin',
    								'info-patient' => 'medecin',
    								'detail-info-liberation-patient' => 'medecin',
    								'info-patient-hospi' => 'medecin',
    								'liste-soin' => 'medecin',
    								'supprimer-soin' => 'medecin',
    								'modifier-soin' => 'medecin',
    								'vue-soin-appliquer' => 'medecin',
    								'liberer-patient' => 'medecin',
    								'liste-soins-prescrits' => 'medecin',
    								'recherche-visualisation-consultation' => 'medecin',
    								'enregistrer-examen-du-jour' => 'medecin',
    								'liste-examen-du-jour' => 'medecin',
    								'supprimer-examen-jour' => 'medecin',
    								'vue-examen-jour' => 'medecin',
    								
    								'supprimer-image-morpho' => 'guest', //radiologie et archivage
    								'images-examens-morphologiques' => 'guest', //radiologie et archivage
    								
    								
    								'test-mp3' => 'medecin',
    								'ajouter-mp3' => 'medecin',
    								'afficher-mp3' => 'medecin',
    								'supprimer-mp3' => 'medecin',
    								'inserer-bd-mp3' => 'medecin',
    								
    								/**PDF**/
    								'impression-Pdf' => 'medecin',
    								
    						),
    						
    						
    						/***
    						 * PersonnelController
    						 */
    						
    						'Personnel\Controller\Personnel' => array(
    								'liste-personnel' => 'admin',
    								'liste-personnel-ajax' => 'admin',
    								'info-personnel' => 'admin',
    								'supprimer' => 'admin',
    								'modifier-dossier' => 'admin',
    								'dossier-personnel' => 'admin',
    								
    								'transfert' => 'admin',
    								'liste-personnel-transfert-ajax' => 'admin',
    								'popup-agent-personnel' => 'admin',
    								'vue-agent-personnel' => 'admin',
    								'services' => 'admin',
    								
    								'liste-transfert' => 'admin',
    								'liste-transfert-ajax' => 'admin',
    								'supprimer-transfert' => 'admin',
    								
    								'intervention' => 'admin',
    								'liste-personnel-intervention-ajax' => 'admin',
    								'liste-intervention' => 'admin',
    								'liste-intervention-ajax' => 'admin',
    								'supprimer-transfert' => 'admin',
    								'info-personnel-intervention' => 'admin',
    								'vue-intervention-agent' => 'admin',
    								'supprimer-intervention' => 'admin',
    								'supprimer-une-intervention' => 'admin',
    								'save-intervention' => 'admin',
    								'modifier-intervention-agent' =>'admin',
    						),
    						
    						/***
    						 * HospitalisationController
    						 */
    						
    						'Hospitalisation\Controller\Hospitalisation' => array(
    								
    								'suivi-patient' => 'infirmier',
    								'liste-patient-suivi-ajax' => 'infirmier',
    								'vue-soin-appliquer' => 'infirmier',
    								'administrer-soin-patient' => 'infirmier',
    								'application-soin' => 'infirmier',
    								'raffraichir-liste' => 'infirmier',
    								
    								'en-cours' => 'infirmier',
    								'liste-patient-encours-ajax' => 'infirmier',
    								'liste-soin' => 'infirmier',
    								'supprimer-soin' => 'infirmier',
    								'modifier-soin' => 'infirmier',
    								'detail-info-liberation-patient' => 'infirmier',
    								'liberer-patient' => 'infirmier',
    								'heure-suivante' => 'infirmier',
    								'heure-passee' => 'infirmier',
    								
    								
    								'liste-demandes-examens' => 'laborantin',
    								'liste-demandes-examens-ajax' => 'laborantin',
    								'liste-examens-demander' => 'laborantin', 
    								'vue-examen-appliquer' => 'laborantin',
    								'raffraichir-liste-examens-bio' => 'laborantin',
    								'envoyer-examen-bio' => 'laborantin',
    								
    								'verifier-si-resultat-existe' => 'guest',
    								'modifier-examen' => 'guest',
    								'envoyer-examen' => 'guest',
    								'appliquer-examen' => 'guest',
    								'raffraichir-liste-examens' => 'guest',
    								
    								'liste-examens-effectues' => 'laborantin',
    								'liste-recherche-examens-effectues-ajax' => 'laborantin',

    								
    								'liste-demandes-examens-morpho' => 'radiologie',
    								'liste-demandes-examens-morpho-ajax' => 'radiologie',
    								'liste-examens-demander-morpho' => 'radiologie',
    								'vue-examen-appliquer-morpho' => 'radiologie',
    								'liste-examens-effectues-morpho' => 'radiologie',
    								'liste-recherche-examens-effectues-morpho-ajax' => 'radiologie',
    								'ajouter-examen' => 'radiologie',
    								
    								
    								
    								'liste-demandes-vpa' =>      'anesthesie',
    								'liste-demandes-vpa-ajax' => 'anesthesie',
    								'details-demande-visite' =>  'anesthesie',
    								'save-result-vpa' => 'anesthesie',
    								'liste-recherche-vpa' => 'anesthesie',
    								'liste-recherche-vpa-ajax' => 'anesthesie',
    								'details-recherche-visite' => 'anesthesie',
    								
    								
    								
    								'demande-hospitalisation' => 'major',
    								'liste-liberer-patients' => 'major',
    								'liste-liberer-patient-ajax' => 'major',
    								'liberation-patient' => 'major',
    								'liberer-patient_major' => 'major',
    								'info-patient-liberer' => 'major',
    								
    								'liste-patient-ajax' => 'major',
    								'salles' => 'major',
    								'lits' => 'major',
    								'liste' => 'major',
    								'info-patient' => 'major',
    								'info-patient-hospi' => 'major',
    								
    								'gestion-des-lits' => 'major',
    								'liste-lits-ajax' => 'major',
    								'occuper-lit' => 'major',
    								'liberer-lit' => 'major',
    								'etat-lit' => 'major',
    								'information-patient' => 'major',
    								'info-lit-salle-batiment' => 'major',
     						),
    						
    						
    						/***
    						 * ArchivageController
    						 * ArchivageController
    						 * ArchivageController
    						 * ArchivageController
    						 * ArchivageController
    						 * ArchivageController
    						 * ArchivageController
    						 * ArchivageController
    						 * ArchivageController
    						 * ArchivageController
    						 * ArchivageController
    						*/
    						
    						'Archivage\Controller\Archivage' => array(
    								/* Consultation */
    								'index' => 'medecin',
    								'consulter' => 'medecin',
    								'liste-consultation' => 'medecin',
    								'hospitaliser' => 'medecin',
    								'consultation' => 'medecin', 
    								'update-complement-consultation' => 'medecin', 
    								'visualisation-consultation' => 'medecin',
    								'visualiser-consultation' => 'medecin',
    								
    								/* Facturation*/
    								'ajouter' => 'medecin',
    								'enregistrement' => 'medecin',
    								'liste-dossiers-patients' => 'medecin',
    								'liste-patient-ajax' => 'medecin',
    								'info-dossier-patient' => 'medecin',
    								'modifier' => 'medecin',
    								'enregistrement-modification' => 'medecin',
    								'admission' => 'medecin',
    								'liste-admission-ajax' => 'medecin',
    								'popup-visualisation' => 'medecin',
    								'montant' => 'medecin',
    								'enregistrer-admission' => 'medecin',
    								'liste-admission' => 'medecin',
    								'vue-patient-admis' => 'medecin',
    								'supprimer-admission'  => 'medecin',
    								
    								/* Hospitalisation*/
    								'liste-patient-ajax' => 'medecin',
    								'info-patient' => 'medecin',
    								'info-patient-hospi' => 'medecin',
    								'liste-patient-encours-ajax' => 'medecin',
    								'liste-demande-hospitalisation' => 'medecin',
    								'salles' => 'medecin',
    								'lits' => 'medecin',
    								'services' => 'medecin',
    								'administrer-soin' => 'medecin',
    								'liste-soins-prescrits' => 'medecin',
    								'appliquer-soin' => 'medecin',
    								'liste-patient-suivi-ajax' => 'medecin',
    								'info-patient-suivi' => 'medecin',
    								'administrer-soin-patient' => 'medecin',
    								'vue-soin-appliquer' => 'medecin',
    								'heure-suivante' => 'medecin',
    								'application-soin' => 'medecin',
    								'raffraichir-liste' => 'medecin',
    								'detail-info-liberation-patient' => 'medecin',
    								'liste-demande-hospi-ajax' => 'medecin',
    								'liberer-patient' => 'medecin',
    								
    								/*Radiologie*/
    								'liste-resultats-radiologie' => 'medecin',
    								'liste-recherche-examens-effectues-morpho-ajax' => 'medecin',
    								'liste-examens-demander-morpho' => 'medecin',
    								'verifier-si-resultat-existe' => 'medecin',
    								'vue-examen-appliquer-morpho' => 'medecin',
    								
    								/*Biologie*/
    								'ajouter-resultat-biologique' => 'medecin',
    								'liste-demandes-examens-ajax' => 'medecin',
    								'liste-examens-demander' => 'medecin',
    								'verifier-si-resultat-existe' => 'medecin',
    								'vue-examen-appliquer' => 'medecin',
    								'appliquer-examen' => 'medecin',
    								'raffraichir-liste-examens-bio' => 'medecin',
    								'modifier-examen' => 'medecin',
    								'envoyer-examen-bio' => 'medecin',
    								'liste-resultats-biologie' => 'medecin',
    								'liste-recherche-examens-effectues-ajax' => 'medecin',
    								
    								/*Anesthésie*/
    								'ajouter-resultat-vpa' => 'medecin',
    								'liste-demandes-vpa-ajax' => 'medecin',
    								'details-demande-visite' => 'medecin',
    								'liste-resultats-vpa' => 'medecin',
    								'liste-recherche-vpa-ajax' => 'medecin',
    								'save-result-vpa' => 'medecin',
    								'details-recherche-visite' => 'medecin',
    								
    						),
    				),
    		),
    		
    )
);