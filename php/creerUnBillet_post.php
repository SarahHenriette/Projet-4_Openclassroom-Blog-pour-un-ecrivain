
<?php

require_once('baseDeDonnee.php');
require_once('models/Billet.php');

$bdd = connexionBaseDeDonnee();
$billet= new Billet;

$billet->creer();


redirection('pageAdministrateur.php?mdp=Forteroche');

?>