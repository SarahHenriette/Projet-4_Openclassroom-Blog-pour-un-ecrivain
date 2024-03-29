<?php

namespace Controllers ; 


class ControllerAdministrateur{


    public function __construct(){
        $this->billets = new \Models\ModelBillet;
        
    }//construct

function formConnexion(){
    \Renderer::render('connexionAdministrateur', compact('billets','donneeAdministrateur'));
}
  
    function connexionPageAdmin(){
        //Je récupére les donnees de l'administrateur
        
        $administrateur = new \Models\ModelAdministrateur;
        $admin = $administrateur->recupereUn("nom = ?",htmlspecialchars($_POST['nom']), $booleen=true);
        //Je vérifie le mot de passe du formulaire avec celui de la bas de donnee
        $motDePasseCorrect = password_verify( htmlspecialchars($_POST['motDePasse']), $admin["motDePasse"]);
      
        if($motDePasseCorrect){
            session_start();
           $_SESSION['admin']=htmlspecialchars($_POST['nom']);
    
            \Http::redirection('index.php?controller=controllerAdministrateur&task=pageAdmin');
            
           
        }else if(!$admin){
            \Http::redirection('index.php');
        }
        
        }
        
        
        
        //Afficher page aministrateur
        function pageAdmin(){
         
            session_start();
       
            //echo $_SESSION['admin'];
                if(!empty($_SESSION['admin'])){
         
                $billets = $this->billets->recupereTout("date_creation");
                //récupere les commentaires signales
                $Commentaire = new \Models\ModelCommentaire;
                $commentairesSignale = $Commentaire->recupereTout("date_commentaire");

                $Administrateur = new \Models\ModelAdministrateur;
                $donneeAdministrateur = $Administrateur->recupereTout("id", true);
            }else{
               \Http::redirection('index.php');
            }
        //Je recupere les billets pour les afficher
        \Renderer::render('pageAdmin', compact('billets','donneeAdministrateur'));
        
        }

     
            
    function deconnexion(){
        session_start();
        unset($_SESSION['admin']);
        
        \Http::redirection('index.php');
    }

    function nouveauAdministrateur(){
    $administrateur = new \Models\ModelAdministrateur;
    $administrateur->ajouter("nom, prenom, motDePasse", ":nom, :prenom, :motDePasse");
    //$administrateur->transmetValeurPourAjouter();
    }
}