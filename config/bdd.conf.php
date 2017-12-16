<?php

/**
* Fichier de configuration de la communication vers
* la base de données
*
* Permet de communiquer avec la base de données
* (Effectuer des requêtes)
* 
**/

try{
    /**
    * Les instructions qu'on souhaite exécuter.
    */
    
    
    /* Paramètres de connexion,host=nom d'hôte dbname=nom de la base,charset=codage de caractères */
    $bdd = new PDO('mysql:host=localhost;dbname=id3641784_blog;charset=utf8','id3641784_viktor592','123456'); 
    /* Au cas où le charset est ignoré on le configure avec set names */
    $bdd->exec("set names utf8");
    /* Place un attribut avec la connexion et on l'utilise pour rapporter les erreurs de la BDD*/
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $e) {
    /**
    *Les instructions à exécuter si une exception est levée dans le bloc try. 
    */
    
    /* On arrete les exécutions et on rapporte le message d'erreur */
    die('Erreur : '. $e->getMessage());
}

?>