<?php
/**
* Formulaire de connexion utilisateur
* 
* Le fichier contient :
* 
*-Des notifications
*
*-Une requête qui va aller chercher dans la base de données
* un utilisateur ayant la même adresse mail et mot de passe
* 
*-Une requête de modification du sid d'un utilisateur
*
* connexion.php est le contrôleur
* connexion.tpl est la vue 
**/

/* Démarre une nouvelle session ou reprend une session existante
 * Sert en grande partie pour les notifications, car elles sont envoyées
 * de page en page
 */
session_start();

/* Bibliothèques */

require_once'libs/Smarty.class.php';
require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';
require_once 'includes/fonctions.inc.php';
include 'config/connexion.inc.php';


if(isset($_POST['submit'])){
    /**
     * Si la valeur submit a été postée alors on suit ces
     * instructions.
     */
    

    /* Par défaut, on définit le message de notification */
    $notification = '<strong>Aucune notification à afficher</strong>';   
    
    /* On récupère l'email et le mdp envoyés */
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    
    /* Vérifie si les champs email et mdp sont vides */
    if(!empty($email) AND !empty($mdp)){
        
        /**
         * Suit ces instructions si le mdp et l'email ne sont pas vides
         */
        
        /* On crype le mot de passe envoyé, car dans la BDD le mdp est crypté */
        $mdp_hash = cryptPassword($mdp);
        
        /* Requête qui renvoie l'email et le mdp de l'utilisateur ayant le même email et mdp que ceux envoyés */
        $selectUser = "SELECT email, "
                    . "mdp "
                    . "FROM utilisateurs "
                    . "WHERE email = :email "
                    . "AND mdp = :mdp;";
                          
        /* Préparation de la requête select */
        $sth = $bdd->prepare($selectUser);
        /* On paramètre l'email et le mot de passe de la requête */
        $sth->bindValue(':email', $email, PDO::PARAM_STR);
        $sth->bindValue(':mdp',$mdp_hash, PDO::PARAM_STR);
        
        if($sth->execute() == TRUE){
            /*
             * On suit ces instructions si la requête est éxecutée correctement
             */
            
            /* On compte le nombre de ligne retourné par la requête */
            $count = $sth->rowCount();
                                  
            if($count > 0){
                /**
                 * Si le nombre de ligne est supérieur à 0 alors on
                 * suit ces instructions
                 */
                
                /* On place l'email envoyé par l'utilisateur dans une variable sid */                        
                $sid = sid($_POST['email']);
                               
                                                                    
                /* Requête qui va modifier le sid de l'utilisateur ayant l'email envoyée */
                $Update_sid = "UPDATE utilisateurs "
                            . "SET sid = :sid "
                            . "WHERE email = :email ";
                
                $sth_update = $bdd->prepare($Update_sid);
                $sth_update->bindValue(':sid',$sid, PDO::PARAM_STR);
                $sth_update->bindValue(':email',$email, PDO::PARAM_STR);
                                      
                if($sth_update->execute() == TRUE){
                    
                    /* On exécute la fonction setcookie, on envoie un cookie
                     * sur le navigateur de l'utilisateur à partir 
                     * de l'email et on fixe la durée de vie du cookie à 1 jour*/
                    
                    setcookie('sid', $sid, time() + 86400);
                    
                    
                    /* On envoie une notification pour indiquer que l'utilisateur
                     * est connecté au site
                     */
                    $notification = '<strong>Félicitation, vous êtes connecté.</strong>';
                    /* On fixe la couleur de la notification en vert pour indiquer une opération réussite */
                    $_SESSION['notification_color'] = TRUE; 
                    /* On envoie la notification vers la page index.php */
                    $_SESSION['notification'] = $notification; 
                    header("Location: index.php");
                    /* termine le script courant */
                    exit();
                    
                }else{
                    
                    $notification = '<strong>Une erreur technique est survenue...</strong>';
                    $_SESSION['notification_color'] = FALSE;   
                }

            }else{
                
                $notification = '<strong>L\'email ou le mot de passe sont incorrects...</strong>';
                $_SESSION['notification_color'] = FALSE;                                          
            }
                                   
        }else{
            
            $notification = '<strong>Une erreur technique est survenue...</strong>';
            $_SESSION['notification_color'] = FALSE;                 
        }
        
    }else{
           
        $notification = '<strong>Veuillez renseigner les champs obligatoires...</strong>';
        $_SESSION['notification_color'] = FALSE;
        
    }
  
    $_SESSION['notification'] = $notification; 
  
    header('Location: connexion.php');
    exit();
    
}else{
 
    /* On Crée l'objet smarty en fin de page */

    /* Objet pour lequel on utilise des fonctions */
    $smarty = new Smarty();
    
    /* On définit l'endroit où seront stocker les templates html */
    $smarty->setTemplateDir('templates/');
    /* On définit l'endroit où seront stocker les templates compilés par smarty */
    $smarty->setCompileDir('templates_c/');

    

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


    include 'includes/header.php';
    /* l'objet smarty affiche connexion.tpl */
    $smarty->display('connexion.tpl');
    include 'includes/footer.inc.php';

}


?>