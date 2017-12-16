<?php
/**
* Fichier de la page article
*
* Contenu :
* 
* Formulaire Ajouter ou modifier un article

*
* article.php est le contrôleur
* article.tpl est la vue
**/

//On crée une session pour récupérer des notifications
session_start();

/* Bibliothèques */
require_once'libs/Smarty.class.php';
require_once 'config/bdd.conf.php';
include 'config/connexion.inc.php';


// Paramètre à récupérer dans l'URL pour modifier ou ajouter un article
// On différencie les champs et le code selon l'ajout ou la modification 
$action = isset($_GET['action']) ? $_GET['action'] : "ajouter";
$id_article = isset($_GET['id_article']) ? $_GET['id_article'] : "";



// Seul un utilisateur connecté peut ajouter/modifier un article
if($is_connect == true){
        
}else{
    header('Location: connexion.php');
    exit();
}
    
    
//Par défaut on met les valeurs que l'on va récupéré par vide
//pour éviter les problèmes de variables non définies 
//que l'on pourrait afficher dans les champs
$titre="";
$texte="";
$publie="";
 

// Si on modifie un article, on insére les valeurs de l'article dans les champs
if($action == "modifier"){
    /**
     * Si la variable action est égale à modifier alors on suit ces instructions
     */

    //Requête pour obtenir les valeurs de l'article à modifié
    $select = "SELECT id, "
            . "titre, "
            . "texte, "
            . "publie "
            . "FROM articles "
            . "WHERE id = :id_article;";
            
    $sth = $bdd->prepare($select);
    $sth->bindValue(':id_article', $id_article,  PDO::PARAM_INT);
  
            
    if($sth->execute() == TRUE){
            
        $tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC);
        
        //On récupère les valeurs de l'article à modifier
        // pour les afficher dans les champs
        
        /* On vide tab_articles pour récupérer les valeurs de l'article */
        foreach ($tab_articles as $value){
            $titre=$value['titre'];
            $texte=$value['texte'];
            $publie=$value['publie'];
        }
               
    }else{
        echo "Une erreur est survenue lors de l'affichage des données de l'article.";
        exit();
    }           
                                 
}   
    
   
if(isset($_POST['submit'])){
    /*
     * Si la variable submit est postée alors on suit ces instructions
     */
    

    
    // attribue la valeur publie si elle est postée sinon elle vaut 0  
    $publie = isset($_POST['publie']) ? $_POST['publie'] : 0;
          

    /* On définit le format de la date */
    $date_du_jour = date("Y-m-d");
    
    if(!empty($_POST['titre']) AND !empty($_POST['texte'])){
        
        /*
         * Si les champs titre et texte ne sont pas vides alors on suit
         * ces instructions
         */
		
	if($_POST['submit'] == "ajouter"){
            
            /*
             * Si la valeur submit est égale à ajouter on suit ces
             * instructions
             */
            
            if(($_FILES) AND $_FILES['image']['error'] == 0){
                
                /*
                 * Si un fichier existe et qu'il n'y a aucune erreur on suit
                 * ces instructions
                 */
                
 		//On récupère l'extension de l'image	
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION); 
          
                //restriction d'extension dans un tableau
                $tab_extensions = array( 
                    'jpg'
                );               
                
                //On vérifie si l'extension est présente dans le tableau
                $result_extension_image = in_array($extension, $tab_extensions);  
                
                if(!$result_extension_image and $_FILES['image']['error'] != 4){
                    
                    /**
                    * Si le fichier n'est pas un fichier jpg et qu'il a été téléchargé alors
                    * on suit ces instructions
                    */
                
                    $notification = '<strong>Erreur de format, l\'image doit être un fichier jpg...</strong>';
                    $_SESSION['notification_color'] = FALSE;	   
			    
                           	
                }else{
                    
                    
                    
                     /* requête insérer l'article */
                    $insert = "INSERT INTO articles (titre, texte, date, publie)"
                           ."VALUES (:titre, :texte, :date, :publie)";

                    $sth = $bdd->prepare($insert);
                    $sth->bindValue(':titre', $_POST['titre'],  PDO::PARAM_STR);
                    $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR);
                    $sth->bindValue(':date', $date_du_jour, PDO::PARAM_STR);
                    $sth->bindValue(':publie', $publie, PDO::PARAM_BOOL);

                    if($sth->execute() == TRUE){
                        
                        /**
                        * Si la requête fonctionne, on suit ces instructions
                        */

                        //On récupère l'id de l'article pour l'associer au nom de l'image
                        $id_article = $bdd->lastInsertId(); 

                        //on upload l'image vers le dossier img avec comme format id.extension
                        move_uploaded_file($_FILES['image']['tmp_name'],'img/' . $id_article . '.' . $extension); 

                        $notification = '<strong>Félicitation, l\'article est inséré...</strong>';
                        $_SESSION['notification_color'] = TRUE;


                        }else{
                            $notification = '<strong>Une erreur est survenue lors de l\'insertion de 
                            l\'article dans la base de données...</strong>';
                            $_SESSION['notification_color'] = FALSE;
                        }                   
                    
                }                
   

            }else{
                $notification = '<strong>Une erreur est survenue lors du traitement
                    de l\'image</strong>';
                $_SESSION['notification_color'] = FALSE;
            }
	
	}else{
		if($_POST['submit'] == "modifier"){
                    /**
                     * Si la valeur submit est égale à modifier alors on suit
                     * ces instructions
                     */
                    
                    /* On récupère l'id de l'article */
                    $id_article = $_POST['store_id_article'];
                    
                    
                    if(($_FILES) AND $_FILES['image']['error'] == 0 or ($_FILES) AND $_FILES['image']['error'] == 4){
                        
                        /*
                         * Si il y a un fichier et qu'il n'y pas d'erreur 
                         * ou aucun fichier alors on suit ces instructions
                         */
                        
			//On récupère l'extension de l'image	
                        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION); 
          
                        //restriction d'extension dans un tableau
                        $tab_extensions = array( 
                            'jpg'
                        );
            
                        //On vérifie si l'extension est présente dans le tableau
                        $result_extension_image = in_array($extension, $tab_extensions); 
           
            
                        if(!$result_extension_image and $_FILES['image']['error'] != 4){
                            /**
                             * Si le fichier n'est pas un fichier jpg et qu'il a été téléchargé alors
                             * on suit ces instructions
                             */
                
                            $notification = '<strong>Erreur de format, l\'image doit être un fichier jpg...</strong>';
                            $_SESSION['notification_color'] = FALSE;	   
			    
                           	
                        }else{
                            
                            /* Si la variable publie existe alors elle prend sa valeur sinon elle vaut 0 */
                            $publie = isset($_POST['publie']) ? $_POST['publie'] : 0;

                            /* Requête pour modifier l'article dans la BDD */
			    $update = "UPDATE articles "
                                    . "SET titre = :titre, "
                                    . "texte = :texte, "
                                    . "publie = :publie "
                                    . "WHERE id  = :id_article;";
                            
           
                            /* On prépare la requête */
                            $sthh = $bdd->prepare($update);
                            $sthh->bindValue(':titre', $_POST['titre'],  PDO::PARAM_STR);
                            $sthh->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR);
                            $sthh->bindValue(':publie', $publie, PDO::PARAM_BOOL);
                            $sthh->bindValue(':id_article', $id_article, PDO::PARAM_INT);
			
			
                            if($sthh->execute() == TRUE){
                                /**
                                 * Si la requête fonctionne, on suit les instructions
                                 */
			
                                
                                //on upload l'image vers le dossier img avec comme format id.extension
                                $tr=move_uploaded_file($_FILES['image']['tmp_name'],'img/' . $id_article . '.' . $extension); 
                                
                                       
                                $notification = '<strong>Félicitation, l\'article a été modifié...</strong>';
                                $_SESSION['notification_color'] = TRUE;		
                        
				 
                            }else{
                             
                                $notification = '<strong>Une erreur est survenue lors de la modification de l\'article...</strong>';
                                $_SESSION['notification_color'] = FALSE;

                            }
                        }
	
		    }else{
                        
 			$notification = '<strong>Erreur lors de l\'upload de l\'image...</strong>';
			$_SESSION['notification_color'] = FALSE;	   

                    }                    
		
		}else{
            
                    $notification = '<strong>Une erreur est survenue lors de la modification de l\'article...</strong>';
                    $_SESSION['notification_color'] = FALSE;			
		}
	}
    }else{
        
        $notification = '<strong>Veuillez renseigner les champs obligatoires...</strong>';
        $_SESSION['notification_color'] = FALSE;
    }
    
    // On renvoie la notification
    $_SESSION['notification'] = $notification; 
  
    if($_POST['submit'] == "modifier"){
        /**
         * si la variable submit est égale à modifier alors on suit
         * ces instructions
         */
        
        /* On renvoie l'utilisateur où il modifier l'article */
        $param = "?action=modifier&id_article=$id_article";
        header("Location: article.php$param");
        //arreter le script 
        exit();
    }
    
    header('Location: article.php');
    exit();
 
}
    

// Créer l'objet smarty en fin de page


//Objet pour lequel on utilise des fonctions
$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');


//permet d'envoyer une variable php à smarty
$smarty->assign('action',$action);
$smarty->assign('publie',$publie);
$smarty->assign('id_article',$id_article);
$smarty->assign('texte',$texte);
$smarty->assign('titre',$titre);

//Contourner le cache de l'explorateur web pour rafraichir l'image des articles
$time=time();
$smarty->assign('time',$time);

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


include 'includes/header.php';
/* l'objet smarty affiche article.tpl */
$smarty->display('article.tpl');
include 'includes/footer.inc.php'; 

?>
