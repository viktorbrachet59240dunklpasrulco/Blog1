<?php

/**
* Fichier de la page HOME
*
* Contenu :
 * 
* Affichage des articles et des commentaires
* Fonctions Supprimer, modifier un article 
* Formulaire de création de commentaire
*
* Index.php est le contrôleur
* Index.tpl est la vue
**/

//On crée une session pour récupérer des notifications
session_start();


//Fichiers requis pour le bon fonctionnement de la page
require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';
require_once 'includes/fonctions.inc.php';
include 'config/connexion.inc.php';
require_once 'config/bdd.conf.php';
//Classe Smarty
require_once'libs/Smarty.class.php';
include 'includes/header.php';



// On définit le nombre d'article par page
$nb_articles_par_page = 2;
        
// On récupère le numéro de page dans l'URL 
// si la valeur page est posté alors on associe la valeur sinon page vaut 1
$page_courante = isset($_GET['page']) ? $_GET['page'] : 1;
        
/* On récupère l'index avec la fonction pagination */
$index = pagination($page_courante, $nb_articles_par_page);        
        

        
/* Formulaire de suppression d'article */
if(isset($_POST['delete'])){
    /**
     * Si la valeur delete est postée alors on suit ces instructions
     */
    

    /* Requête pour supprimmer un article avec l'id_article*/ 
    $delete = "DELETE articles,commentaire FROM articles "
            ."LEFT JOIN commentaire ON articles.id=commentaire.id_article "
            ."WHERE articles.id = :id_article;";

    /* On prépare la requête */
    $sthh = $bdd->prepare($delete);
    /* On paramètres les variables dans la requête */
    $sthh->bindValue(':id_article', $_POST['store_id_article'], PDO::PARAM_INT);

                        
    if($sthh->execute() == TRUE){
        /**
         * Si la requête fonctionne on suit ces instructions
         */
        
        /* Par défaut l'extension des images sur le site est en jpg */
        $extension="jpg";
        /* On récupère le chemin de l'image correspondant à l'article */
        $path='img/' . $_POST['store_id_article'] . '.' . $extension;
        /* On supprime l'image du dossier img */
        unlink($path);
        
        /*On crée une notification pour informer l'utilisateur de 
         * la suppression de l'article
         */
        $notification = '<strong>L\'article a été supprimé.</strong>';
	$_SESSION['notification_color'] = TRUE;
    }else{
        $notification = '<strong>Erreur lors de la suppression de l\'article...</strong>';
	$_SESSION['notification_color'] = FALSE;
    }
    /*On renvoie la notification */
    $_SESSION['notification'] = $notification;
    header('Location: index.php');
    exit();
}  
 
/* Formulaire ajouter un commentaire */
 if(isset($_POST['submit'])){
     /*
      * Si la valeur submit est postée alors on suit ces instructions
      */

    
     /*requête pour insérer un commentaire dans la BDD */
    $insert = "INSERT INTO commentaire (pseudo, email, commentaire, id_article)"
            ."VALUES (:pseudo, :email, :commentaire, :id_article);";
    
    /* On prépare la requête */
    $sthh = $bdd->prepare($insert);
    /* On paramètre les variables de la requête */
    $sthh->bindValue(':pseudo', $_POST['input_pseudo'],  PDO::PARAM_STR);
    $sthh->bindValue(':email', $_POST['input_email'], PDO::PARAM_STR);
    $sthh->bindValue(':id_article', $_POST['store_id_article'], PDO::PARAM_INT);
    $sthh->bindValue(':commentaire', $_POST['commentaire'], PDO::PARAM_STR);
    
    
    if($sthh->execute() == TRUE){
        /*
         * Si la requête fonctionne, on envoie une notification de réussite
         */
        $notification = '<strong>Félicitation, votre commentaire a été inséré...</strong>';
	$_SESSION['notification_color'] = TRUE;
    }else{
        $notification = '<strong>Erreur lors de l\'insertion du commentaire...</strong>';
	$_SESSION['notification_color'] = FALSE;
    }

    /* On renvoie la notification */                    
    $_SESSION['notification'] = $notification; 
    header('Location: index.php');
    exit();
}  
            

         

/* Formulaire de recherche */

/* Si la recherche existe, associe sa valeur à la variable $recherche
 * sinon on lui donne la valeur vide
 */
$recherche = isset($_GET['recherche']) ? $_GET['recherche'] : "";


