<?php

namespace Controllers ; 


class ControllerBillet{
    public $billets;

    public function __construct(){
        $this->billets = new \Models\ModelBillet;
        
    }//construct

//Affiche page d'accueil
function index(){
$billetParPage = 4;


$req = $this->billets->recupereId("date_creation");
$nbrbillets = $req->rowCount();
$pageTotal = ceil($nbrbillets/$billetParPage);

if(isset($_GET['page']) AND !empty($_GET['page'])){
    $_GET['page']=intval($_GET['page']);

    $pageCourante = $_GET['page'];

} else{
    $pageCourante = 1; 
}


$depart = ($pageCourante-1)*$billetParPage;
$billets = $this->billets->pagination("date_creation", $depart, $billetParPage);
\Renderer::render('index', compact('billets', 'pageTotal', 'pageCourante','s'));

}

//Affiche  un seul billet et ses commentaires
function afficheChapitreEtCommentaire(){    
$Commentaire = new \Models\ModelCommentaire;
$commentaires = $Commentaire->recupereUn("id_billet=?",$_GET["billet"], $booleen=false);
$billet = $this->billets->recupereUn("id=?",$_GET["billet"], $booleen =true);
\Renderer::render('afficheChapitreEtCommentaire', compact( 'billet','commentaires'));
}


//Modifie un billet
function modifier(){
$donnee = $this->billets->recupereUn("id=?",$_GET["billet"], $booleen = true);
\Renderer::render('modifier',compact('donnee'));
//\Http::redirection('index.php?controller=billet&task=pageAdmin');
}

function creer(){   

    \Renderer::render('creerUnBillet');
} 
//creer un billet
function creerPost(){
$donnee= array(
    "titre" => $_POST["Titre"],
    "contenue" => $_POST["Contenue"],
);
$this->billets->ajouter("titre, contenue, date_creation", ":titre, :contenue, NOW()",$donnee);
\Http::redirection('index.php?controller=controllerAdministrateur&task=pageAdmin');
}



function modifierPost(){
    $donnee =array(
        "titre" => $_POST["titre"],
        "contenue" => $_POST["contenue"],
        "id" => $_POST["billet"]
    );
    
    $this->billets->modifier("titre= :titre, contenue= :contenue, date_creation= NOW()", "id=:id", $donnee);
    \Http::redirection('index.php?controller=controllerAdministrateurt&task=pageAdmin');
}


function supprimer(){

    
    $this->billets->supprimer($_GET["billet"]);
    \Http::redirection('index.php?controller=controllerAdministrateur&task=pageAdmin');

}



}



?>

