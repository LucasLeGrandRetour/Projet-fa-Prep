<?php
include_once 'modeles/BaseCompetenceDAO.php';
include_once 'configBdd.php';

if (isset($_GET['action']))
    $action = filter_var($_GET['action'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
else
    $action = "consultation";


switch ($action) {
    case 'consultation':
        $connexionBDDev = new BaseCompetenceDAO();
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $compSupp = $connexionBDDev->supprimerComptetence($id);
        }
        $lesCompetences = $connexionBDDev->getLesCompetences();
        include_once 'vues/competence.php';
        break;

    case 'recherche':
        $connexionBDDev = new BaseCompetenceDAO();
        if(isset($_POST['texteRecherche'])){
            $txt = $_POST['texteRecherche'];
            $lesCompetences = $connexionBDDev->getCompsRechercher($txt);
        }
        include_once 'vues/recherche.php';
        break;
    }

