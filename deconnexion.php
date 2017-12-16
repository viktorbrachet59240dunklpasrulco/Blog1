<?php

/**
* Fichier de destruction du cookie de la connexion de l'utilisateur
* 
**/

/* On supprime le cookie qui contient la connexion de l'utilisateur au site */
setcookie ("sid","",(time() -1));

/*  Envoie l'en-tête HTTP index.php */
header("Location: index.php");
/* termine le script courant */
exit();
?>

