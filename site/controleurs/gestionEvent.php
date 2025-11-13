<?php 

include_once "modeles/BaseEvenementDAO.php";
if (isset($_GET['action']))
    $action = filter_var($_GET['action'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
else
    $action = "consultation";


switch ($action) {
    case 'afficherTous' :

    case 'afficherUn' : 
        
}