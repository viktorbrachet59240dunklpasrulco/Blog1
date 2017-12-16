<?php
/**
* Formulaire de création de compte utilisateur
* 
* Le fichier contient :
* 
*-Des notifications
*
*-Une requête insert qui va ajouter un utilisateur dans la
* base de données
* 
* inscription.php est le contrôleur
* inscription.tpl est la vue
* 
**/

/* Démarre une nouvelle session ou reprend une session existante
 * Sert en grande partie pour les notifications, car elles sont envoyées
 * de page en page
 */
session_start();


/* Bibliothèques */
require_once'libs/Smarty.class.php';
require_once 'config/bdd.conf.php';
include 'config/connexion.inc.php';
include 'includes/header.php';
require_once 'includes/fonctions.inc.php'; 

    
if($is_connect != true){
    /**
     * Si l'utilisateur n'est pas connecté alors
     * on suit ces instructions
     */
    
    /* Envoie un en-tête HTTP qui est connexion.php */
    header('Location: connexion.php');
    /* On arrete le script */
    exit();       
}

//Fonction de cryptage
if(isset($_POST['submit'])){
    /*
     * Si la valeur submit est postée alors on suit ces 
     * instructions
     */
     
    /* On récupère les valeurs entrées dans le formulaire */
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    
    /* On vérifie si des champs sont vides */
    if(!empty($nom) AND !empty($prenom) AND !empty($email) AND !empty($mdp)){
        
        /**
         * Si les champs ne sont pas vides alors on suit ces instructions
         */
        
        /* On vérifie la taille de la chaine de caractères $nom
         * car il faudra l'insérer dans la base de données et la valeur dans la
         * BDD possède une limite de caractères
         */
        if(strlen($nom)>50){
            /*
             * Si la variable nom contient plus de 50 caractères alors on envoie
             * une notification
             */
            $notification = '<strong>Le nom ne peut pas dépasser 50 caractères</strong>';
            $_SESSION['notification_color'] = FALSE;           
        }else{
            if(strlen($prenom)>50){
                $notification = '<strong>Le prénom ne peut pas dépasser 50 caractères</strong>';
            $_SESSION['notification_color'] = FALSE;
            }else{
                if(strlen($email)>150){
                    $notification = '<strong>L\'email  ne peut pas dépasser 150 caractères</strong>';
            $_SESSION['notification_color'] = FALSE;
                }else{
                    if(strlen($mdp)>150){
                        $notification = '<strong>Le mot de passe ne peut pas dépasser 150 caractères</strong>';
            $_SESSION['notification_color'] = FALSE;
                    }else{
                        /*
                         * Si les variables ne dépassent pas les caractères demandés alors
                         * on suit ces instructions
                         */
                        
                        
                        /* Requête insert, elle va permettre d'insérer un utilisateur dans la BDD */
                        $insert = "INSERT INTO utilisateurs (nom, prenom, email, mdp)"
                                ."VALUES (:nom, :prenom, :email, :mdp)";
                          
                        /* Préparation de la requête insert */
                        $sth = $bdd->prepare($insert);
                        /* On définit les variables de la requête */
                        $sth->bindValue(':nom', $nom,  PDO::PARAM_STR);
                        $sth->bindValue(':prenom', $prenom, PDO::PARAM_STR);
                        $sth->bindValue(':email', $email, PDO::PARAM_STR);
                        $sth->bindValue(':mdp',cryptPassword($_POST['mdp']), PDO::PARAM_STR);
                        
                        if($sth->execute() == TRUE){
                            /*
                             * Si la requête fonctionne alors on suit ces instructions
                             */
                            
                            /* On envoie une notification pour informer l'utilisateur de la création
                             * du compte
                             */
                            $notification = '<strong>Félicitation, votre compte a été créé...</strong>';
                            $_SESSION['notification_color'] = TRUE;
                        }else{
                            $notification = '<strong>Une erreur est survenue lors de l\'inscription dans la BDD...</strong>';
                            $_SESSION['notification_color'] = FALSE;                                    
                        }
                    }
                        
                }
            }
        }
        
    }else{
        $notification = '<strong>Veuillez renseigner les champs obligatoires...</strong>';
        $_SESSION['notification_color'] = FALSE;
        
    }
    /* On renvoie la notification vers une autre page */
    $_SESSION['notification'] = $notification; 
  
    header('Location: inscription.php');
    exit();
}else {
    
}



/* On crée un objet smarty */
$smarty = new Smarty();

/* On définit l'endroit où seront stocker les templates html */
$smarty->setTemplateDir('templates/');
/* On définit l'endroit où seront stocker les templates compilés par smarty */
$smarty->setCompileDir('templates_c/');



//Notification vers smarty
if(isset($_SESSION['notification'])){
    
    /**
    * Si une notification existe alors on suit ces instructions
    */
        
    /* Si la couleur de la notification est vraie alors elle a 
    * pour classe alert-success sinon alert-danger */    
    $notification_result = $_SESSION['notification_color'] == TRUE ? 'alert-success' : 'alert-danger';
    /* Si la notification est différent de vide alors 
    * on prend sa valeur sinon on prend une valeur vide */      
    $notification= $_SESSION['notification'] != "" ? $_SESSION['notification'] : "";
 
    /** On envoie les variables php vers l'objet smarty pour pouvoir les utiliser
    * sur le template html
    */
    $smarty->assign('notification_result',$notification_result);
    $smarty->assign('notification',$notification);
         
         
         
    /* On détruit la notification */     
    unset($_SESSION['notification']);
    unset($_SESSION['notification_color']);
}else{
    
    $notification_result ="";
    $notification ="";
    $smarty->assign('notification_result',$notification_result);
    $smarty->assign('notification',$notification);
}




//** un-comment the following line to show the debug console
//$smarty->debugging = true;
include 'includes/header.php';
/* l'objet smarty affiche inscription.tpl */
$smarty->display('inscription.tpl');
include 'includes/footer.inc.php';

?>
