<?php

/**
* Fichier de connexion utilisateur
*
* Permet de savoir si un utilisateur s'est deja connecté sur le site grâce au cookie
* et affiche une notification sur chaque page pour indiquer que l'utilisateur est connecté
* 
* Contenu :
* 
* Notification avec le nom et prénom de la personne connectée
* Variable $is_connect; qui permet de restreindre l'affichage de certaines fonctionnalitées
* ou de pages sur le site entre un utilisateur connecté et non connecté 
* 
**/

/* On définit par défaut que l'utilisateur arrivant sur le site est deconnecté */
$is_connect = false;
/* Variable qui va contenir un message indiquant à l'utilisateur qu'il est connecté */
$message_con = "";

/* La variable $sid prend la valeur du cookie portant l'index sid s'il existe sinon le sid est vide */
$sid = isset($_COOKIE['sid']) ? $_COOKIE['sid'] : "";


if ($sid != "") {
    /**
    * Si la variable sid est différent de vide on suit ces instructions
    */

    /* On crée une requête pour aller chercher le nom et prénom de l'utilisateur correspondant au sid  */
    $selectsid = "SELECT nom, prenom "
               . "FROM utilisateurs "
               . "WHERE sid = :sid;";
                                       
    /* On prépare la requete la requête select */
    $sth = $bdd->prepare($selectsid);
    /* On associe la valeur du sid au paramétre sid de la base de données */
    $sth->bindValue(':sid', $sid, PDO::PARAM_STR);
    
    if($sth->execute() == TRUE){
        /**
        *Si la requête s'execute correctement, on suit ces instructions 
        */
       
        /* On compte le nombre de ligne trouvé avec la requête selectsid */
        $count = $sth->rowCount();
                            
       if($count > 0){
           /**
           *Si la requête contient au moins une ligne alors on suit ces intructions
           */
           
           /* On met la variable is_connect à true pour indiquer que l'utilisateur est connecté */
           $is_connect = true;
           
           /* On retourne un tableau contenant toutes les lignes du résultat de la requête */
           $tab_user = $sth->fetchAll(PDO::FETCH_ASSOC);
                                
           foreach ($tab_user as $value){
               /**
               *On en revue le tableau tab_user. À chaque itération, la valeur de l'élément courant est assignée à $value 
               *et le pointeur interne de tableau est avancé d'un élément. 
               */
               
               /* On récupére un nom */
               $user_nom = $value['nom'];
               /* On récupére un prenom */
               $user_prenom = $value['prenom'];
               
           }
           
           /* On définit le message_con pour indiquer le prénom et le nom de la personne connectée */
           $message_con = "Connecté en tant que ".$user_prenom." ".$user_nom;
                                
           ?>

           <!-- On crée une notification qui contient le message_con -->
           <div class="col-lg-5 alert alert-info alert-dismissable">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                           <?=$message_con?>
           </div><?php 
                                

                 
       }
    
       
    }else{

        /* On renvoie la variable pour indiquer que l'utilisateur n'est pas connecté au site */
        echo $is_connect;
    }    
    
     
}else{
    /* On renvoie la variable pour indiquer que l'utilisateur n'est pas connecté au site */
     echo $is_connect;
}
       
                                              
?>
