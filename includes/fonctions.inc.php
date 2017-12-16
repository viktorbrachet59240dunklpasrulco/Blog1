<?php
/**
* Fichier qui contient des fonctions php
*
* 
* Contenu :
* 
*- Fonction de cryptage
*Permet de crypter un mot de passe 
* 
*-Fonction sid :
*Crée un cookie sur le navigateur web de l'utilisateur
*afin de sauvegarder sa connexion utilisateur au site 
* 
*-Fonction pagination :
*retour d'index pour pagination (à noter qu'il peut être différent selon l'environnement 
*
*-Fonction nb_total_article_publie :
*Retourne le nombre d'article publié
* 
* 
*-Fonction nb_total_article_recherche :
*Retourne le nombre d'article contenant la recherche 
* 
**/


/* Fonction de cryptage */
function cryptPassword($mdp){
    /**
     * On execute la fonction avec un paramètre mdp
     */
    
    /* Calcule le sha1 d'une chaîne de caractères */
    $mdp_crypt = sha1($mdp);
    /* Retourne le résultat */
    return $mdp_crypt;
}


/* Fonction sid */
function sid($email){
    /**
     * On execute la fonction avec un paramètre email
     */
    
    /* Calcule le md5 d'une chaîne et on concaténe avec l'heure actuelle sous la forme d'un horodatage Unix, puis la met en forme à une date */
    $sid = md5($email . time());
    /* Retourne le résultat */
    return $sid;
}


/* Fonction de retour d'index pour pagination */
function pagination($page_courante,$nb_articles_par_page){
    /**
     * On execute la fonction avec deux paramètres
     * le numéro de la page courante et le nombre d'articles par page
     */
    
    /* On calcule l'index */
    $index = ($page_courante-1)*$nb_articles_par_page;
    
    
    /* On renvoie le résultat */
    return $index;
    
}


function nb_total_article_publie($bdd){
    /**
     * On éxecute la fonction avec le paramètre qui contient la connexion à la base de données
     */
    
    /* On crée une requête qui va retourner le nombre d'article publie */
    $sql=" SELECT COUNT(*) as nb_total_article_publie "
        ."FROM articles "
        ."WHERE publie = 1;";
    
    /* On prépare la requête */
    $sth = $bdd->prepare($sql);
    /* On éxecute la requete */
    $sth->execute();
    /* On retourne le résultat dans un tableau */
    $tab_result = $sth->fetch(PDO::FETCH_ASSOC);
    
    /* On retourne le nombre d'article publié sous forme de tableau */
    return $tab_result['nb_total_article_publie'];
}


function nb_total_article_recherche($bdd,$recherche){
    /**
     * On éxecute la fonction avec le paramètre qui contient la connexion à la base de données
     * et la recherche
     */ 
    
     /* On crée une requête qui va retourner le nombre d'article publie contenant la recherche */   
    $sql=" SELECT COUNT(*) as nb_total_article_recherche "
                . "FROM articles "
                . "WHERE (titre LIKE :recherche OR texte LIKE :recherche) "
                . "AND publie = 1;";
    
    
    $sth = $bdd->prepare($sql);
    $sth->bindValue(':recherche', '%'.$recherche.'%', PDO::PARAM_STR);
    $sth->execute();
    $tab_result = $sth->fetch(PDO::FETCH_ASSOC);
    
    return $tab_result['nb_total_article_recherche'];
}

?>