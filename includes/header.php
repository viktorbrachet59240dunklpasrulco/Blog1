
<?php
/* Fichier de configuration des erreurs php */
require_once 'config/init.conf.php';
?>


       
<html lang="fr">
<!-- L'entête, ou header
Page contenant le titre de chaque pages. 
Sur ce site : la partie verte en haut et le sommair -->

    <head>
    <!-- Contient les informations essentielles à la description du document qui sera affiché dans le corps du document -->
 
        <!-- Type de codage pour éviter les caractéres spéciaux -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <!-- Titre de la page -->
        <title>Mon Blog</title>

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <style>
          body {
            padding-top: 54px;
          }
          @media (min-width: 992px) {
            body {
              padding-top: 56px;
            }
          }

        </style>

    </head>

    <body>
    <!-- Corps de la page -->
  
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <!-- Navigation vers la page index.php -->
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home
                        </a>
                    </li>
                    <!-- Navigation vers la page article.php -->
                    <li class="nav-item">
                        <?php 
                        if($is_connect == true){
                            /**
                             * Si l'utilisateur est connecté alors on affiche la navigation pour ajouter un article
                             */
                            echo  '<a class="nav-link" href="article.php">Ajouter un article</a>';                    
                        } 
                        ?>
                    </li>
                    <!-- Navigation vers inscription .php -->
                    <li class="nav-item">
                        <?php
                        if($is_connect == true){
                            /**
                             * Si l'utlisateur est connecté alors on affiche la navigation pour créer un compte
                             */
                            echo  ' <a class="nav-link" href="inscription.php">Inscription</a>';                       
                        }
                        ?>
                    </li>
                    <!-- Fomulaire de recherche d'article -->
                    <form class="form-inline my-2 my-lg-0" method="get" id="formulaire_recherche" name="formulaire_recherche">
                    <input name="recherche" id="recherche" class="form-control mr-sm-2" type="search" aria-label="Search">
                    <button formaction="index.php" class="btn btn-outline-success my-2 my-sm-0" type="submit">Rechercher</button>
                    </form>
                    <li class="nav-item active">
                        <?php
                        if($is_connect == true){
                            /**
                             * Si l'utilisateur est connecté alors on affiche la navigation vers deconnexion.php
                             */
                            echo '<a class="nav-link" href="deconnexion.php">Déconnexion</a>';
                        }else{ 
                            /**
                             * Si l'utilisateur est déconnecté alors on affiche la navigation vers le formulaire de connexion (connexion.php)
                             */
                            echo '<a class="nav-link" href="connexion.php">Connexion</a>';
                        }
                        ?>     
                    </li>
                </ul>
            </div>
        </div>
    </nav>