if($recherche != ""){
    /**
     * Si la recherche n'est pas vide alors on suit ces instructions
     */
    

    /* On utilise une fonction pour calculer le nombre d'article contenant
     * la recherche 
     */
    $nb_total_article_recherche =  nb_total_article_recherche($bdd,$recherche);

    /* On calcule le nombre de page à créer */
    $nb_pages = ceil($nb_total_article_recherche / $nb_articles_par_page);
        
       
    /*requête select, on va chercher l'article avec ses commentaires dans la BDD */
    $sql = "SELECT "
         ."articles.id, "
         ."articles.texte,"
         ."articles.titre, "
         ."DATE_FORMAT(date, '%d/%m/%Y') as date_fr, "
         ."GROUP_CONCAT(commentaire.pseudo separator ', ') AS pseudos, "
         ."GROUP_CONCAT(commentaire.commentaire separator ', ') AS commentaires, "
         ."COUNT(commentaire.commentaire) AS nb_commentaire "  
         ."FROM articles "
         ."LEFT JOIN commentaire on commentaire.id_article = articles.id "
         ."WHERE publie = :publie AND (titre LIKE :recherche OR texte LIKE :recherche) "  
         ."GROUP BY articles.id "
         ."ORDER BY articles.date DESC "   
         ."LIMIT :index, :nb_articles_par_page;";     

    
    /* On prépare la requête */
    $sth = $bdd->prepare($sql);
    
    /* On paramètre les variables de la requête */
    $sth->bindValue(':recherche', '%'.$recherche.'%', PDO::PARAM_STR);
    $sth->bindValue(':index', $index, PDO::PARAM_INT);
    $sth->bindValue(':publie', 1, PDO::PARAM_BOOL);
    $sth->bindValue(':nb_articles_par_page', $nb_articles_par_page, PDO::PARAM_INT);

    if($sth->execute() == TRUE){
        /*
         * Si la requête fonctionne alors on suit les instructions
         */
        
        /* On retourne le résultat dans un tableau  */
        $tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC);
    

    }else{

        echo 'une erreur est survenue lors la recherche de l\'article...';
        exit();
    };  
}else{
    
    /**
     * Si la recherche est vide alors on suit ces instructions
     */
    

    /* on calcule le nombre d'article publié avec la fonction nb_total_article_publie($bdd)*/
    $nb_total_article_publie =  nb_total_article_publie($bdd);

    /* On calcule le nombre de page à créer */
    $nb_pages = ceil($nb_total_article_publie / $nb_articles_par_page);

    /*requête select, on va chercher l'article avec ses commentaires dans la BDD */
    $select = "SELECT "
            ."articles.id, "
            ."articles.texte,"
            ."articles.titre, "
            ."DATE_FORMAT(date, '%d/%m/%Y') as date_fr, "
            ."GROUP_CONCAT(commentaire.pseudo separator ', ') AS pseudos, "
            ."GROUP_CONCAT(commentaire.commentaire separator ', ') AS commentaires, "
            ."COUNT(commentaire.commentaire) AS nb_commentaire "  
            ."FROM articles "
            ."LEFT JOIN commentaire on commentaire.id_article = articles.id "
            ."WHERE publie = :publie "  
            ."GROUP BY articles.id "
            ."ORDER BY articles.date DESC "   
            ."LIMIT :index, :nb_articles_par_page;";       
        
    /* On prépare la requête */    
    $sth = $bdd->prepare($select);
    $sth->bindValue(':publie', 1, PDO::PARAM_BOOL);
    $sth->bindValue(':index', $index, PDO::PARAM_INT);
    $sth->bindValue(':nb_articles_par_page', $nb_articles_par_page, PDO::PARAM_INT);
    
    if($sth->execute() == TRUE){
        /*
        * Si la requête fonctionne alors on suit les instructions
        */
        
        /* On retourne le résultat dans un tableau  */       
        
        $tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC);
  

    }else{
            echo 'une erreur est survenue lors l\'affichage des l\'articles......';
    }
}





// Créer l'objet smarty en fin de page


//Objet pour lequel on utilise des fonctions
$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');


/* On envoie les variables php à smarty */

$smarty->assign('recherche',$recherche);
$smarty->assign('tab_articles',$tab_articles);
$smarty->assign('nb_pages',$nb_pages);
$smarty->assign('page_courante',$page_courante);

/**On contourne le cache du navigateur web pour rafraichir l'image des articles
* en cas de modification, donc on ajoute le timestamp UNIX actuel à l'image dans
* index.tpl
*/
$time=time();
$smarty->assign('time',$time);


//On regarde si l'utilisateur est connecté pour afficher le bouton "modifier" de l'article ou non.
//is_connect se trouve dans le fichier connexion.inc.php
if(isset($is_connect) AND $is_connect == TRUE){
    $smarty->assign('is_connect',$is_connect);
}else{
    $is_connect = FALSE;
    $smarty->assign('is_connect',$is_connect);
}





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
/* l'objet smarty affiche index.tpl */
$smarty->display('index.tpl');
include 'includes/footer.inc.php';


?>