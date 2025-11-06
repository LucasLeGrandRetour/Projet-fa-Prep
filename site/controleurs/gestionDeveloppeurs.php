<?php
include_once 'modeles/BaseDeveloppeurDAO.php';
include_once 'modeles/Developpeur.php';
include_once 'configBdd.php';

if (isset($_GET['action']))
    $action = filter_var($_GET['action'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
else
    $action = "aPropos";


switch ($action) {
    case 'aPropos':
        $connexionBDDev = new BaseDeveloppeurDAO();
        if(isset($_GET['id']) && isset($_POST['nom']) && isset($_POST['prenom'])){
            $id = $_GET['id'];
            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $dev = new Developpeur($id, $nom, $prenom);
            $modifDeveloppeur = $connexionBDDev->modifierDeveloppeur($dev);
        }else{
            if(isset($_GET['id'])){
                $id = $_GET['id'];
                $devSupp = $connexionBDDev->supprimerDeveloppeur($id);
            }
        }
        $lesDeveloppeurs = $connexionBDDev->getLesDeveloppeurs();
        include_once 'vues/apropos.php';
        break;
    case 'ajout':
        $connexionBDDev = new BaseDeveloppeurDAO();
        if(isset($_POST['nom']) && isset($_POST['prenom'])){
            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $dev = new Developpeur(0, $nom, $prenom);
            $ajoutDeveloppeur = $connexionBDDev->ajouterDeveloppeur($dev);
        }
        include_once 'vues/ajoutDev.php';
        break;
    case 'modifier':
            $connexionBDDev = new BaseDeveloppeurDAO();
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $developp = $connexionBDDev->getLeDeveloppeur($id);
            include_once 'vues/modifDev.php';
        } else {
            $lesDeveloppeurs = $connexionBDDev->getLesDeveloppeurs();
            include_once 'vues/apropos.php';
        }
        break;
}
